<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Materials extends Migration
{
  public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'module_id' => ['type'=>'INT','unsigned'=>true],
            'title' => ['type'=>'VARCHAR','constraint'=>150],
            'file_path' => ['type'=>'VARCHAR','constraint'=>255],
            'type' => ['type'=>'VARCHAR','constraint'=>50],
            'uploaded_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('module_id', 'modules', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materials');
    }

    public function down()
    {
        $this->forge->dropTable('materials');
    }
}
