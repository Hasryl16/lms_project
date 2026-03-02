<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use App\Models\AssignmentModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        $enrollmentModel = new EnrollmentModel();
        $assignmentModel = new AssignmentModel();

        $courses = $enrollmentModel
            ->where('user_id', $userId)
            ->findAll();

        $assignments = $assignmentModel->findAll();

        $data = [
            'total_courses' => count($courses),
            'total_assignments' => count($assignments)
        ];

        return view('student/dashboard', $data);
    }
}