<?php

namespace App\Database\Seeds;

use App\Models\ArsipModel;
use CodeIgniter\Database\Seeder;

class ArsipSeeder extends Seeder
{
    public function run()
    {
        (new ArsipModel())->insert([
            'nomor'     => '123/BSI/IX/2022',
            'judul'     => 'Surat Keterangan',
            'ringkasan' => 'Surat Keterangan sebagai mahasiswa',
            'tgl'       => '2022-09-12',
            'kategori_id' => 1,
            'pengguna_id' => 1
        ]);
    }
}
