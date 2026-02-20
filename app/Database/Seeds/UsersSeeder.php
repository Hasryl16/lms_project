<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
   public function run()
    {
        $data = [
            [
                'name' => 'Admin LMS',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'name' => 'Dosen Informatika',
                'email' => 'dosen@gmail.com',
                'password' => password_hash('dosen123', PASSWORD_DEFAULT),
                'role' => 'lecturer',
            ],
            [
                'name' => 'fatur',
                'email' => 'fatur@gmail.com',
                'password' => password_hash('fatur123', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
