<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table            = 'assignments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['module_id', 'title', 'description', 'deadline', 'max_score', 'created_at'];
    protected $useTimestamps    = false;

    public function getAssignmentsByModule($moduleId)
    {
        return $this->where('module_id', $moduleId)->findAll();
    }

    public function getAssignmentWithModule($id)
    {
        return $this->select('assignments.*, modules.title as module_title, courses.title as course_title')
                    ->join('modules', 'modules.id = assignments.module_id', 'left')
                    ->join('courses', 'courses.id = modules.course_id', 'left')
                    ->where('assignments.id', $id)
                    ->first();
    }

    public function getAssignmentsByCourse($courseId)
    {
        return $this->select('assignments.*, modules.title as module_title')
                    ->join('modules', 'modules.id = assignments.module_id', 'left')
                    ->where('modules.course_id', $courseId)
                    ->findAll();
    }

    public function getAllAssignmentsWithDetails()
    {
        return $this->select('assignments.*, modules.title as module_title, courses.title as course_title')
                    ->join('modules', 'modules.id = assignments.module_id', 'left')
                    ->join('courses', 'courses.id = modules.course_id', 'left')
                    ->findAll();
    }

    public function createAssignment($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    public function updateAssignment($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteAssignment($id)
    {
        return $this->delete($id);
    }
}
