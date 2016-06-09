<?php
namespace ModuleTest\Library;

class CurlTest extends \ModuleTest\Base {

	public function test_crear_datos() {

		$curl= new \Jtools\Library\Curl();

		
		$data = $curl->get('http://192.168.1.128/devmap/public/admin/ajax/identity-type/list-all');
		$this->assertSame(isset($data['list']) ,true);

	}

}
