<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
   public function run()
    {
        $this->db->table('courses')->insert([
            'title' => 'Pemrograman Web',
            'description' => 'Mata kuliah dasar pemrograman web',
            'dosen_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
