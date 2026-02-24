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

$routes->group('lecturer', ['filter' => 'auth:lecturer'], function($routes) {
    $routes->get('/', 'Lecturer::index');
    $routes->get('dashboard', 'Lecturer::dashboard');
});

$routes->group('student', ['filter' => 'auth:student'], function($routes) {
    $routes->get('/', 'Student::index');
    $routes->get('dashboard', 'Student::dashboard');
});
