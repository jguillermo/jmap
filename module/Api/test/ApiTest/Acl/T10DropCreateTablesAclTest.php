<?php
namespace ApiTest;

class T10DropCreateTablesAclTest extends \ApiTest\Base {

	public function test_crear_tablas() {


		


		$rol                = new \Api\Acl\Rol();
		
		$resource           = new \Api\Acl\Resource();
		
		$resourceElement    = new \Api\Acl\ResourceElement();
		
		$rolResourceElement = new \Api\Acl\RolResourceElement(); 
		
		
		$metadata       = new \Jmap\Model\MetadataDdl();

		//-------------------------------------------------------------------

		$metadata->dropTableIfExists($rol->table());

		$metadata->dropTableIfExists($resource->table());

		$metadata->dropTableIfExists($resourceElement->table());

		$metadata->dropTableIfExists($rolResourceElement->table());

		//-------------------------------------------------------------------

		$metadata->createTable($rol->table());

		$metadata->createTable($resource->table());

		$metadata->createTable($resourceElement->table());

		$metadata->createTable($rolResourceElement->table());

		

		$this->assertSame(1,1);

		//$metadata->dropTableIfExists($tablephone->table());
		//$metadata->dropTableIfExists($tableUser->table());
		//$metadata->dropTableIfExists($tablephoneType->table());
		//$metadata->dropTableIfExists($tableIdentiType->table());
		

	}

}
