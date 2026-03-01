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
    
    public function getAssignmentsByCourse($courseId)
    {
        return $this->select('assignments.*, modules.title as module_title')
                    ->join('modules', 'modules.id = assignments.module_id')
                    ->where('modules.course_id', $courseId)
                    ->findAll();
    }
    
    public function getAssignmentWithModule($id)
    {
        return $this->select('assignments.*, modules.title as module_title, modules.course_id')
                    ->join('modules', 'modules.id = assignments.module_id')
                    ->where('assignments.id', $id)
                    ->first();
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
