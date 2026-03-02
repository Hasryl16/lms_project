<?php

namespace App\Controllers;

use App\Models\UserModel;

class Lecturer extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index(): string
    {
        return view('view_lms/lecturer/dashboard');
    }
    
    public function dashboard(): string
    {
        return view('view_lms/lecturer/dashboard');
    }
    
    public function courses(): string
    {
        return view('view_lms/lecturer/courses');
    }
    
    public function materials(): string
    {
        return view('view_lms/lecturer/materials');
    }
    
    public function assignments(): string
    {
        return view('view_lms/lecturer/assignments');
    }
    
    public function grading(): string
    {
        return view('view_lms/lecturer/grading');
    }
}
