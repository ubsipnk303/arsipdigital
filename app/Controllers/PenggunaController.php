<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use CodeIgniter\Email\Email;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Email as ConfigEmail; 

class PenggunaController extends BaseController
{
    public function login(){
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('sandi');

        $pengguna   = (new PenggunaModel())->where('email', $email)->first();
      
        if($pengguna == null){
            return $this->response->setJSON(['message'=>'Email tidak terdaftar'])
                        ->setStatusCode(404);
        }

        $cekPassword = password_verify($password, $pengguna['sandi']);
        if($cekPassword == false){
            return $this->response->setJSON(['message'=>'Email dan sandi tidak cocok'])
                        ->setStatusCode(403);
        }

        $this->session->set('pengguna', $pengguna);
        return $this->response->setJSON(['message'=>"Selamat datang {$pengguna['nama']} "])
                    ->setStatusCode(200);
    }
    
    public function viewLogin(){
        return view('login');
    }

    public function lupaPassword(){
        $_email = $this->request->getPost('email');

        $pengguna = (new PenggunaModel())->where('email', $_email)->first();

        if($pengguna == null){
            return $this->response->setJSON(['message'=>'Email tidak terdaftar'])
                        ->setStatusCode(404);
        }

        $sandibaru = substr( md5( date('Y-m-dH:i:s')),5,5 );
        $pengguna['sandi'] = password_hash($sandibaru, PASSWORD_BCRYPT);
        $r = (new PenggunaModel())->update($pengguna['id'], $pengguna);

        if($r == false){
            return $this->response->setJSON(['message'=>'Gagal merubah sandi'])
                        ->setStatusCode(502);
        }

        $email = new Email(new ConfigEmail());
        $email->setFrom('ubsi.pnk303@gmail.com', 'Sistem Arsip Digital');
        $email->setTo($pengguna['email']);
        $email->setSubject('Reset Sandi Pengguna');
        $email->setMessage("Hallo {$pengguna['nama']} telah meminta reset baru. Reset baru kamu adalah <b>$sandibaru</b>");
        $r = $email->send();

        if($r == true){
            return $this->response->setJSON(['message'=>"Sandi baru sudah di kirim ke alamat email $_email"])
                        ->setStatusCode(200);
        }else{
            return $this->response->setJSON(['message'=>"Maaf ada kesalahan pengiriman email ke  $_email"])
                                ->setStatusCode(500);
        }
    }

    public function viewLupaPassword(){ 
        return view('lupa_password');
    }

    public function logout(){
        $this->session->destroy();
        return redirect()->to('login');
    }

    public function index(){
        return view('Pengguna/table');
    }

    public function all(){
        $pm = new PenggunaModel(); 
        $pm->select('id, nama, gender, email');
        
        return (new Datatable( $pm ))
                ->setFieldFilter(['nama', 'email', 'gender'])
                ->draw();
    }

    public function show($id){
        $r = (new PenggunaModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();
        
        return $this->response->setJSON($r);
    }

    public function store(){
        $pm     = new PenggunaModel();
        $sandi  = $this->request->getVar('sandi');

        $id = $pm->insert([
            'nama'      => $this->request->getVar('nama'),
            'gender'    => $this->request->getVar('gender'),
            'email'     => $this->request->getVar('email'),
            'sandi'     => password_hash($sandi, PASSWORD_BCRYPT),
        ]);
        return $this->response->setJSON(['id' => $id])
                    ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update(){
        $pm     = new PenggunaModel();
        $id     = (int)$this->request->getVar('id');
     
        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil  = $pm->update($id, [
            'nama'      => $this->request->getVar('nama'),
            'gender'    => $this->request->getVar('gender'),
            'email'     => $this->request->getVar('email'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete(){
        $pm     = new PenggunaModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil ]);
    }

}

