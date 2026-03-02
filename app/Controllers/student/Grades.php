<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class Grades extends BaseController
{
    public function index()
    {
        // Simply render the view - JavaScript handles the data display
        // This works for demo purposes without needing database
        return view('view_lms/student/grades');
    }
    
    public function getByCourse($courseId)
    {
        return $this->response->setJSON([
            'success' => true,
            'data' => []
        ]);
    }
}
