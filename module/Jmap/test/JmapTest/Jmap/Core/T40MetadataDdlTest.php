<?php
namespace JmapTest\Jmap;

// en este test se va a probar que se estan generando correctamente las tabas de la base de datos

class T40MetadataDdlTest extends \JmapTest\Base {



	public function test_crear_drop_table() {
		
		$fields = array();
		$fields['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);

		$objFields= new \Jmap\Model\Field($fields);

		$table = new \Jmap\Model\Table('test_metadta_crate_drop_table', $objFields);
		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($table);

		$this->assertSame(false, $metadata->isTable($table->getNameTable()));

		$metadata->createTable($table);

		$this->assertSame(true, $metadata->isTable($table->getNameTable()));

		$metadata->dropTableIfExists($table);


	}


	public function test_crear_int_primary_key() {
		$fields = array();
		$fields['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true,  'isNullable' => false),
		);

		$fields['id2'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'isNullable' => false),
		);
		
		$objFields= new \Jmap\Model\Field($fields);
		$table = new \Jmap\Model\Table('test_metadta_crate_primary_key', $objFields);
		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($table);

		$metadata->createTable($table);


		$table_info = $metadata->getTableColums( $table->getNameTable() );

		$table_constraints = $metadata->getTableConstraints( $table->getNameTable() );
		//var_dump($table_constraints);

		$this->assertSame('integer', $table_info['id']['type']);
		$this->assertSame(false, $table_info['id']['isNullable']);
		//$this->assertSame(true, $table_info['id']['unsigned']);

		$this->assertSame('id', $table_constraints['PRIMARY KEY'][0]);
		$this->assertSame('id2', $table_constraints['PRIMARY KEY'][1]);

		$metadata->dropTableIfExists($table);


	}





	public function test_metadta_integer_varchar() {

		$fields = array();
		$fields['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);
		$objFields= new \Jmap\Model\Field($fields);
		$table = new \Jmap\Model\Table('test_metadta_integer_varchar', $objFields);
		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($table);
		$metadata->createTable($table);


		$table_info = $metadata->getTableColums( $table->getNameTable() );


		$this->assertSame('varchar', $table_info['colum1']['type']);
		$this->assertSame(true, $table_info['colum1']['isNullable']);

		$metadata->dropTableIfExists($table);

	}

	public function test_metadta_integer_date() {

		$fields = array();
		$fields['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields['colum1'] = array(
			'table' => array('type' => 'date'),
		);
		$fields['colum2'] = array(
			'table' => array('type' => 'datetime'),
		);
		$fields['colum3'] = array(
			'table' => array('type' => 'time'),
		);
		$fields['colum4'] = array(
			'table' => array('type' => 'date','default'=>'2015-09-17'),
		);
		$fields['colum5'] = array(
			'table' => array('type' => 'datetime','default'=>'2015-09-17 17:01:16'),
		);
		$fields['colum6'] = array(
			'table' => array('type' => 'time','default'=>'17:01:16'),
		);
		$fields['colum7'] = array(
			'table' => array('type' => 'date','isNullable'=>false),
		);
		$objFields= new \Jmap\Model\Field($fields);
		$table = new \Jmap\Model\Table('test_metadta_integer_date', $objFields);
		$metadata = new \Jmap\Model\MetadataDdl();

		$metadata->dropTableIfExists($table);
		$metadata->createTable($table);
		

		$table_info = $metadata->getTableColums($table->getNameTable());

		$this->assertSame('date', $table_info['colum1']['type']);
		$this->assertSame('datetime', $table_info['colum2']['type']);
		$this->assertSame('time', $table_info['colum3']['type']);

		
		$this->assertEquals('2015-09-17', trim($table_info['colum4']['default'],"'"));
		$this->assertSame('2015-09-17 17:01:16', trim($table_info['colum5']['default'],"'"));
		$this->assertSame('17:01:16', trim($table_info['colum6']['default'],"'"));

		$this->assertSame(false, $table_info['colum7']['isNullable']);

		//var_dump($table_info);

		$metadata->dropTableIfExists($table);



	}



	public function test_metadta_llaves_foraneas() {

		$metadata = new \Jmap\Model\MetadataDdl();

		$fields0 = array();
		$fields0['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields0['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);
		//-----------------------------------------------------------------------------------------------------------
		$fields1 = array();
		$fields1['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields1['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);
		//-----------------------------------------------------------------------------------------------------------
		$fields2 = array();
		$fields2['id'] = array(
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'isNullable' => false),
		);
		$fields2['id_fk0'] = array(
			'table' => array('type' => 'integer', 'index'=>array('test_metadta_llaves_foraneas_0','id')),
		);
		$fields2['id_fk1'] = array(
			'table' => array('type' => 'integer', 'index'=>array('test_metadta_llaves_foraneas_1','id')),
		);
		$fields2['colum1'] = array(
			'table' => array('type' => 'varchar'),
		);
		//-----------------------------------------------------------------------------------------------------------

		$objFields0 = new \Jmap\Model\Field($fields0);
		$objFields1 = new \Jmap\Model\Field($fields1);
		$objFields2 = new \Jmap\Model\Field($fields2);


		$table0 = new \Jmap\Model\Table('test_metadta_llaves_foraneas_0', $objFields0);

		$table1 = new \Jmap\Model\Table('test_metadta_llaves_foraneas_1', $objFields1);

		$table2 = new \Jmap\Model\Table('test_metadta_llaves_foraneas_2', $objFields2);
		

		// elimina para que se puedan borra la stablas anexadas
		$metadata->dropTableIfExists($table2);


		$metadata->dropTableIfExists($table0);
		$metadata->createTable($table0);
		$table0->save(array('colum1'=>'attr0_1'));



		$metadata->dropTableIfExists($table1);
		$metadata->createTable($table1);
		$table1->save(array('colum1'=>'attr1_1'));


		
		$metadata->createTable($table2);
		$table2->save(array('colum1'=>'attr1','id_fk0'=>1,'id_fk1'=>1));


		$table_constraints = $metadata->getTableConstraints( $table2->getNameTable() );

		//var_dump($table_constraints);


		$this->assertSame(true,in_array("id_fk0", $table_constraints['FOREIGN KEY']));
		$this->assertSame(true,in_array("id_fk1", $table_constraints['FOREIGN KEY']));

		$metadata->dropTableIfExists($table2);
		$metadata->dropTableIfExists($table0);
		$metadata->dropTableIfExists($table1);

		//
		//
		//$this->assertSame('varchar', $table_info['colum1']['type']);
		//$this->assertSame(true, $table_info['colum1']['isNullable']);
		//
		//$metadata->dropTableIfExists($table);

	}


}
