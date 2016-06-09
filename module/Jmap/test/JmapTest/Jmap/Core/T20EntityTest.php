<?php
namespace JmapTest\Jmap;

class T20EntityTest extends \JmapTest\Base {

	public function test_retorno_de_un_array() {

		$test   = new \JmapTest\Jmap\Entity\Entity();
		$fields = $test->fields()->get();
		$this->assertTrue(is_array($fields));
	}

	public function test_una_sola_entidad_creada() {
		//JmapTest\Jmap\Entity\Entity
		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->entity()->colum1 = 'texto 1';

		$this->assertSame($test->entity()->colum1, 'texto 1');
	}

	public function test_set_data_null() {
		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setdata(array(
			'colum1' => 'texto 1',
			'colum2' => 'texto 2',
		));
		$this->assertSame($test->entity()->getColum1(), 'texto 1');

		$test->setdata(array(
			'colum3' => 'texto 3',
		), true);
		$this->assertSame($test->entity()->getColum3(), 'texto 3');
		$this->assertSame($test->entity()->getColum1(), null);

	}

	public function test_relation_get_info() {
		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setdata(array(
			'colum1' => 'texto 1',
			'colum2' => 'texto 2',
		));
		$this->assertSame($test->entity()->getColum1(), 'texto 1');

		$test->setdata(array(
			'colum3' => 'texto 3',
		), true);
		$this->assertSame($test->entity()->getColum3(), 'texto 3');
		$this->assertSame($test->entity()->getColum1(), null);

	}

}
