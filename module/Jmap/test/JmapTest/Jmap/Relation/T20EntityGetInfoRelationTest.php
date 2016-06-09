<?php
namespace JmapTest\Jmap;

class T20EntityGetInfoRelationTest extends \JmapTest\Base {

	public function test_retorno_de_un_array() {
		
		$user = new \JmapTest\Jmap\Entity\Relation\TableUser();
		
		$user->loadById(1);
		$this->assertSame('DNI',$user->entity()->valorforaneo());
		
		$user->loadById(2);
		$this->assertSame('LE',$user->entity()->valorforaneo());

		$user->loadById(3);
		$this->assertSame('Carnet',$user->entity()->valorforaneo());

		// caso no existe el id buscado
		$user->loadById(4);
		$this->assertSame(null,$user->entity()->valorforaneo());

		//$this->assertSame('DNI','DNI');
		//$this->assertSame('LE','LE');
		
	}

	public function test_retorno_lista_con_joins() {
		
		$user = new \JmapTest\Jmap\Entity\Relation\TableUser();
		
		$data = $user->table()->getRelation();

		$this->assertSame('DNI',$data[0]['valorforaneo']);
		$this->assertSame('persona A',$data[0]['name']);

		//var_dump($data);
		
		
	}


	public function test_lista_de_phone_varias_tablas_relacionadas() {
		
		$phone = new \JmapTest\Jmap\Entity\Relation\TablePhone();
		
		$data = $phone->table()->getRelation();

		$this->assertSame('321654',$data[0]['number']);
		$this->assertSame('persona A',$data[0]['test_user_name']);
		$this->assertSame('App A',$data[0]['test_user_last_name']);
		$this->assertSame('Celular',$data[0]['tipo_telefono']);

		//var_dump($data);
		
		
	}


	public function test_where_filter() {
		
		$user = new \JmapTest\Jmap\Entity\Relation\TableUser();
		
		$data = $user->table()->getRelation(array('id'=>1));
		
		$this->assertSame(1,count($data));

		//$this->assertSame('DNI',$data[0]['valorforaneo']);
		//$this->assertSame('persona A',$data[0]['name']);

		//var_dump($data);
		
	}


	public function test_columns_filter() {
		
		$user = new \JmapTest\Jmap\Entity\Relation\TableUser();
		
		$data = $user->table()->getRelation(array('id'=>1),array('name','last_name'));
		
		$this->assertSame(false,isset($data[0]['id']));
		$this->assertSame(false,isset($data[0]['identity_type_id']));
		//var_dump($data);
		
	}



	


}
