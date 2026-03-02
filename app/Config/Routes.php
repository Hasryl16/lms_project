<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('login', 'Home::login');


$routes->group('auth', function($routes) {
    $routes->post('login', 'Auth::login');
    $routes->post('logout', 'Auth::logout');
    $routes->get('me', 'Auth::me');
    $routes->get('validate', 'Auth::validateToken');
});

$routes->get('admin', 'Admin::index');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/courses', 'Admin::coursesView');
$routes->get('admin/students', 'Admin::studentsView');
$routes->get('admin/lecturers', 'Admin::lecturersView');
$routes->get('admin/enrollments', 'Admin::enrollmentsView');

$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('api/courses', 'Admin::courses');
    $routes->post('api/courses/create', 'Admin::createCourse');
    $routes->post('api/courses/update/(:num)', 'Admin::updateCourse/$1');
    $routes->post('api/courses/delete/(:num)', 'Admin::deleteCourse/$1');
    
    $routes->get('api/lecturers', 'Admin::lecturers');
    $routes->post('api/lecturers/create', 'Admin::createLecturer');
    $routes->post('api/lecturers/update/(:num)', 'Admin::updateLecturer/$1');
    $routes->post('api/lecturers/delete/(:num)', 'Admin::deleteLecturer/$1');
    
    $routes->get('api/students', 'Admin::students');
    $routes->get('api/enrollments', 'Admin::enrollments');
});

// Lecturer routes - public view pages
$routes->get('lecturer', 'Lecturer::index');
$routes->get('lecturer/dashboard', 'Lecturer::dashboard');
$routes->get('lecturer/courses', 'Lecturer::courses');
$routes->get('lecturer/materials', 'Lecturer::materials');
$routes->get('lecturer/assignments', 'Lecturer::assignments');
$routes->get('lecturer/grading', 'Lecturer::grading');

// Lecturer API routes - protected
$routes->group('lecturer/api', ['filter' => 'auth:lecturer'], function($routes) {
    // Modules
    $routes->get('modules', 'Lecturer\Modules::index');
    $routes->get('modules/course/(:num)', 'Lecturer\Modules::getByCourse/$1');
    $routes->post('modules/create', 'Lecturer\Modules::create');
    $routes->post('modules/update/(:num)', 'Lecturer\Modules::update/$1');
    $routes->post('modules/delete/(:num)', 'Lecturer\Modules::delete/$1');
    
    // Materials
    $routes->get('materials', 'Lecturer\Materials::index');
    $routes->get('materials/module/(:num)', 'Lecturer\Materials::getByModule/$1');
    $routes->get('materials/course/(:num)', 'Lecturer\Materials::getByCourse/$1');
    $routes->post('materials/create', 'Lecturer\Materials::create');
    $routes->post('materials/update/(:num)', 'Lecturer\Materials::update/$1');
    $routes->post('materials/delete/(:num)', 'Lecturer\Materials::delete/$1');
    
    // Submissions
    $routes->get('submissions', 'Lecturer\Submissions::index');
    $routes->get('submissions/assignment/(:num)', 'Lecturer\Submissions::getByAssignment/$1');
    $routes->post('submissions/grade/(:num)', 'Lecturer\Submissions::grade/$1');
    $routes->post('submissions/update/(:num)', 'Lecturer\Submissions::update/$1');
    $routes->post('submissions/delete/(:num)', 'Lecturer\Submissions::delete/$1');
});

// Student routes - public view pages
$routes->get('student', 'Student::index');
$routes->get('student/dashboard', 'Student::dashboard');
$routes->get('student/browse', 'Student\Courses::browse');
$routes->get('student/my-courses', 'Student\Courses::myCourses');
$routes->get('student/assignments', 'Student\Assignment::index');
$routes->get('student/grades', 'Student\Grades::index');

// Student API routes - public for demo
$routes->group('student/api', function($routes) {
    // Materials
    $routes->get('materials', 'Student\Materials::index');
    $routes->get('materials/course/(:num)', 'Student\Materials::getByCourse/$1');
    $routes->get('materials/module/(:num)', 'Student\Materials::getByModule/$1');
    
    // Courses
    $routes->get('courses', 'Student\Courses::index');
    $routes->get('courses/browse', 'Student\Courses::browseApi');
    $routes->get('courses/my-courses', 'Student\Courses::myCoursesApi');
    $routes->post('courses/enroll/(:num)', 'Student\Courses::enroll/$1');
    $routes->post('courses/enroll', 'Student\Courses::enroll');
    
    // Assignments
    $routes->get('assignments', 'Student\Assignment::indexApi');
    $routes->get('assignments/course/(:num)', 'Student\Assignment::getByCourse/$1');
    $routes->post('assignments/submit/(:num)', 'Student\Assignment::submit/$1');
    
    // Grades
    $routes->get('grades', 'Student\Grades::indexApi');
    $routes->get('grades/course/(:num)', 'Student\Grades::getByCourse/$1');
});
