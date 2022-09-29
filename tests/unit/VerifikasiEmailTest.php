<?php

use CodeIgniter\Email\Email;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Email as ConfigEmail;

 class VerifikasiEmailTest extends CIUnitTestCase{

    public function testKirimEmail(){
        $e = new Email(new ConfigEmail);
        $e->setTo('agung.ako@bsi.ac.id');
        $e->setSubject('Test kirim email arsip digital');
        $e->setMessage('Hallo ini <b>Test email</b>');
        
        $r = $e->send();
        $this->assertTrue($r);
    }
 }