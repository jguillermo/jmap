<?php
namespace JmapTest\Jmap;

class T99RelationDropTest extends \JmapTest\Base {

	public function test_retorno_de_un_array() {

		$tableUser = new \JmapTest\Jmap\Entity\Relation\TableUser();

		$tablephoneType = new \JmapTest\Jmap\Entity\Relation\TablePhoneType();
		$tablephone = new \JmapTest\Jmap\Entity\Relation\TablePhone();

		$tableIdentiType = new \JmapTest\Jmap\Entity\Relation\TableIdentiType(); // tipodoc

		$tableNivelType = new \JmapTest\Jmap\Entity\Relation\TableNivelType(); // tipodoc

		$metadata = new \Jmap\Model\MetadataDdl();

		

		$metadata->dropTableIfExists($tablephone->table());
		$metadata->dropTableIfExists($tableUser->table());
		$metadata->dropTableIfExists($tablephoneType->table());
		$metadata->dropTableIfExists($tableIdentiType->table());
		$metadata->dropTableIfExists($tableNivelType->table());

		

	}

}
