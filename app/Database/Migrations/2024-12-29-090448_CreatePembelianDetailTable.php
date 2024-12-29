<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembelianDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Pembelian_detail_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Pembelian_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'Produk_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'qty' => [
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

        $this->forge->addKey('Pembelian_detail_id', true);
        $this->forge->addForeignKey('Pembelian_id', 'pembelian', 'Pembelian_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('Produk_id', 'produk', 'Produk_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembelian_detail');
    }

    public function down()
    {
        $this->forge->dropTable('pembelian_detail');
    }
}