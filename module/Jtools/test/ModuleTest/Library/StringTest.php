<?php
namespace ModuleTest\Library;

class StringTest extends \ModuleTest\Base {

	public function test_crear_datos() {

		$str= new \Jtools\Library\String();

		
		$data = $str->getArraySubStr('djskdfjb"data","1"sdfsef"data","2"sdf','"data","','"');


		$this->assertSame(array('1','2') ,$data);

	}


	public function test_crear_datos_lista() {

		$str= new \Jtools\Library\String();

		
		$data = $str->getArraySubStr('djskdfjb"data","abc"sdfsef"data","def"sdf','"data","','"');


		$this->assertSame(array('abc','def') ,$data);

	}


	public function test_crear_datos_empty() {

		$str= new \Jtools\Library\String();

		
		$data = $str->getArraySubStr('djskdfjb"data",""sdfsef"data",""sdf','"data","','"');


		$this->assertSame(array('','') ,$data);

	}

}
