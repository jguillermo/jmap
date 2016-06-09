<?php
namespace JmapTest\Jmap;

class T15DataTest extends \JmapTest\Base {

	public function test_get_data() {

		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->entity()->setColum1('texto 1');

		$data = $test->getData();

		$this->assertSame($data['colum1'], 'texto 1');
	}

	public function test_set_data() {
		$test = new \JmapTest\Jmap\Entity\Entity();
		$test->setData(array(
			'colum1'         => 'texto1',
			'colum2'         => 'texto2',
			'submit'         => 'enviar',
			'colum_no_exist' => 'texto_no_exist',
		));
		$data = $test->getData();
		$this->assertSame($data['colum1'], 'texto1');
		$this->assertSame($data['colum2'], 'texto2');
		$this->assertTrue(!isset($data['submit']));
		$this->assertTrue(!isset($data['colum_no_exist']));
	}

}
