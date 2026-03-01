<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LecturerSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // ===== 1. ENSURE LECTURER USERS EXIST (matching UsersSeeder) =====
        $lecturers = [
            [
                'id' => 'L001',
                'name' => 'Dosen Informatika',
                'email' => 'dosen@gmail.com',
                'password' => password_hash('dosen123', PASSWORD_DEFAULT),
                'role' => 'lecturer',
            ],
            [
                'id' => 'L002',
                'name' => 'Lecturer Demo',
                'email' => 'lecturer@edu.com',
                'password' => password_hash('lecturer123', PASSWORD_DEFAULT),
                'role' => 'lecturer',
            ],
        ];

        $userBuilder = $db->table('users');
        
        foreach ($lecturers as $user) {
            $existing = $userBuilder->where('id', $user['id'])->get()->getRow();
            if (!$existing) {
                $userBuilder->insert($user);
                echo "Created lecturer: {$user['id']} - {$user['name']}\n";
            }
        }

        // ===== 2. CREATE COURSES FOR LECTURERS (using their IDs) =====
        $courses = [
            [
                'title' => 'Pemrograman Web Dasar',
                'description' => 'Mata kuliah dasar pemrograman web dengan HTML, CSS, dan JavaScript',
                'dosen_id' => 'L001',
                'course_code' => 'PWD001',
            ],
            [
                'title' => 'Pemrograman Web Lanjutan',
                'description' => 'Mata kuliah lanjutan dengan PHP dan Framework CodeIgniter',
                'dosen_id' => 'L001',
                'course_code' => 'PWL001',
            ],
            [
                'title' => 'Database Management',
                'description' => 'Mata kuliah tentang desain dan pengelolaan database',
                'dosen_id' => 'L002',
                'course_code' => 'DBM001',
            ],
            [
                'title' => 'Jaringan Komputer',
                'description' => 'Dasar-dasar jaringan komputer dan komunikasi data',
                'dosen_id' => 'L002',
                'course_code' => 'JK001',
            ],
        ];

        $courseBuilder = $db->table('courses');
        $courseIds = [];
        
        foreach ($courses as $course) {
            $existing = $courseBuilder->where('title', $course['title'])->get()->getRow();
            if ($existing) {
                $courseIds[$course['title']] = $existing->id;
                echo "Course already exists: {$course['title']}\n";
            } else {
                $course['created_at'] = date('Y-m-d H:i:s');
                $courseBuilder->insert($course);
                $courseIds[$course['title']] = $db->insertID();
                echo "Created course: {$course['title']} (dosen_id: {$course['dosen_id']})\n";
            }
        }

        // ===== 3. CREATE MODULES FOR COURSES =====
        $modules = [
            [
                'course_id' => $courseIds['Pemrograman Web Dasar'],
                'title' => 'Pengenalan HTML',
                'description' => 'Belajar dasar-dasar HTML',
            ],
            [
                'course_id' => $courseIds['Pemrograman Web Dasar'],
                'title' => 'CSS dan Styling',
                'description' => 'Mempelajari CSS untuk styling halaman web',
            ],
            [
                'course_id' => $courseIds['Pemrograman Web Dasar'],
                'title' => 'JavaScript Dasar',
                'description' => 'Pengenalan JavaScript untuk interaktivitas',
            ],
            [
                'course_id' => $courseIds['Pemrograman Web Lanjutan'],
                'title' => 'PHP Dasar',
                'description' => 'Belajar pemrograman PHP',
            ],
            [
                'course_id' => $courseIds['Pemrograman Web Lanjutan'],
                'title' => 'CodeIgniter Framework',
                'description' => 'Mempelajari framework CodeIgniter',
            ],
            [
                'course_id' => $courseIds['Database Management'],
                'title' => 'SQL Fundamentals',
                'description' => 'Dasar-dasar query SQL',
            ],
            [
                'course_id' => $courseIds['Database Management'],
                'title' => 'Database Design',
                'description' => 'Desain database yang baik',
            ],
        ];

        $moduleBuilder = $db->table('modules');
        $moduleIds = [];
        
        foreach ($modules as $module) {
            $existing = $moduleBuilder->where('title', $module['title'])->where('course_id', $module['course_id'])->get()->getRow();
            if ($existing) {
                $moduleIds[$module['title']] = $existing->id;
                echo "Module already exists: {$module['title']}\n";
            } else {
                $moduleBuilder->insert($module);
                $moduleIds[$module['title']] = $db->insertID();
                echo "Created module: {$module['title']}\n";
            }
        }

        // ===== 4. CREATE MATERIALS FOR MODULES =====
        $materials = [
            [
                'module_id' => $moduleIds['Pengenalan HTML'],
                'title' => 'Materi HTML Lengkap',
                'file_path' => 'materials/html_dasar.pdf',
                'type' => 'application/pdf',
            ],
            [
                'module_id' => $moduleIds['CSS dan Styling'],
                'title' => 'Tutorial CSS3',
                'file_path' => 'materials/css_tutorial.pdf',
                'type' => 'application/pdf',
            ],
            [
                'module_id' => $moduleIds['PHP Dasar'],
                'title' => 'Modul PHP',
                'file_path' => 'materials/php_modul.pdf',
                'type' => 'application/pdf',
            ],
            [
                'module_id' => $moduleIds['SQL Fundamentals'],
                'title' => 'SQL Cheat Sheet',
                'file_path' => 'materials/sql_cheatsheet.pdf',
                'type' => 'application/pdf',
            ],
        ];

        $materialBuilder = $db->table('materials');
        
        foreach ($materials as $material) {
            $existing = $materialBuilder->where('title', $material['title'])->get()->getRow();
            if (!$existing) {
                $material['uploaded_at'] = date('Y-m-d H:i:s');
                $materialBuilder->insert($material);
                echo "Created material: {$material['title']}\n";
            }
        }

        // ===== 5. CREATE ASSIGNMENTS FOR MODULES =====
        $assignments = [
            [
                'module_id' => $moduleIds['Pengenalan HTML'],
                'title' => 'Buat Halaman Profil',
                'description' => 'Buat halaman profil pribadi menggunakan HTML',
                'deadline' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'max_score' => 100,
            ],
            [
                'module_id' => $moduleIds['CSS dan Styling'],
                'title' => 'Styling Portfolio',
                'description' => 'Styling portfolio dengan CSS',
                'deadline' => date('Y-m-d H:i:s', strtotime('+14 days')),
                'max_score' => 100,
            ],
            [
                'module_id' => $moduleIds['PHP Dasar'],
                'title' => 'CRUD Sederhana',
                'description' => 'Buat aplikasi CRUD sederhana dengan PHP',
                'deadline' => date('Y-m-d H:i:s', strtotime('+21 days')),
                'max_score' => 100,
            ],
            [
                'module_id' => $moduleIds['SQL Fundamentals'],
                'title' => 'Desain Database Toko',
                'description' => 'Buat desain database untuk sistem toko online',
                'deadline' => date('Y-m-d H:i:s', strtotime('+10 days')),
                'max_score' => 100,
            ],
        ];

        $assignmentBuilder = $db->table('assignments');
        
        foreach ($assignments as $assignment) {
            $existing = $assignmentBuilder->where('title', $assignment['title'])->get()->getRow();
            if (!$existing) {
                $assignment['created_at'] = date('Y-m-d H:i:s');
                $assignmentBuilder->insert($assignment);
                echo "Created assignment: {$assignment['title']}\n";
            }
        }

        echo "\n=== Lecturer Seeder Completed ===\n";
        echo "Lecturers: L001, L002 (from UsersSeeder)\n";
        echo "Courses: 4 courses linked to L001 and L002\n";
        echo "Modules: 7 modules across courses\n";
        echo "Materials: 4 sample materials\n";
        echo "Assignments: 4 sample assignments\n";
    }
}
