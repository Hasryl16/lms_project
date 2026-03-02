<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\ModuleModel;
use App\Models\MaterialModel;
use App\Models\AssignmentModel;
use App\Models\SubmissionModel;
use CodeIgniter\API\ResponseTrait;

class Student extends BaseController
{
    use ResponseTrait;
    
    protected $userModel;
    protected $courseModel;
    protected $moduleModel;
    protected $materialModel;
    protected $assignmentModel;
    protected $submissionModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        $this->moduleModel = new ModuleModel();
        $this->materialModel = new MaterialModel();
        $this->assignmentModel = new AssignmentModel();
        $this->submissionModel = new SubmissionModel();
        helper('jwt');
    }
    
    private function getCurrentStudentId()
    {
        $session = session();
        $userId = $session->get('user_id');
        
        if (!$userId) {
            // First, try to get token from session
            $token = $session->get('token');
            
            // If no token in session, check Authorization header (for AJAX requests)
            if (!$token) {
                $authHeader = $this->request->getHeader('Authorization');
                if ($authHeader && $authHeader->getValue()) {
                    $authValue = $authHeader->getValue();
                    // Remove "Bearer " prefix if present
                    if (stripos($authValue, 'Bearer ') === 0) {
                        $token = substr($authValue, 7);
                    } else {
                        $token = $authValue;
                    }
                }
            }
            
            // If still no token, check cookie (for regular page loads)
            if (!$token) {
                $token = $this->request->getCookie('authToken');
            }
            
            if ($token) {
                $decoded = validateJWT($token);
                if ($decoded && isset($decoded->data)) {
                    $userId = $decoded->data->id ?? null;
                }
            }
        }
        
        return $userId;
    }
    
    public function index(): string
    {
        return $this->dashboard();
    }
    
    public function dashboard(): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $enrolledCount = $db->table('enrollments')
            ->where('mahasiswa_id', $studentId)
            ->countAllResults();
        
        $pendingAssignments = $db->table('submissions')
            ->select('assignments.*, modules.title as module_title, courses.title as course_title')
            ->join('assignments', 'assignments.id = submissions.assignment_id')
            ->join('modules', 'modules.id = assignments.module_id')
            ->join('courses', 'courses.id = modules.course_id')
            ->join('enrollments', 'enrollments.course_id = courses.id')
            ->where('submissions.mahasiswa_id', $studentId)
            ->where('submissions.score IS NULL')
            ->countAllResults();
        
        $gradedCount = $db->table('submissions')
            ->where('mahasiswa_id', $studentId)
            ->where('score IS NOT NULL')
            ->countAllResults();
        
        $recentGrades = $db->table('submissions')
            ->select('submissions.*, assignments.title as assignment_title, assignments.max_score, courses.title as course_title')
            ->join('assignments', 'assignments.id = submissions.assignment_id')
            ->join('modules', 'modules.id = assignments.module_id')
            ->join('courses', 'courses.id = modules.course_id')
            ->where('submissions.mahasiswa_id', $studentId)
            ->where('submissions.score IS NOT NULL')
            ->orderBy('submissions.submitted_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        $data = [
            'enrolledCount' => $enrolledCount,
            'pendingAssignments' => $pendingAssignments,
            'gradedCount' => $gradedCount,
            'recentGrades' => $recentGrades,
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/dashboard', $data);
    }
    
    public function browse(): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $enrolledCourseIds = $db->table('enrollments')
            ->where('mahasiswa_id', $studentId)
            ->select('course_id')
            ->get()
            ->getResultArray();
        
        $enrolledIds = array_column($enrolledCourseIds, 'course_id');
        
        // Only apply whereNotIn if there are enrolled courses
        $coursesQuery = $db->table('courses')
            ->select('courses.*, users.name as lecturer_name')
            ->join('users', 'users.id = courses.dosen_id', 'left');
        
        if (!empty($enrolledIds)) {
            $coursesQuery->whereNotIn('courses.id', $enrolledIds);
        }
        
        $courses = $coursesQuery->get()->getResultArray();
        
        $data = [
            'courses' => $courses,
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/browse', $data);
    }
    
    public function myCourses(): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $courses = $db->table('courses')
            ->select('courses.*, users.name as lecturer_name, users.email as lecturer_email, enrollments.enrolled_at')
            ->join('users', 'users.id = courses.dosen_id', 'left')
            ->join('enrollments', 'enrollments.course_id = courses.id')
            ->where('enrollments.mahasiswa_id', $studentId)
            ->get()
            ->getResultArray();
        
        foreach ($courses as &$course) {
            $course['module_count'] = $db->table('modules')
                ->where('course_id', $course['id'])
                ->countAllResults();
        }
        
        $data = [
            'courses' => $courses,
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/my-courses', $data);
    }
    
    public function enrollCourse()
    {
        $studentId = $this->getCurrentStudentId();
        
        if (!$studentId) {
            return $this->respond(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        // Support both JSON and FormData requests
        $contentType = $this->request->getHeader('Content-Type');
        $data = null;
        
        if ($contentType && strpos($contentType->getValue(), 'application/json') !== false) {
            $data = $this->request->getJSON(true);
        } else {
            // Handle FormData
            $data = [
                'course_id' => $this->request->getPost('course_id'),
                'course_code' => $this->request->getPost('course_code')
            ];
        }
        
        $db = \Config\Database::connect();
        
        if (isset($data['course_code']) && !empty($data['course_code'])) {
            $courseCode = strtoupper(trim($data['course_code']));
            
            $course = $db->table('courses')
                ->where('course_code', $courseCode)
                ->get()
                ->getRow();
            
            if (!$course) {
                return $this->respond(['success' => false, 'message' => 'Course not found with this code'], 404);
            }
            
            $existingEnrollment = $db->table('enrollments')
                ->where('course_id', $course->id)
                ->where('mahasiswa_id', $studentId)
                ->get()
                ->getRow();
            
            if ($existingEnrollment) {
                return $this->respond(['success' => false, 'message' => 'Already enrolled in this course'], 400);
            }
            
            $db->table('enrollments')->insert([
                'course_id' => $course->id,
                'mahasiswa_id' => $studentId,
                'enrolled_at' => date('Y-m-d H:i:s')
            ]);
            
            return $this->respond(['success' => true, 'message' => 'Successfully enrolled in course: ' . $course->title], 200);
        }
        
        if (isset($data['course_id']) && !empty($data['course_id'])) {
            $courseId = $data['course_id'];
            
            $course = $db->table('courses')
                ->where('id', $courseId)
                ->get()
                ->getRow();
            
            if (!$course) {
                return $this->respond(['success' => false, 'message' => 'Course not found'], 404);
            }
            
            $existingEnrollment = $db->table('enrollments')
                ->where('course_id', $courseId)
                ->where('mahasiswa_id', $studentId)
                ->get()
                ->getRow();
            
            if ($existingEnrollment) {
                return $this->respond(['success' => false, 'message' => 'Already enrolled in this course'], 400);
            }
            
            $db->table('enrollments')->insert([
                'course_id' => $courseId,
                'mahasiswa_id' => $studentId,
                'enrolled_at' => date('Y-m-d H:i:s')
            ]);
            
            return $this->respond(['success' => true, 'message' => 'Successfully enrolled in course: ' . $course->title], 200);
        }
        
        return $this->respond(['success' => false, 'message' => 'Course ID or course code is required'], 400);
    }
    
    public function unenrollCourse($courseId)
    {
        $studentId = $this->getCurrentStudentId();
        
        if (!$studentId) {
            return $this->respond(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $db = \Config\Database::connect();
        
        $db->table('enrollments')
            ->where('course_id', $courseId)
            ->where('mahasiswa_id', $studentId)
            ->delete();
        
        return $this->respond(['success' => true, 'message' => 'Successfully unenrolled from course'], 200);
    }
    
    public function courseDetail($courseId): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $course = $db->table('courses')
            ->select('courses.*, users.name as lecturer_name, users.email as lecturer_email')
            ->join('users', 'users.id = courses.dosen_id', 'left')
            ->where('courses.id', $courseId)
            ->get()
            ->getRow();
        
        if (!$course) {
            return view('errors/html/error_404');
        }
        
        $modules = $db->table('modules')
            ->where('course_id', $courseId)
            ->get()
            ->getResultArray();
        
        foreach ($modules as &$module) {
            $module['materials'] = $db->table('materials')
                ->where('module_id', $module['id'])
                ->get()
                ->getResultArray();
            
            $module['assignments'] = $db->table('assignments')
                ->where('module_id', $module['id'])
                ->get()
                ->getResultArray();
        }
        
        $data = [
            'course' => $course,
            'modules' => $modules,
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/course-detail', $data);
    }
    
    public function assignments(): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $assignments = $db->table('assignments')
            ->select('assignments.*, modules.title as module_title, courses.title as course_title, courses.id as course_id')
            ->join('modules', 'modules.id = assignments.module_id')
            ->join('courses', 'courses.id = modules.course_id')
            ->join('enrollments', 'enrollments.course_id = courses.id')
            ->where('enrollments.mahasiswa_id', $studentId)
            ->get()
            ->getResultArray();
        
        $submissions = $db->table('submissions')
            ->where('mahasiswa_id', $studentId)
            ->get()
            ->getResultArray();
        
        $submissionMap = [];
        foreach ($submissions as $sub) {
            $submissionMap[$sub['assignment_id']] = $sub;
        }
        
        $pending = [];
        $submitted = [];
        $graded = [];
        
        foreach ($assignments as $assignment) {
            $assignment['submission'] = $submissionMap[$assignment['id']] ?? null;
            
            if (isset($submissionMap[$assignment['id']])) {
                $submission = $submissionMap[$assignment['id']];
                if ($submission['score'] !== null) {
                    $graded[] = $assignment;
                } else {
                    $submitted[] = $assignment;
                }
            } else {
                $pending[] = $assignment;
            }
        }
        
        $data = [
            'pending' => $pending,
            'submitted' => $submitted,
            'graded' => $graded,
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/assignments', $data);
    }
    
    public function submitAssignment($assignmentId)
    {
        $studentId = $this->getCurrentStudentId();
        
        if (!$studentId) {
            return $this->respond(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        // Support both JSON and FormData requests
        $contentType = $this->request->getHeader('Content-Type');
        
        if ($contentType && strpos($contentType->getValue(), 'application/json') !== false) {
            $data = $this->request->getJSON(true);
        } else {
            // Handle FormData
            $data = [
                'answer_text' => $this->request->getPost('answer_text')
            ];
        }
        
        if (!isset($data['answer_text']) || empty($data['answer_text'])) {
            return $this->respond(['success' => false, 'message' => 'Answer text is required'], 400);
        }
        
        $db = \Config\Database::connect();
        
        $existingSubmission = $db->table('submissions')
            ->where('assignment_id', $assignmentId)
            ->where('mahasiswa_id', $studentId)
            ->get()
            ->getRow();
        
        if ($existingSubmission) {
            $db->table('submissions')
                ->where('id', $existingSubmission->id)
                ->update([
                    'answer_text' => $data['answer_text'],
                    'submitted_at' => date('Y-m-d H:i:s')
                ]);
            
            return $this->respond(['success' => true, 'message' => 'Assignment updated successfully'], 200);
        }
        
        $db->table('submissions')->insert([
            'assignment_id' => $assignmentId,
            'mahasiswa_id' => $studentId,
            'answer_text' => $data['answer_text'],
            'submitted_at' => date('Y-m-d H:i:s')
        ]);
        
        return $this->respond(['success' => true, 'message' => 'Assignment submitted successfully'], 201);
    }
    
    public function grades(): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $submissions = $db->table('submissions')
            ->select('submissions.*, assignments.title as assignment_title, assignments.max_score, modules.title as module_title, courses.title as course_title, courses.id as course_id')
            ->join('assignments', 'assignments.id = submissions.assignment_id')
            ->join('modules', 'modules.id = assignments.module_id')
            ->join('courses', 'courses.id = modules.course_id')
            ->join('enrollments', 'enrollments.course_id = courses.id')
            ->where('submissions.mahasiswa_id', $studentId)
            ->where('submissions.score IS NOT NULL')
            ->orderBy('submissions.submitted_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $courseGrades = [];
        $totalScore = 0;
        $totalMaxScore = 0;
        
        foreach ($submissions as $submission) {
            $courseId = $submission['course_id'];
            
            if (!isset($courseGrades[$courseId])) {
                $courseGrades[$courseId] = [
                    'course_title' => $submission['course_title'],
                    'submissions' => [],
                    'total_score' => 0,
                    'total_max' => 0
                ];
            }
            
            $courseGrades[$courseId]['submissions'][] = $submission;
            $courseGrades[$courseId]['total_score'] += $submission['score'];
            $courseGrades[$courseId]['total_max'] += $submission['max_score'];
            
            $totalScore += $submission['score'];
            $totalMaxScore += $submission['max_score'];
        }
        
        foreach ($courseGrades as &$course) {
            if ($course['total_max'] > 0) {
                $course['percentage'] = round(($course['total_score'] / $course['total_max']) * 100);
                $course['letter_grade'] = $this->getLetterGrade($course['percentage']);
            } else {
                $course['percentage'] = 0;
                $course['letter_grade'] = 'N/A';
            }
        }
        
        $overallAverage = $totalMaxScore > 0 ? round(($totalScore / $totalMaxScore) * 100) : 0;
        
        $data = [
            'courseGrades' => $courseGrades,
            'submissions' => $submissions,
            'overallAverage' => $overallAverage,
            'overallLetterGrade' => $this->getLetterGrade($overallAverage),
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/grades', $data);
    }
    
    private function getLetterGrade($percentage)
    {
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
    
    public function getGradeBadgeColor($grade)
    {
        if (str_starts_with($grade, 'A')) return 'bg-success';
        if (str_starts_with($grade, 'B')) return 'bg-primary';
        if (str_starts_with($grade, 'C')) return 'bg-warning';
        return 'bg-danger';
    }
    
    public function getScoreColor($percentage)
    {
        if ($percentage >= 90) return 'text-success';
        if ($percentage >= 80) return 'text-primary';
        if ($percentage >= 70) return 'text-warning';
        return 'text-danger';
    }
    
    public function moduleDetail($moduleId): string
    {
        $studentId = $this->getCurrentStudentId();
        
        $db = \Config\Database::connect();
        
        $module = $db->table('modules')
            ->select('modules.*, courses.title as course_title, courses.id as course_id')
            ->join('courses', 'courses.id = modules.course_id')
            ->where('modules.id', $moduleId)
            ->get()
            ->getRow();
        
        if (!$module) {
            return view('errors/html/error_404');
        }
        
        $materials = $db->table('materials')
            ->where('module_id', $moduleId)
            ->get()
            ->getResultArray();
        
        $assignments = $db->table('assignments')
            ->where('module_id', $moduleId)
            ->get()
            ->getResultArray();
        
        foreach ($assignments as &$assignment) {
            $submission = $db->table('submissions')
                ->where('assignment_id', $assignment['id'])
                ->where('mahasiswa_id', $studentId)
                ->get()
                ->getRow();
            
            $assignment['submission'] = $submission;
        }
        
        $data = [
            'module' => $module,
            'materials' => $materials,
            'assignments' => $assignments,
            'studentId' => $studentId
        ];
        
        return view('view_lms/student/module-detail', $data);
    }
}
