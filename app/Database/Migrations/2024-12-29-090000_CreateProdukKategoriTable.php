<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdukKategoriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Kategori_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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

        $this->forge->addKey('Kategori_id', true);
        $this->forge->createTable('produk_kategori');
    }

    public function down()
    {
        $this->forge->dropTable('produk_kategori');
    }
}