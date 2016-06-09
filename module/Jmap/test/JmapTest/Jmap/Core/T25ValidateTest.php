<?php
namespace JmapTest\Jmap;

class T25ValidateTest extends \JmapTest\Base {

	public function test_is_valid_sin_id() {

		

		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setData(array(
			'colum1' => 'texto1',
			'colum2' => 'texto2',
			'colum3' => 'texto3',
			'colum4' => 'texto4',
			'colum5' => 'texto5',
			'colum6' => 'texto6',
			'colum7' => 'texto7',
		));

		$isValid = $test->isValid();
		if (!$isValid) {
			var_dump($test->getMessages());
		}
		$this->assertTrue($isValid);
	}

	public function test_is_valid_total() {

		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setData(array(
			'id' => '15',
			'colum1' => 'texto1',
			'colum2' => 'texto2',
			'colum3' => 'texto3',
			'colum4' => 'texto4',
			'colum5' => 'texto5',
			'colum6' => 'texto6',
			'colum7' => 'texto7',
		));

		$isValid = $test->isValid();
		if (!$isValid) {
			var_dump($test->getMessages());
		}
		$this->assertTrue($isValid);
	}

	public function test_is_valid_parcial() {

		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setData(array(
			'id' => '15',
			'colum1' => 'texto1',
		));

		$isValid = $test->isValid(array('id', 'colum1'));
		if (!$isValid) {
			var_dump($test->getMessages());
		}
		$this->assertTrue($isValid);
	}


	public function test_genera_array_mensaje_error() {

		$test = new \JmapTest\Jmap\Entity\Entity();

		$isValid = $test->isValid();
		$msg=$test->getMessages();
		$this->assertTrue(isset($msg['form']));

		//var_dump($msg['form']);
		$this->assertTrue((count($msg['form'])>0));
	}

}
