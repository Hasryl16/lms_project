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
    protected $allowedFields    = ['title', 'description', 'dosen_id', 'created_at'];
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
        return $this->where('dosen_id', $lecturerId)->findAll();
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
