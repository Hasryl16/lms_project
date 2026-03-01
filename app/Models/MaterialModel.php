<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table            = 'materials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['module_id', 'title', 'file_path', 'type', 'uploaded_at'];
    protected $useTimestamps    = false;
    
    public function getMaterialsByModule($moduleId)
    {
        return $this->where('module_id', $moduleId)->findAll();
    }
    
    public function getMaterialsByCourse($courseId)
    {
        return $this->select('materials.*, modules.title as module_title')
                    ->join('modules', 'modules.id = materials.module_id')
                    ->where('modules.course_id', $courseId)
                    ->findAll();
    }
    
    public function createMaterial($data)
    {
        $data['uploaded_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
    
    public function updateMaterial($id, $data)
    {
        return $this->update($id, $data);
    }
    
    public function deleteMaterial($id)
    {
        return $this->delete($id);
    }
}
