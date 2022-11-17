<?php

use CodeIgniter\Email\Email;
use CodeIgniter\Test\CIUnitTestCase; 
use Config\Email as ConfigEmail;

/**
 * @internal
 */
class EmailTest extends CIUnitTestCase{
    
    public function testKirimEmail(){ 
        $email = new Email( new ConfigEmail());
        $email->setFrom('ubsi.pnk303@gmail.com');
        $email->setTo('agung.ako@bsi.ac.id');
        $email->setSubject('Testing Kirim Email');
        $email->setMessage('Hallo selamat <b>bergabung</b>');
        $s = $email->send(false);
        $em = $email->printDebugger();
        print($em);
        $this->assertTrue( $s  );
    }
}