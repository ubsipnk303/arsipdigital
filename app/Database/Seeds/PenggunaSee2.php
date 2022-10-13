<?php

namespace App\Database\Seeds;

use App\Models\PenggunaModel;
use CodeIgniter\Database\Seeder;

class PenggunaSee2 extends Seeder
{
    public function run()
    {
        $mp = new PenggunaModel();
        $r= $mp->insert([
            'nama' => 'Budi',
            'gender' => 'L',
            'email'  => 'budi@gmail.com',
            'sandi'  => password_hash('123456', PASSWORD_BCRYPT),
            
        ]);
        echo "hasil = $r";
    }
}
