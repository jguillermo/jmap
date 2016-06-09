<?php
namespace JmapTest\Jmap;

class T30EntityRelationCollectionTest extends \JmapTest\Base {

	public function test_retorno_de_un_array() {

		$user = new \JmapTest\Jmap\Entity\Relation\TableUser();

		$user->loadById(1);
		$data = $user->entity()->phone();

		// tiene 2 telefonos (rows)
		$this->assertSame(2, count($data));

		// tiene 4 columnas
		$this->assertSame(4, count($data[0]));

		$this->assertSame(1, $data[0]['id']);
		$this->assertSame(2, $data[1]['id']);

		$this->assertSame('Celular', $data[0]['tipo_telefono']);
		$this->assertSame('Fijo', $data[1]['tipo_telefono']);
		//var_dump($data);

		$user->loadById(2);
		$data = $user->entity()->phone();

		// tiene 1 telefonos (rows)
		$this->assertSame(1, count($data));

		// tiene 4 columnas
		$this->assertSame(4, count($data[0]));

		$this->assertSame(3, $data[0]['id']);
		$this->assertSame('RPM', $data[0]['tipo_telefono']);
		//var_dump($data);

	}

}
