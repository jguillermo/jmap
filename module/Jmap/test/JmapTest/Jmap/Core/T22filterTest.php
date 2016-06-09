<?php
namespace JmapTest\Jmap;

class T22filterTest extends \JmapTest\Base {

	public function test_filtro_pk() {
		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->entity()->setId('1');
		$this->assertSame($test->entity()->getId(), 1);

	}

	public function test_filtro_set_data() {
		$test = new \JmapTest\Jmap\Entity\Entity();

		$test->setData(array(
			'id'     => '1',
			'colum1' => 'texto1<br><p> se debe borrar</p>',
			'colum2' => ' texto2 ',
		));

		$this->assertSame($test->entity()->getId(), 1);
		$this->assertSame($test->entity()->getColum1(), 'texto1 se debe borrar');
		$this->assertSame($test->entity()->getColum2(), 'texto2');

	}

}
