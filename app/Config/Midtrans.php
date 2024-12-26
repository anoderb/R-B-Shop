<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey = 'SB-Mid-server-AoZtrXWQVeCymsD_SEwpPbRS';
    public $isProduction = false; // Ganti ke true jika live
    public $isSanitized = true;
    public $is3ds = true;
}
