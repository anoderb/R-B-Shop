<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKurirTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kurir_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kurir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ongkos_kirim' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('kurir_id', true);
        $this->forge->createTable('kurir');
    }

    public function down()
    {
        $this->forge->dropTable('kurir');
    }
}