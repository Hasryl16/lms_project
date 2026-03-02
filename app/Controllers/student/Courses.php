<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class Courses extends BaseController
{
    public function index()
    {
        return $this->myCourses();
    }
    
    public function myCourses()
    {
        // Simply render the view - JavaScript handles the data display
        return view('view_lms/student/my-courses');
    }
    
    public function myCoursesApi()
    {
        return $this->response->setJSON([
            'success' => true,
            'data' => []
        ]);
    }

    public function browse()
    {
        // Simply render the view - JavaScript handles the data display
        return view('view_lms/student/browse');
    }
    
    public function browseApi()
    {
        return $this->response->setJSON([
            'success' => true,
            'data' => []
        ]);
    }
    
    public function enroll($courseId = null)
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Successfully enrolled (demo mode)'
        ]);
    }
}
