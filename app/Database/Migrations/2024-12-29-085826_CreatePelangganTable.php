<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePelangganTable extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'Pelanggan_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Nama_pelanggan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'Alamat' => [
                'type' => 'TEXT',
            ],
            'Hp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'Kota' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'User_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('Pelanggan_id', true);
        $this->forge->addForeignKey('User_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pelanggan');
    }

    public function down()
    {
        $this->forge->dropTable('pelanggan');
    }

}
