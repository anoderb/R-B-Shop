<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTriggers extends Migration
{
    public function up()
    {
        // Trigger 1: calculate_grand_total
        $trigger1 = "CREATE TRIGGER `calculate_grand_total` AFTER INSERT ON `pembelian_detail`
        FOR EACH ROW BEGIN
            UPDATE pembelian
            SET grand_total = (
                SELECT COALESCE(SUM(pd.qty * m.harga), 0)
                FROM pembelian_detail pd
                JOIN metadata m ON pd.Produk_id = m.Produk_id
                WHERE pd.Pembelian_id = NEW.Pembelian_id
            ) + (
                SELECT COALESCE(ongkos_kirim, 0)
                FROM kurir
                WHERE kurir_id = (SELECT kurir_id FROM pembelian WHERE pembelian_id = NEW.Pembelian_id)
            )
            WHERE pembelian_id = NEW.Pembelian_id;
        END";

        // Trigger 2: calculate_grand_total_after_insert
        $trigger2 = "CREATE TRIGGER `calculate_grand_total_after_insert` AFTER INSERT ON `pembelian_detail`
        FOR EACH ROW BEGIN
            UPDATE pembelian
            SET grand_total = (
                SELECT COALESCE(SUM(pd.qty * m.harga), 0)
                FROM pembelian_detail pd
                JOIN metadata m ON pd.Produk_id = m.Produk_id
                WHERE pd.Pembelian_id = NEW.Pembelian_id
            ) + (
                SELECT COALESCE(ongkos_kirim, 0)
                FROM kurir
                WHERE kurir_id = (SELECT kurir_id FROM pembelian WHERE pembelian_id = NEW.Pembelian_id)
            )
            WHERE pembelian_id = NEW.Pembelian_id;
        END";

        // Trigger 3: calculate_grand_total_after_update
        $trigger3 = "CREATE TRIGGER `calculate_grand_total_after_update` AFTER UPDATE ON `pembelian_detail`
        FOR EACH ROW BEGIN
            UPDATE pembelian
            SET grand_total = (
                SELECT COALESCE(SUM(pd.qty * m.harga), 0)
                FROM pembelian_detail pd
                JOIN metadata m ON pd.Produk_id = m.Produk_id
                WHERE pd.Pembelian_id = NEW.Pembelian_id
            ) + (
                SELECT COALESCE(ongkos_kirim, 0)
                FROM kurir
                WHERE kurir_id = (SELECT kurir_id FROM pembelian WHERE pembelian_id = NEW.Pembelian_id)
            )
            WHERE pembelian_id = NEW.Pembelian_id;
        END";

        // Trigger 4: pengurangan_stok
        $trigger4 = "CREATE TRIGGER `pengurangan_stok` AFTER INSERT ON `pembelian_detail`
        FOR EACH ROW BEGIN
            UPDATE produk
            SET stok = stok - NEW.qty
            WHERE Produk_id = NEW.Produk_id;
            UPDATE produk
            SET stok = 0
            WHERE Produk_id = NEW.Produk_id AND stok < 0;
        END";

        // Trigger 5: pengurangan_stok_metadata
        $trigger5 = "CREATE TRIGGER `pengurangan_stok_metadata` AFTER INSERT ON `pembelian_detail`
        FOR EACH ROW BEGIN
            UPDATE produk
            SET stok = stok - NEW.qty
            WHERE Produk_id = NEW.Produk_id;
            UPDATE metadata
            SET Stok = Stok - NEW.qty
            WHERE Produk_id = NEW.Produk_id;
            UPDATE produk
            SET stok = 0
            WHERE Produk_id = NEW.Produk_id AND stok < 0;
            UPDATE metadata
            SET Stok = 0
            WHERE Produk_id = NEW.Produk_id AND Stok < 0;
        END";

        // Execute each trigger creation
        $this->db->query($trigger1);
        $this->db->query($trigger2);
        $this->db->query($trigger3);
        $this->db->query($trigger4);
        $this->db->query($trigger5);
    }

    public function down()
    {
        // Drop triggers in reverse order
        $this->db->query("DROP TRIGGER IF EXISTS `pengurangan_stok_metadata`");
        $this->db->query("DROP TRIGGER IF EXISTS `pengurangan_stok`");
        $this->db->query("DROP TRIGGER IF EXISTS `calculate_grand_total_after_update`");
        $this->db->query("DROP TRIGGER IF EXISTS `calculate_grand_total_after_insert`");
        $this->db->query("DROP TRIGGER IF EXISTS `calculate_grand_total`");
    }
}