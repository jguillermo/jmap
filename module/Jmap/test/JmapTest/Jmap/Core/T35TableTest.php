<?php
namespace JmapTest\Jmap;

class T35TableTest extends \JmapTest\Base {

	public function test_inserdata_generar_id_primarykey() {

		$test = new \JmapTest\Jmap\Entity\Entity();

		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($test->table());

		$metadata->createTable($test->table());

		//create rows

		$test->setData(array('colum1' => 'hola1', 'colum2' => 'hola2', 'colum3' => 'hola3'));
		if (!$test->save()) {
			var_dump($test->getMessages());
		};
		$this->assertSame(1, $test->entity()->id);

		$test->setData(array('colum1' => 'hola11', 'colum2' => 'hola22', 'colum3' => 'hola33'));
		if (!$test->save()) {
			var_dump($test->getMessages());
		};
		$this->assertSame(2, $test->entity()->id);

		//update rows

		$test->setData(array('id' => '1', 'colum1' => 'hola1a', 'colum2' => 'hola2a', 'colum3' => 'hola3a'));
		if (!$test->save()) {
			var_dump($test->getMessages());
		};
		$this->assertSame(1, $test->entity()->getId());

		$test->setData(array('id' => '2', 'colum1' => 'hola1b', 'colum2' => 'hola2b', 'colum3' => 'hola3b'));
		if (!$test->save()) {
			var_dump($test->getMessages());
		};
		$this->assertSame(2, $test->entity()->getId());

		// get by id

		$test->loadById(1);
		$this->assertSame(1, $test->entity()->getId());

		$test->loadById(2);
		$this->assertSame(2, $test->entity()->getId());

		$test->loadById(3);
		$this->assertSame(null, $test->entity()->getId());

		$test->loadById(1);
		$this->assertSame(1, $test->entity()->getId());

		$metadata->dropTableIfExists($test->table());

	}

	public function test_cru_data_entity() {

		$test = new \JmapTest\Jmap\Entity\Entity();

		// test a la clase entidad
		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($test->table());

		$metadata->createTable($test->table());

		// ingresando un dato
		$test->table()->save(array('colum1' => 'hola1'));
		$this->assertSame(1, $test->table()->getCount());

		// insertando un nuevo row
		$test->table()->save(array('colum1' => 'hola2'));
		$this->assertSame(2, $test->table()->getCount());

		// retornnado todos los elementos de la tabla
		$data_table = $test->table()->getAll();
		$this->assertSame('1', $data_table[0]['id']);
		$this->assertSame('2', $data_table[1]['id']);

		// get data by ID
		$row1 = $test->loadById(1)->getData();
		$this->assertSame(1, $row1['id']);
		$this->assertSame('hola1', $row1['colum1']);

		// update el campo  id=1
		$test->table()->save(array('id' => 1, 'colum1' => 'hola1_edit'));
		$row1 = $test->table()->getById(1);
		$this->assertSame('1', $row1->id);
		$this->assertSame('hola1_edit', $row1->colum1);

		// caso el dato no existe, retorna un array con todos los campos null
		$row1 = $test->loadById(3)->getData();
		$this->assertSame(null, $row1['id']);

		$metadata->dropTableIfExists($test->table());

	}

	public function test_cru_table() {

		// pueba unitario a la clase Table, insertando todos los campos
		$fields       = array();
		$fields['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);

		$fie = new \Jmap\Model\Field($fields);

		$table = new \Jmap\Model\Table('test_table', $fie);

		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($table);

		$metadata->createTable($table);

		$table->save(array('colum1' => 'hola1'));
		$this->assertSame(1, $table->getCount());

		$data_table = $table->getAll();

		// l atabla genero 2 columnas
		$this->assertSame(2, count($data_table[0]));

		$table->save(array('colum1' => 'hola2'));
		$this->assertSame(2, $table->getCount());

		$row1 = $table->getById(1);
		$this->assertSame('1', $row1->id);
		$this->assertSame('hola1', $row1->colum1);

		$table->save(array('id' => 1, 'colum1' => 'hola1_edit'));
		$row1 = $table->getById(1);
		$this->assertSame('1', $row1->id);
		$this->assertSame('hola1_edit', $row1->colum1);

		$row1 = $table->getById(3);
		$this->assertSame(null, $row1);

		$metadata->dropTableIfExists($table);

	}

	public function test_cru_table_varias_palabras() {

		// pueba unitario a la clase Table, insertando todos los campos
		$fields       = array();
		$fields['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);

		$fie = new \Jmap\Model\Field($fields);

		$table = new \Jmap\Model\Table('test_table_2', $fie);

		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($table);

		$metadata->createTable($table);

		$rpta_save = $table->save(array('colum1' => 'hola1'));
		//var_dump(array('save1'=>$rpta_save));
		$this->assertSame(1, $table->getCount());
		//var_dump($table->getMessages());

		$rpta_save = $table->save(array('colum1' => 'hola como estas'));
		//var_dump(array('save2'=>$rpta_save));
		$this->assertSame(2, $table->getCount());
		//var_dump($table->getMessages());

		$row1 = $table->getById(2);
		$this->assertSame('2', $row1->id);
		$this->assertSame('hola como estas', $row1->colum1);

		$row2 = $table->getById(1);
		$this->assertSame('1', $row2->id);
		$this->assertSame('hola1', $row2->colum1);

		$metadata->dropTableIfExists($table);

	}

}
