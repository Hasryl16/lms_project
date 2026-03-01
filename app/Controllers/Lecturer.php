<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\ModuleModel;
use App\Models\MaterialModel;
use App\Models\AssignmentModel;
use App\Models\SubmissionModel;

class Lecturer extends BaseController
{
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
    }
    
    private function checkAuth()
    {
        // Check Authorization header first
        $token = $this->request->getHeaderLine('Authorization');
        
        // If no header token, check cookie
        if (empty($token)) {
            $token = $this->request->getCookie('authToken');
        }
        
        // If still no token, check session
        if (empty($token)) {
            $token = session()->get('authToken');
        }
        
        if (!$token) {
            if ($this->request->isAJAX()) {
                return ['error' => 'Unauthorized', 'status' => 401];
            }
            return ['redirect' => '/login', 'status' => 'redirect'];
        }
        
        // Remove 'Bearer ' prefix if present
        $token = str_replace('Bearer ', '', $token);
        
        $user = validateJWT($token);
        
        if (!$user || (isset($user->data->role) && $user->data->role !== 'lecturer')) {
            if ($this->request->isAJAX()) {
                return ['error' => 'Unauthorized', 'status' => 401];
            }
            return ['redirect' => '/login', 'status' => 'redirect'];
        }
        
        return ['user' => (array) $user->data, 'status' => 'ok'];
    }
    
    public function index()
    {
        return view('view_lms/lecturer/dashboard');
    }
    
    public function dashboard()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        $totalCourses = count($courses);
        $totalModules = 0;
        $totalAssignments = 0;
        
        foreach ($courses as $course) {
            $modules = $this->moduleModel->getModulesByCourse($course['id']);
            $totalModules += count($modules);
            foreach ($modules as $module) {
                $assignments = $this->assignmentModel->getAssignmentsByModule($module['id']);
                $totalAssignments += count($assignments);
            }
        }
        
        $data = [
            'user' => $user,
            'courses' => $courses,
            'totalCourses' => $totalCourses,
            'totalModules' => $totalModules,
            'totalAssignments' => $totalAssignments
        ];
        
        return view('view_lms/lecturer/dashboard', $data);
    }
    
    // ==================== COURSES ====================
    
    public function courses()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        return view('view_lms/lecturer/courses', ['courses' => $courses, 'user' => $user]);
    }
    
    public function getCourses()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        return $this->response->setJSON(['courses' => $courses]);
    }
    
    // ==================== MODULES ====================
    
    public function modules($courseId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $course = $this->courseModel->find($courseId);
        if (!$course || $course['dosen_id'] != $user['id']) {
            return redirect()->to('lecturer/courses');
        }
        
        $modules = $this->moduleModel->getModulesByCourse($courseId);
        
        foreach ($modules as &$module) {
            $materials = $this->materialModel->getMaterialsByModule($module['id']);
            $assignments = $this->assignmentModel->getAssignmentsByModule($module['id']);
            $module['material_count'] = count($materials);
            $module['assignment_count'] = count($assignments);
        }
        
        return view('view_lms/lecturer/modules', [
            'course' => $course,
            'modules' => $modules,
            'user' => $user
        ]);
    }
    
    public function allModules()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        $allModules = [];
        foreach ($courses as $course) {
            $modules = $this->moduleModel->getModulesByCourse($course['id']);
            foreach ($modules as &$module) {
                $module['course_title'] = $course['title'];
                $materials = $this->materialModel->getMaterialsByModule($module['id']);
                $assignments = $this->assignmentModel->getAssignmentsByModule($module['id']);
                $module['material_count'] = count($materials);
                $module['assignment_count'] = count($assignments);
            }
            $allModules = array_merge($allModules, $modules);
        }
        
        return view('view_lms/lecturer/modules', [
            'modules' => $allModules,
            'user' => $user
        ]);
    }
    
    public function createModule($courseId = null)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        if ($this->request->getMethod() === 'POST') {
            $course = $this->courseModel->find($courseId);
            if (!$course || $course['dosen_id'] != $user['id']) {
                session()->setFlashdata('error', 'Invalid course');
                return redirect()->to('lecturer/courses');
            }
            
            $data = [
                'course_id' => $courseId,
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description')
            ];
            
            $this->moduleModel->createModule($data);
            session()->setFlashdata('success', 'Module created successfully');
            
            return redirect()->to('lecturer/modules/' . $courseId);
        }
        
        return redirect()->to('lecturer/courses');
    }
    
    public function updateModule($moduleId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $module = $this->moduleModel->find($moduleId);
        if (!$module) {
            session()->setFlashdata('error', 'Module not found');
            return redirect()->to('lecturer/courses');
        }
        
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description')
            ];
            
            $this->moduleModel->updateModule($moduleId, $data);
            session()->setFlashdata('success', 'Module updated successfully');
            
            return redirect()->to('lecturer/modules/' . $module['course_id']);
        }
        
        return redirect()->to('lecturer/modules/' . $module['course_id']);
    }
    
    public function deleteModule($moduleId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $module = $this->moduleModel->find($moduleId);
        if (!$module) {
            session()->setFlashdata('error', 'Module not found');
            return redirect()->to('lecturer/courses');
        }
        
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        $materials = $this->materialModel->getMaterialsByModule($moduleId);
        foreach ($materials as $material) {
            $this->materialModel->deleteMaterial($material['id']);
        }
        
        $assignments = $this->assignmentModel->getAssignmentsByModule($moduleId);
        foreach ($assignments as $assignment) {
            $this->assignmentModel->deleteAssignment($assignment['id']);
        }
        
        $this->moduleModel->deleteModule($moduleId);
        session()->setFlashdata('success', 'Module deleted successfully');
        
        return redirect()->to('lecturer/modules/' . $module['course_id']);
    }
    
    // ==================== MATERIALS ====================
    
    public function materials($moduleId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $module = $this->moduleModel->find($moduleId);
        if (!$module) {
            return redirect()->to('lecturer/courses');
        }
        
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            return redirect()->to('lecturer/courses');
        }
        
        $materials = $this->materialModel->getMaterialsByModule($moduleId);
        
        return view('view_lms/lecturer/materials', [
            'course' => $course,
            'module' => $module,
            'materials' => $materials,
            'user' => $user
        ]);
    }
    
    public function allMaterials()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        $allMaterials = [];
        foreach ($courses as $course) {
            $materials = $this->materialModel->getMaterialsByCourse($course['id']);
            foreach ($materials as &$material) {
                $material['course_title'] = $course['title'];
            }
            $allMaterials = array_merge($allMaterials, $materials);
        }
        
        return view('view_lms/lecturer/materials', [
            'materials' => $allMaterials,
            'user' => $user
        ]);
    }
    
    public function createMaterial($moduleId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $module = $this->moduleModel->find($moduleId);
        if (!$module) {
            session()->setFlashdata('error', 'Module not found');
            return redirect()->to('lecturer/courses');
        }
        
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('file');
            
            if ($file && $file->isValid()) {
                $newName = $file->getRandomName();
                $file->move('writable/uploads', $newName);
                
                $data = [
                    'module_id' => $moduleId,
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'file_path' => $newName,
                    'type' => $file->getClientMimeType()
                ];
                
                $this->materialModel->createMaterial($data);
                session()->setFlashdata('success', 'Material uploaded successfully');
            } else {
                session()->setFlashdata('error', 'Failed to upload file');
            }
            
            return redirect()->to('lecturer/materials/' . $moduleId);
        }
        
        return redirect()->to('lecturer/materials/' . $moduleId);
    }
    
    public function updateMaterial($materialId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $material = $this->materialModel->find($materialId);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found');
            return redirect()->to('lecturer/courses');
        }
        
        $module = $this->moduleModel->find($material['module_id']);
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description')
            ];
            
            $file = $this->request->getFile('file');
            if ($file && $file->isValid()) {
                $newName = $file->getRandomName();
                $file->move('writable/uploads', $newName);
                $data['file_path'] = $newName;
                $data['type'] = $file->getClientMimeType();
            }
            
            $this->materialModel->updateMaterial($materialId, $data);
            session()->setFlashdata('success', 'Material updated successfully');
            
            return redirect()->to('lecturer/materials/' . $material['module_id']);
        }
        
        return redirect()->to('lecturer/materials/' . $material['module_id']);
    }
    
    public function deleteMaterial($materialId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $material = $this->materialModel->find($materialId);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found');
            return redirect()->to('lecturer/courses');
        }
        
        $module = $this->moduleModel->find($material['module_id']);
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        if (file_exists('writable/uploads/' . $material['file_path'])) {
            unlink('writable/uploads/' . $material['file_path']);
        }
        
        $this->materialModel->deleteMaterial($materialId);
        session()->setFlashdata('success', 'Material deleted successfully');
        
        return redirect()->to('lecturer/materials/' . $material['module_id']);
    }
    
    // ==================== ASSIGNMENTS ====================
    
    public function assignments($courseId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $course = $this->courseModel->find($courseId);
        if (!$course || $course['dosen_id'] != $user['id']) {
            return redirect()->to('lecturer/courses');
        }
        
        $assignments = $this->assignmentModel->getAssignmentsByCourse($courseId);
        
        return view('view_lms/lecturer/assignments', [
            'course' => $course,
            'assignments' => $assignments,
            'user' => $user
        ]);
    }
    
    public function allAssignments()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        $allAssignments = [];
        foreach ($courses as $course) {
            $assignments = $this->assignmentModel->getAssignmentsByCourse($course['id']);
            foreach ($assignments as &$assignment) {
                $assignment['course_title'] = $course['title'];
            }
            $allAssignments = array_merge($allAssignments, $assignments);
        }
        
        return view('view_lms/lecturer/assignments', [
            'assignments' => $allAssignments,
            'user' => $user
        ]);
    }
    
    public function createAssignment($moduleId = null)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        if ($moduleId) {
            $module = $this->moduleModel->find($moduleId);
            if (!$module) {
                session()->setFlashdata('error', 'Module not found');
                return redirect()->to('lecturer/courses');
            }
            
            $course = $this->courseModel->find($module['course_id']);
            if (!$course || $course['dosen_id'] != $user['id']) {
                session()->setFlashdata('error', 'Unauthorized');
                return redirect()->to('lecturer/courses');
            }
            
            if ($this->request->getMethod() === 'POST') {
                $data = [
                    'module_id' => $moduleId,
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'deadline' => $this->request->getPost('deadline'),
                    'max_score' => $this->request->getPost('max_score')
                ];
                
                $this->assignmentModel->createAssignment($data);
                session()->setFlashdata('success', 'Assignment created successfully');
                
                return redirect()->to('lecturer/assignments/' . $course['id']);
            }
            
            return view('view_lms/lecturer/create_assignment', [
                'module' => $module,
                'course' => $course,
                'user' => $user
            ]);
        }
        
        return redirect()->to('lecturer/courses');
    }
    
    public function updateAssignment($assignmentId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $assignment = $this->assignmentModel->find($assignmentId);
        if (!$assignment) {
            session()->setFlashdata('error', 'Assignment not found');
            return redirect()->to('lecturer/courses');
        }
        
        $module = $this->moduleModel->find($assignment['module_id']);
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'deadline' => $this->request->getPost('deadline'),
                'max_score' => $this->request->getPost('max_score')
            ];
            
            $this->assignmentModel->updateAssignment($assignmentId, $data);
            session()->setFlashdata('success', 'Assignment updated successfully');
            
            return redirect()->to('lecturer/assignments/' . $course['id']);
        }
        
        return redirect()->to('lecturer/assignments/' . $course['id']);
    }
    
    public function deleteAssignment($assignmentId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $assignment = $this->assignmentModel->find($assignmentId);
        if (!$assignment) {
            session()->setFlashdata('error', 'Assignment not found');
            return redirect()->to('lecturer/courses');
        }
        
        $module = $this->moduleModel->find($assignment['module_id']);
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        $db = \Config\Database::connect();
        $db->table('submissions')->where('assignment_id', $assignmentId)->delete();
        
        $this->assignmentModel->deleteAssignment($assignmentId);
        session()->setFlashdata('success', 'Assignment deleted successfully');
        
        return redirect()->to('lecturer/assignments/' . $course['id']);
    }
    
    // ==================== SUBMISSIONS & GRADING ====================
    
    public function submissions($assignmentId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $assignment = $this->assignmentModel->find($assignmentId);
        if (!$assignment) {
            return redirect()->to('lecturer/courses');
        }
        
        $module = $this->moduleModel->find($assignment['module_id']);
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            return redirect()->to('lecturer/courses');
        }
        
        $submissions = $this->submissionModel->getSubmissionsByAssignment($assignmentId);
        
        return view('view_lms/lecturer/submissions', [
            'course' => $course,
            'assignment' => $assignment,
            'submissions' => $submissions,
            'user' => $user
        ]);
    }
    
    public function allSubmissions()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        $allSubmissions = [];
        foreach ($courses as $course) {
            $submissions = $this->submissionModel->getPendingGradingByCourse($course['id']);
            $allSubmissions = array_merge($allSubmissions, $submissions);
        }
        
        return view('view_lms/lecturer/grading', [
            'submissions' => $allSubmissions,
            'user' => $user
        ]);
    }
    
    public function grading()
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $courses = $this->courseModel->getCoursesByLecturer($user['id']);
        
        $allSubmissions = [];
        foreach ($courses as $course) {
            $submissions = $this->submissionModel->getPendingGradingByCourse($course['id']);
            $allSubmissions = array_merge($allSubmissions, $submissions);
        }
        
        return view('view_lms/lecturer/grading', [
            'submissions' => $allSubmissions,
            'user' => $user
        ]);
    }
    
    public function gradeSubmission($submissionId)
    {
        $authResult = $this->checkAuth();
        if ($authResult['status'] === 'redirect') {
            return redirect()->to($authResult['redirect']);
        }
        if (isset($authResult['error'])) {
            return $this->response->setJSON(['error' => $authResult['error']])
                                  ->setStatusCode($authResult['status']);
        }
        $user = $authResult['user'];
        
        $submission = $this->submissionModel->find($submissionId);
        if (!$submission) {
            session()->setFlashdata('error', 'Submission not found');
            return redirect()->to('lecturer/courses');
        }
        
        $assignment = $this->assignmentModel->find($submission['assignment_id']);
        $module = $this->moduleModel->find($assignment['module_id']);
        $course = $this->courseModel->find($module['course_id']);
        if (!$course || $course['dosen_id'] != $user['id']) {
            session()->setFlashdata('error', 'Unauthorized');
            return redirect()->to('lecturer/courses');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'score' => $this->request->getPost('score'),
                'feedback' => $this->request->getPost('feedback')
            ];
            
            $this->submissionModel->updateSubmission($submissionId, $data);
            session()->setFlashdata('success', 'Grade saved successfully');
            
            return redirect()->to('lecturer/submissions/' . $submission['assignment_id']);
        }
        
        $submission = $this->submissionModel->getSubmissionWithDetails($submissionId);
        $student = $this->userModel->find($submission['mahasiswa_id']);
        
        return view('view_lms/lecturer/grade_submission', [
            'course' => $course,
            'submission' => $submission,
            'student' => $student,
            'user' => $user
        ]);
    }
}
