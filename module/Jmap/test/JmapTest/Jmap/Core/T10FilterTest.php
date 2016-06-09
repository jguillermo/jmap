<?php
namespace JmapTest\Jmap;

class T10FilterTest extends \JmapTest\Base {

	public function test_filtro_primary_key_int() {

		$obj = new \Jmap\Filter\PrimaryKeyInt();

		$this->assertSame(0, $obj->filter(null));
		$this->assertSame(0, $obj->filter('0'));
		$this->assertSame(0, $obj->filter(0));

		$this->assertSame(1, $obj->filter('1'));
		$this->assertSame(1, $obj->filter(1));

		$this->assertSame('1.1', $obj->filter('1.1'));
		//$this->assertSame(1, 1, $obj->filter(1, 1));

		$this->assertSame('hola', $obj->filter('hola'));

		$this->assertSame('', $obj->filter(''));

		$this->assertSame(array(1, 2, 3), $obj->filter(array(1, 2, 3)));

	}

	public function test_filtros_de_texto() {
		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setData(array(
			'colum1' => 'texto1<br><p> se debe borrar</p>',
			'colum2' => ' texto2 ',
		));

		$test->isValid();
		$data = $test->getData();

		$this->assertEquals($data['colum1'], 'texto1 se debe borrar');
		$this->assertEquals($data['colum2'], 'texto2');
		$this->assertTrue(is_int($data['id']));

		$this->assertEquals($data['id'], 0);

	}

}
