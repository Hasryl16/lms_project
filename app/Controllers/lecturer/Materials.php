<?php

namespace App\Controllers\Lecturer;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\ModuleModel;
use App\Models\CourseModel;

class Materials extends BaseController
{
    protected $materialModel;
    protected $moduleModel;
    protected $courseModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->moduleModel = new ModuleModel();
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $lecturerId = session()->get('user_id');
        
        $courses = $this->courseModel->getCoursesByLecturer($lecturerId);
        $materials = [];
        
        foreach ($courses as $course) {
            $courseMaterials = $this->materialModel->getMaterialsByCourse($course['id']);
            foreach ($courseMaterials as &$material) {
                $material['course_title'] = $course['title'];
                $material['course_id'] = $course['id'];
            }
            $materials = array_merge($materials, $courseMaterials);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'materials' => $materials,
            'courses' => $courses
        ]);
    }

    public function getByModule($moduleId)
    {
        $materials = $this->materialModel->getMaterialsByModule($moduleId);
        
        return $this->response->setJSON([
            'success' => true,
            'materials' => $materials
        ]);
    }

    public function getByCourse($courseId)
    {
        $materials = $this->materialModel->getMaterialsByCourse($courseId);
        $modules = $this->moduleModel->getModulesByCourse($courseId);
        
        return $this->response->setJSON([
            'success' => true,
            'materials' => $materials,
            'modules' => $modules
        ]);
    }

    public function create()
    {
        $file = $this->request->getFile('file_path');
        $filePath = null;
        
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/materials', $fileName);
            $filePath = 'uploads/materials/' . $fileName;
        }

        $data = [
            'module_id' => $this->request->getPost('module_id'),
            'title' => $this->request->getPost('title'),
            'file_path' => $filePath,
            'type' => $this->request->getPost('type') ?? 'document'
        ];

        $result = $this->materialModel->createMaterial($data);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Material created successfully' : 'Failed to create material'
        ]);
    }

    public function update($id)
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type')
        ];

        $file = $this->request->getFile('file_path');
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/materials', $fileName);
            $data['file_path'] = 'uploads/materials/' . $fileName;
        }

        $result = $this->materialModel->updateMaterial($id, $data);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Material updated successfully' : 'Failed to update material'
        ]);
    }

    public function delete($id)
    {
        $result = $this->materialModel->deleteMaterial($id);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Material deleted successfully' : 'Failed to delete material'
        ]);
    }
}
