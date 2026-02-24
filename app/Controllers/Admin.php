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
        $data = $this->request->getJSON(true);
        
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
            'dosen_id' => $data['dosen_id']
        ]);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Course created successfully'], 201);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to create course'], 500);
    }
    
    public function updateCourse($id)
    {
        $data = $this->request->getJSON(true);
        
        $course = $this->courseModel->find($id);
        if (!$course) {
            return $this->respond(['success' => false, 'message' => 'Course not found'], 404);
        }
        
        if (isset($data['dosen_id'])) {
            $lecturer = $this->userModel->find($data['dosen_id']);
            if (!$lecturer || $lecturer['role'] !== 'lecturer') {
                return $this->respond(['success' => false, 'message' => 'Invalid lecturer'], 400);
            }
        }
        
        $updateData = [];
        if (isset($data['title'])) $updateData['title'] = $data['title'];
        if (isset($data['description'])) $updateData['description'] = $data['description'];
        if (isset($data['dosen_id'])) $updateData['dosen_id'] = $data['dosen_id'];
        
        $result = $this->courseModel->updateCourse($id, $updateData);
        
        if ($result) {
            return $this->respond(['success' => true, 'message' => 'Course updated successfully'], 200);
        }
        
        return $this->respond(['success' => false, 'message' => 'Failed to update course'], 500);
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
        
        $result = $this->userModel->insert([
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
