<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class KategoriTest extends CIUnitTestCase{
    use FeatureTestTrait;

    public function testSimpan(){
        $json = $this->call('post', 'kategori', [
            'kategori' => 'testing kategori'
        ])->getJSON();

        $js = json_decode($json, true);
        $this->assertTrue( intval($js['id']) > 0 );
        
        $this->call('patch', 'kategori/'.$js['id'], [
            'kategori' => 'testing update'
        ])->assertStatus(200);

        $this->call('delete', 'kategori/'.$js['id'])
             ->assertStatus(200);

    }

    public function testBaca(){
        $this->call('get', 'kategori')
             ->assertStatus(200);
    }
}