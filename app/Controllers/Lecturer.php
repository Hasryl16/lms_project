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
}
