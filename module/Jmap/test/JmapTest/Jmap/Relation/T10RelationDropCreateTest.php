<?php
namespace JmapTest\Jmap;

class T10RelationDropCreateTest extends \JmapTest\Base {

	public function test_retorno_de_un_array() {

		$tableUser = new \JmapTest\Jmap\Entity\Relation\TableUser();

		$tablephoneType = new \JmapTest\Jmap\Entity\Relation\TablePhoneType();
		$tablephone = new \JmapTest\Jmap\Entity\Relation\TablePhone();

		$tableIdentiType = new \JmapTest\Jmap\Entity\Relation\TableIdentiType(); // tipodoc

		$tableNivelType = new \JmapTest\Jmap\Entity\Relation\TableNivelType(); // tipodoc

		$metadata = new \Jmap\Model\MetadataDdl();


		$objMultipleUserNivel = new \Jmap\Util\RelationMultipleTable($tableUser->table());

		$tableUserNivel = $objMultipleUserNivel->getTable('nivel');

		//-------------------------------------------------------------------

		$metadata->dropTableIfExists($tablephone->table());
		$metadata->dropTableIfExists($tableUser->table());
		$metadata->dropTableIfExists($tablephoneType->table());
		$metadata->dropTableIfExists($tableIdentiType->table());
		$metadata->dropTableIfExists($tableNivelType->table());

		//-------------------------------------------------------------------

		$metadata->createTable($tableNivelType->table());
		$metadata->createTable($tableIdentiType->table());
		$metadata->createTable($tablephoneType->table());

		$metadata->createTable($tableUser->table());
		$metadata->createTable($tablephone->table());

		//-------------------------------------------------------------------

		$tableNivelType->setData(array('name' => 'Ing.'))->save();
		$tableNivelType->setData(array('name' => 'Arq.'))->save();
		$tableNivelType->setData(array('name' => 'Est.'))->save();

		$tableIdentiType->setData(array('name' => 'DNI'))->save();
		$tableIdentiType->setData(array('name' => 'LE'))->save();
		$tableIdentiType->setData(array('name' => 'Carnet'))->save();

		$tablephoneType->setData(array('name' => 'Celular'))->save();
		$tablephoneType->setData(array('name' => 'Fijo'))->save();
		$tablephoneType->setData(array('name' => 'RPM'))->save();

		$tableUser->setData(array('identity_type_id' => '1', 'name' => 'persona A', 'last_name' => 'App A'))->save();
		$tableUser->setData(array('identity_type_id' => '2', 'name' => 'persona B', 'last_name' => 'App B'))->save();
		$tableUser->setData(array('identity_type_id' => '3', 'name' => 'persona C', 'last_name' => 'App C'))->save();


		$tableUserNivel->save(array('test_user_id' => '1','test_nivel_id'=>'1'));
		$tableUserNivel->save(array('test_user_id' => '1','test_nivel_id'=>'3'));
		$tableUserNivel->save(array('test_user_id' => '2','test_nivel_id'=>'1'));
		$tableUserNivel->save(array('test_user_id' => '3','test_nivel_id'=>'2'));


		$tablephone->setData(array('user_id' => 1, 'number' => '321654', 'type_phone_id' => 1))->save();
		$tablephone->setData(array('user_id' => 1, 'number' => '847567', 'type_phone_id' => 2))->save();
		$tablephone->setData(array('user_id' => 2, 'number' => '564575', 'type_phone_id' => 3))->save();

		//$metadata->dropTableIfExists($tablephone->table());
		//$metadata->dropTableIfExists($tableUser->table());
		//$metadata->dropTableIfExists($tablephoneType->table());
		//$metadata->dropTableIfExists($tableIdentiType->table());

	}

}
