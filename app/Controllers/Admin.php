<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use CodeIgniter\API\ResponseTrait;

class Admin extends BaseController
{
    use ResponseTrait;
    
    protected $userModel;
    protected $courseModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        helper('jwt');
    }
    
    public function index(): string
    {
        $data = [
            'courses' => $this->courseModel->getAllCourses(),
            'lecturers' => $this->userModel->where('role', 'lecturer')->findAll(),
            'students' => $this->userModel->where('role', 'student')->findAll(),
        ];
        return view('view_lms/admin/dashboard', $data);
    }
    
    public function dashboard(): string
    {
        return $this->index();
    }
    public function coursesView(): string
    {
        return view('view_lms/admin/courses');
    }
    
    public function studentsView(): string
    {
        return view('view_lms/admin/students');
    }
    
    public function lecturersView(): string
    {
        return view('view_lms/admin/lecturers');
    }
    
    public function enrollmentsView(): string
    {
        return view('view_lms/admin/enrollments');
    }
    
    public function courses()
    {
        $courses = $this->courseModel->getAllCourses();
        return $this->respond([
            'success' => true,
            'data' => $courses
        ], 200);
    }
    
    public function createCourse()
    {
        // Try to get JSON data first, fall back to POST data
        $data = $this->request->getJSON(true);
        
        if (empty($data)) {
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'dosen_id' => $this->request->getPost('dosen_id'),
                'course_code' => $this->request->getPost('course_code')
            ];
        }
        
        if (!isset($data['title']) || empty($data['title'])) {
            return $this->respond(['success' => false, 'message' => 'Title is required'], 400);
        }
        
        if (!isset($data['dosen_id']) || empty($data['dosen_id'])) {
            return $this->respond(['success' => false, 'message' => 'Lecturer is required'], 400);
        }
        
        $lecturer = $this->userModel->find($data['dosen_id']);
        if (!$lecturer || $lecturer['role'] !== 'lecturer') {
            return $this->respond(['success' => false, 'message' => 'Invalid lecturer'], 400);
        }
        
        $result = $this->courseModel->createCourse([
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'dosen_id' => $data['dosen_id'],
            'course_code' => $data['course_code'] ?? null
        ]);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Course created successfully'], 201);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to create course'], 500);
    }
    
    public function updateCourse($id)
    {
        try {
            // Try to get JSON data first, fall back to POST data
            $data = $this->request->getJSON(true);
            
            // If JSON parsing failed, try raw input
            if (empty($data)) {
                $rawInput = file_get_contents('php://input');
                $jsonData = json_decode($rawInput, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data = $jsonData;
                }
            }
            
            // If still empty, try POST data
            if (empty($data)) {
                $data = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'dosen_id' => $this->request->getPost('dosen_id'),
                    'course_code' => $this->request->getPost('course_code')
                ];
            }
            
            log_message('debug', 'UpdateCourse raw input: ' . file_get_contents('php://input'));
            log_message('debug', 'UpdateCourse parsed data: ' . print_r($data, true));
            
            $course = $this->courseModel->find($id);
            if (!$course) {
                return $this->respond(['success' => false, 'message' => 'Course not found'], 404);
            }
            
            if (isset($data['dosen_id']) && !empty($data['dosen_id'])) {
                $lecturer = $this->userModel->find($data['dosen_id']);
                if (!$lecturer || $lecturer['role'] !== 'lecturer') {
                    return $this->respond(['success' => false, 'message' => 'Invalid lecturer'], 400);
                }
            }
            
            $updateData = [];
            if (isset($data['title']) && $data['title'] !== null && $data['title'] !== '') {
                $updateData['title'] = $data['title'];
            }
            if (isset($data['description'])) {
                $updateData['description'] = $data['description'];
            }
            if (isset($data['dosen_id']) && $data['dosen_id'] !== null && $data['dosen_id'] !== '') {
                $updateData['dosen_id'] = $data['dosen_id'];
            }
            if (isset($data['course_code']) && $data['course_code'] !== null && $data['course_code'] !== '') {
                $updateData['course_code'] = $data['course_code'];
            }
            
            if (empty($updateData)) {
                return $this->respond(['success' => false, 'message' => 'No data to update'], 400);
            }
            
            log_message('debug', 'UpdateCourse updateData: ' . print_r($updateData, true));
            
            $result = $this->courseModel->updateCourse($id, $updateData);
            
            if ($result) {
                return $this->respond(['success' => true, 'message' => 'Course updated successfully'], 200);
            }
            
            return $this->respond(['success' => false, 'message' => 'Failed to update course'], 500);
        } catch (\Exception $e) {
            log_message('error', 'UpdateCourse error: ' . $e->getMessage());
            return $this->respond(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    
    public function deleteCourse($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            return $this->respond(['success' => false, 'message' => 'Course not found'], 404);
        }
        
        $result = $this->courseModel->deleteCourse($id);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Course deleted successfully'], 200);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to delete course'], 500);
    }
    
    public function lecturers()
    {
        $lecturers = $this->userModel->where('role', 'lecturer')->findAll();
        return $this->respond([
            'success' => true,
            'data' => $lecturers
        ], 200);
    }
    
    public function createLecturer()
    {
        $data = $this->request->getJSON(true);
        
        if (!isset($data['name']) || empty($data['name'])) {
            return $this->respond(['success' => false, 'message' => 'Name is required'], 400);
        }
        
        if (!isset($data['email']) || empty($data['email'])) {
            return $this->respond(['success' => false, 'message' => 'Email is required'], 400);
        }
        
        if (!isset($data['password']) || empty($data['password'])) {
            return $this->respond(['success' => false, 'message' => 'Password is required'], 400);
        }
        
        $existingUser = $this->userModel->findByEmail($data['email']);
        if ($existingUser) {
            return $this->respond(['success' => false, 'message' => 'Email already exists'], 400);
        }
        
        // Generate custom user ID (e.g., L001, L002)
        $userId = $this->userModel->generateUserId('lecturer');
        
        $result = $this->userModel->insert([
            'id' => $userId,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->userModel->hashPassword($data['password']),
            'role' => 'lecturer',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Lecturer account created successfully'], 201);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to create lecturer account'], 500);
    }
    
    public function updateLecturer($id)
    {
        $lecturer = $this->userModel->find($id);
        if (!$lecturer || $lecturer['role'] !== 'lecturer') {
            return $this->respond(['success' => false, 'message' => 'Lecturer not found'], 404);
        }
        
        $data = $this->request->getJSON(true);
        
        if (empty($data)) {
            return $this->respond(['success' => false, 'message' => 'No data provided'], 400);
        }
        
        $updateData = [];
        
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['email'])) {
            $existingUser = $this->userModel->findByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $id) {
                return $this->respond(['success' => false, 'message' => 'Email already exists'], 400);
            }
            $updateData['email'] = $data['email'];
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['password'] = $this->userModel->hashPassword($data['password']);
        }
        
        $result = $this->userModel->update($id, $updateData);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Lecturer updated successfully'], 200);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to update lecturer'], 500);
    }
    
    public function deleteLecturer($id)
    {
        $lecturer = $this->userModel->find($id);
        if (!$lecturer || $lecturer['role'] !== 'lecturer') {
            return $this->respond(['success' => false, 'message' => 'Lecturer not found'], 404);
        }
        
        $result = $this->userModel->delete($id);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Lecturer deleted successfully'], 200);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to delete lecturer'], 500);
    }
    
    public function students()
    {
        $students = $this->userModel->where('role', 'student')->findAll();
        return $this->respond([
            'success' => true,
            'data' => $students
        ], 200);
    }
    
    public function enrollments()
    {
        $db = \Config\Database::connect();
        $enrollments = $db->table('enrollments')
            ->select('enrollments.*, users.name as student_name, users.email as student_email, courses.title as course_title')
            ->join('users', 'users.id = enrollments.mahasiswa_id')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->get()
            ->getResultArray();
        
        return $this->respond([
            'success' => true,
            'data' => $enrollments
        ], 200);
    }
}
