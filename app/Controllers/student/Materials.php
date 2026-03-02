<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class Materials extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'success' => true,
            'materials' => []
        ]);
    }

    public function getByCourse($courseId)
    {
        return $this->response->setJSON([
            'success' => true,
            'materials' => [],
            'modules' => []
        ]);
    }

    public function getByModule($moduleId)
    {
        return $this->response->setJSON([
            'success' => true,
            'materials' => []
        ]);
    }
}
