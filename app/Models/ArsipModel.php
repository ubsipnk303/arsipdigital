<?php

namespace App\Models;

use CodeIgniter\Model;

class ArsipModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'arsip';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    static public function view(){
        $subquery = (new ArsipModel())
                        ->join('kategori', 'arsip.kategori_id=kategori.id', 'left')
                        ->join('pengguna', 'arsip.pengguna_id=pengguna.id', 'left')
                        ->select('arsip.*, kategori.kategori, pengguna.nama as pengguna ')
                        ->builder();
                                                
        $r = db_connect()->newQuery()
                           ->fromSubquery($subquery, 'tbl');
        $r->table = '';
                           
        return $r;
    }   

}
