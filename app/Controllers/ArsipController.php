<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\ArsipModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ArsipController extends BaseController
{
    public function index()
    { 
        return view('backend/arsip/table',[
            'data_kategori' => (new KategoriModel())->findAll()
        ]);
    }

    public function all(){
        return (new Datatable( ArsipModel::view() ))
                ->setFieldFilter(['nomor', 'judul', 'pengguna', 'kategori'])
                ->draw();
    }

    public function store(){
        $pm     = new ArsipModel(); 
        $pengguna = session('pengguna');

        $id = $pm->insert([
           'nomor' => $this->request->getVar('nomor'),
           'judul' => $this->request->getVar('judul'),
           'ringkasan' => $this->request->getVar('ringkasan'),
           'tgl' => $this->request->getVar('tgl'),
           'kategori_id' => $this->request->getVar('kategori_id'),
           'pengguna_id' => $pengguna['id']
        ]);
        return $this->response->setJSON(['id' => $id])
                    ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function show($id){
        $p = (new ArsipModel())->find($id);
        if($p == null)throw PageNotFoundException::forControllerNotFound();

        return $this->response->setJSON($p);

    }

    
    public function update(){
        $pm     = new ArsipModel();
        $id     = (int)$this->request->getVar('id');
     
        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();
        $pengguna = session('pengguna');

        $hasil  = $pm->update($id, [
            'nomor' => $this->request->getVar('nomor'),
           'judul' => $this->request->getVar('judul'),
           'ringkasan' => $this->request->getVar('ringkasan'),
           'tgl' => $this->request->getVar('tgl'),
           'kategori_id' => $this->request->getVar('kategori_id'),
           'pengguna_id' => $pengguna['id']
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete(){
        $pm     = new ArsipModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil ]);
 
    }
}
