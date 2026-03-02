<?php

namespace App\Controllers\Lecturer;

use App\Controllers\BaseController;
use App\Models\ModuleModel;
use App\Models\CourseModel;

class Modules extends BaseController
{
    protected $moduleModel;
    protected $courseModel;

    public function __construct()
    {
        $this->moduleModel = new ModuleModel();
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $lecturerId = session()->get('user_id');
        
        $courses = $this->courseModel->getCoursesByLecturer($lecturerId);
        $modules = [];
        
        foreach ($courses as $course) {
            $courseModules = $this->moduleModel->getModulesByCourse($course['id']);
            foreach ($courseModules as &$module) {
                $module['course_title'] = $course['title'];
                $module['course_id'] = $course['id'];
            }
            $modules = array_merge($modules, $courseModules);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'modules' => $modules,
            'courses' => $courses
        ]);
    }

    public function getByCourse($courseId)
    {
        $modules = $this->moduleModel->getModulesByCourse($courseId);
        
        return $this->response->setJSON([
            'success' => true,
            'modules' => $modules
        ]);
    }

    public function create()
    {
        $data = [
            'course_id' => $this->request->getPost('course_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];

        $result = $this->moduleModel->createModule($data);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Module created successfully' : 'Failed to create module'
        ]);
    }

    public function update($id)
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];

        $result = $this->moduleModel->updateModule($id, $data);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Module updated successfully' : 'Failed to update module'
        ]);
    }

    public function delete($id)
    {
        $result = $this->moduleModel->deleteModule($id);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Module deleted successfully' : 'Failed to delete module'
        ]);
    }
}
