<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCourseCodeToCourses extends Migration
{
    public function up()
    {
        // Add course_code column to courses table
        $this->forge->addColumn('courses', [
            'course_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'unique'     => true,
                'null'       => true,
            ],
        ]);
        
        // Generate unique course codes for existing courses
        $db = \Config\Database::connect();
        $courses = $db->table('courses')->get()->getResultArray();
        
        foreach ($courses as $course) {
            $code = strtoupper(substr($course['title'], 0, 3)) . rand(1000, 9999);
            $db->table('courses')->where('id', $course['id'])->update(['course_code' => $code]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('courses', 'course_code');
    }
}
