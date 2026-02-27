<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Courses extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'title' => ['type'=>'VARCHAR','constraint'=>150],
            'description' => ['type'=>'TEXT'],
            'dosen_id' => ['type'=>'VARCHAR','constraint'=>10],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dosen_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('courses');
    }

    public function down()
    {
        $this->forge->dropTable('courses');
    }
}
