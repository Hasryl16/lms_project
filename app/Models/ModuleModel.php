<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuleModel extends Model
{
    protected $table            = 'modules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['course_id', 'title', 'description'];
    protected $useTimestamps    = false;

    public function getModulesByCourse($courseId)
    {
        return $this->where('course_id', $courseId)->findAll();
    }

    public function getModuleWithCourse($id)
    {
        return $this->select('modules.*, courses.title as course_title')
                    ->join('courses', 'courses.id = modules.course_id', 'left')
                    ->where('modules.id', $id)
                    ->first();
    }

    public function createModule($data)
    {
        return $this->insert($data);
    }

    public function updateModule($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteModule($id)
    {
        return $this->delete($id);
    }
}
