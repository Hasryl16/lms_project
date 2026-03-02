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
    $routes->post('api/lecturers/update/(:any)', 'Admin::updateLecturer/$1');
    $routes->post('api/lecturers/delete/(:any)', 'Admin::deleteLecturer/$1');
    
    $routes->get('api/students', 'Admin::students');
    $routes->get('api/enrollments', 'Admin::enrollments');
});

// Lecturer - View pages (accessible but with manual auth check in controller)
$routes->get('lecturer', 'Lecturer::index');
$routes->get('lecturer/dashboard', 'Lecturer::dashboard');
$routes->get('lecturer/courses', 'Lecturer::courses');
$routes->get('lecturer/modules/(:num)', 'Lecturer::modules/$1');
$routes->get('lecturer/materials/(:num)', 'Lecturer::materials/$1');
$routes->get('lecturer/assignments/(:num)', 'Lecturer::assignments/$1');
$routes->get('lecturer/submissions/(:num)', 'Lecturer::submissions/$1');
$routes->get('lecturer/gradeSubmission/(:num)', 'Lecturer::gradeSubmission/$1');

// New routes for all items view
$routes->get('lecturer/all-modules', 'Lecturer::allModules');
$routes->get('lecturer/all-materials', 'Lecturer::allMaterials');
$routes->get('lecturer/all-assignments', 'Lecturer::allAssignments');
$routes->get('lecturer/all-submissions', 'Lecturer::allSubmissions');
$routes->get('lecturer/grading', 'Lecturer::grading');

$routes->group('lecturer', ['filter' => 'auth:lecturer'], function($routes) {
    $routes->get('getCourses', 'Lecturer::getCourses');
    $routes->get('createModule/(:num)', 'Lecturer::createModule/$1');
    $routes->post('createModule/(:num)', 'Lecturer::createModule/$1');
    $routes->get('createMaterial/(:num)', 'Lecturer::createMaterial/$1');
    $routes->post('createMaterial/(:num)', 'Lecturer::createMaterial/$1');
    $routes->get('createAssignment/(:num)', 'Lecturer::createAssignment/$1');
    $routes->post('createAssignment/(:num)', 'Lecturer::createAssignment/$1');

    $routes->get('updateModule/(:num)', 'Lecturer::updateModule/$1');
    $routes->post('updateModule/(:num)', 'Lecturer::updateModule/$1');
    $routes->post('deleteModule/(:num)', 'Lecturer::deleteModule/$1');
    
    $routes->get('updateMaterial/(:num)', 'Lecturer::updateMaterial/$1');
    $routes->post('updateMaterial/(:num)', 'Lecturer::updateMaterial/$1');
    $routes->post('deleteMaterial/(:num)', 'Lecturer::deleteMaterial/$1');
    
    $routes->get('updateAssignment/(:num)', 'Lecturer::updateAssignment/$1');
    $routes->post('updateAssignment/(:num)', 'Lecturer::updateAssignment/$1');
    $routes->post('deleteAssignment/(:num)', 'Lecturer::deleteAssignment/$1');

    $routes->post('gradeSubmission/(:num)', 'Lecturer::gradeSubmission/$1');
});

$routes->group('student', ['filter' => 'auth:student'], function($routes) {
    $routes->get('/', 'Student::index');
    $routes->get('dashboard', 'Student::dashboard');
    $routes->get('browse', 'Student::browse');
    $routes->get('my-courses', 'Student::myCourses');
    $routes->get('assignments', 'Student::assignments');
    $routes->get('grades', 'Student::grades');
    $routes->get('course/(:num)', 'Student::courseDetail/$1');
    $routes->get('module/(:num)', 'Student::moduleDetail/$1');
    
    $routes->post('enroll', 'Student::enrollCourse');
    $routes->post('unenroll/(:num)', 'Student::unenrollCourse/$1');
    $routes->post('submit-assignment/(:num)', 'Student::submitAssignment/$1');
});
