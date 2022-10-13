<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'int', 'constraint'=>10, 'null'=>false, 'unsigned'=>true, 'auto_increment'=>true],
            'kategori' => ['type'=>'varchar', 'constraint'=>100, 'null'=>false]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
