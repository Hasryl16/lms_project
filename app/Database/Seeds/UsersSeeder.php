<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'A001',
                'name' => 'Admin LMS',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'id' => 'A002',
                'name' => 'Admin Demo',
                'email' => 'admin@edu.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
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
            [
                'id' => 'S001',
                'name' => 'fatur',
                'email' => 'fatur@gmail.com',
                'password' => password_hash('fatur123', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
            [
                'id' => 'S002',
                'name' => 'Student Demo',
                'email' => 'student@edu.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
        ];

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        $builder->emptyTable('users');
        $builder->insertBatch($data);
    }
}
