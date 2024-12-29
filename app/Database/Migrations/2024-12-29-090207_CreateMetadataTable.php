<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMetadataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Metadata_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'Produk_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'Warna' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'Ukuran' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'Stok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'Harga' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'meta_gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('Metadata_id', true);
        $this->forge->addForeignKey('Produk_id', 'produk', 'Produk_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('metadata');
    }

    public function down()
    {
        $this->forge->dropTable('metadata');
    }
}