<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Submissions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'assignment_id' => ['type'=>'INT','unsigned'=>true],
            'mahasiswa_id' => ['type'=>'VARCHAR','constraint'=>10],
            'file_path' => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'answer_text' => ['type'=>'TEXT','null'=>true],
            'submitted_at' => ['type'=>'DATETIME','null'=>true],
            'score' => ['type'=>'INT','null'=>true],
            'feedback' => ['type'=>'TEXT','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('assignment_id', 'assignments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mahasiswa_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('submissions');
    }

    public function down()
    {
        $this->forge->dropTable('submissions');
    }
}
