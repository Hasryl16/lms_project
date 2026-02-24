<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin users
            [
                'name' => 'Admin LMS',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'name' => 'Admin Demo',
                'email' => 'admin@edu.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            // Lecturer users
            [
                'name' => 'Dosen Informatika',
                'email' => 'dosen@gmail.com',
                'password' => password_hash('dosen123', PASSWORD_DEFAULT),
                'role' => 'lecturer',
            ],
            [
                'name' => 'Lecturer Demo',
                'email' => 'lecturer@edu.com',
                'password' => password_hash('lecturer123', PASSWORD_DEFAULT),
                'role' => 'lecturer',
            ],
            // Student users
            [
                'name' => 'fatur',
                'email' => 'fatur@gmail.com',
                'password' => password_hash('fatur123', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
            [
                'name' => 'Student Demo',
                'email' => 'student@edu.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
        ];

        // Use query builder to insert - this handles the table prefix if any
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        // Clear existing data and insert new
        $builder->emptyTable('users');
        $builder->insertBatch($data);
    }
}
