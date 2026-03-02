<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['course_id', 'mahasiswa_id', 'enrolled_at'];
    protected $useTimestamps    = false;
    
    public function enrollStudent($courseId, $studentId)
    {
        // Check if already enrolled
        $existing = $this->where('course_id', $courseId)
                        ->where('mahasiswa_id', $studentId)
                        ->first();
        
        if ($existing) {
            return false;
        }
        
        return $this->insert([
            'course_id' => $courseId,
            'mahasiswa_id' => $studentId,
            'enrolled_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function unenrollStudent($courseId, $studentId)
    {
        return $this->where('course_id', $courseId)
                    ->where('mahasiswa_id', $studentId)
                    ->delete();
    }
    
    public function isEnrolled($courseId, $studentId)
    {
        $enrollment = $this->where('course_id', $courseId)
                         ->where('mahasiswa_id', $studentId)
                         ->first();
        
        return $enrollment !== null;
    }
    
    public function getEnrolledCourses($studentId)
    {
        $db = \Config\Database::connect();
        return $db->table('enrollments')
            ->select('courses.*, users.name as lecturer_name, enrollments.enrolled_at')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->join('users', 'users.id = courses.dosen_id', 'left')
            ->where('enrollments.mahasiswa_id', $studentId)
            ->get()
            ->getResultArray();
    }
    
    public function getEnrolledCourseIds($studentId)
    {
        $enrollments = $this->where('mahasiswa_id', $studentId)->findAll();
        return array_column($enrollments, 'course_id');
    }
    
    public function getEnrollmentsByStudent($studentId)
    {
        $db = \Config\Database::connect();
        return $db->table('enrollments')
            ->select('courses.id as course_id, courses.title as course_title, courses.description')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->where('enrollments.mahasiswa_id', $studentId)
            ->get()
            ->getResultArray();
    }
}
