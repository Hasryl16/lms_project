<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['title', 'description', 'dosen_id', 'course_code', 'created_at'];
    protected $useTimestamps    = false;
    
    public function getAllCourses()
    {
        return $this->select('courses.*, users.name as lecturer_name, users.email as lecturer_email')
                    ->join('users', 'users.id = courses.dosen_id', 'left')
                    ->findAll();
    }
    
    public function getCourseWithLecturer($id)
    {
        return $this->select('courses.*, users.name as lecturer_name, users.email as lecturer_email')
                    ->join('users', 'users.id = courses.dosen_id', 'left')
                    ->where('courses.id', $id)
                    ->first();
    }
    
    public function getCoursesByLecturer($lecturerId)
    {
        $courses = $this->where('dosen_id', $lecturerId)->findAll();
        
        // Add counts for each course
        $db = \Config\Database::connect();
        
        foreach ($courses as &$course) {
            // Student count (from enrollments)
            $course['student_count'] = $db->table('enrollments')
                ->where('course_id', $course['id'])
                ->countAllResults();
            
            // Module count
            $course['module_count'] = $db->table('modules')
                ->where('course_id', $course['id'])
                ->countAllResults();
            
            // Assignment count
            $course['assignment_count'] = $db->table('assignments')
                ->select('assignments.id')
                ->join('modules', 'modules.id = assignments.module_id')
                ->where('modules.course_id', $course['id'])
                ->countAllResults();
            
            // Pending grading count
            $course['pending_grading'] = $db->table('submissions')
                ->select('submissions.id')
                ->join('assignments', 'assignments.id = submissions.assignment_id')
                ->join('modules', 'modules.id = assignments.module_id')
                ->where('modules.course_id', $course['id'])
                ->where('submissions.score IS NULL')
                ->countAllResults();
        }
        
        return $courses;
    }
    
    public function createCourse($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
    
    public function updateCourse($id, $data)
    {
        return $this->update($id, $data);
    }
    
    public function deleteCourse($id)
    {
        return $this->delete($id);
    }
}
