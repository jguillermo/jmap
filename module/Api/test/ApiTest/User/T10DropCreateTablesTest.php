<?php
namespace ApiTest;

class DropCreateTables extends \ApiTest\Base {

	public function test_crear_tablas() {


		$personas = array(
			array('name'=>'Joacin Duberly','lastName'=>'Mejia','secondLastName'=>'Romero','identityType_id' => '1','identityNumber'  =>'43500056'),
			array('name'=>'Lucy Irene','lastName'=>'Lamas','secondLastName'=>'Matos','identityType_id' => '1','identityNumber'  =>'42489727'),
			array('name'=>'Hernán','lastName'=>'quispe','secondLastName'=>'pampamallco','identityType_id' => '1','identityNumber'  =>'01299323'),
			array('name'=>'Héctor Mário Ericson','lastName'=>'Martínez','secondLastName'=>'Romero','identityType_id' => '1','identityNumber'  =>'42119476'),
			array('name'=>'David','lastName'=>'Villacrez','secondLastName'=>'Tafur','identityType_id' => '1','identityNumber'  =>'42846537'),
			array('name'=>'Efrain Milton','lastName'=>'Inza','secondLastName'=>'Callupe','identityType_id' => '1','identityNumber'  =>'04028219'),
			array('name'=>'Marco','lastName'=>'Garcia','secondLastName'=>'Chirinos','identityType_id' => '1','identityNumber'  =>'74024931'),
			array('name'=>'Llanelid','lastName'=>'Fernández','secondLastName'=>'López','identityType_id' => '1','identityNumber'  =>'45197984'),
			array('name'=>'eder wilsson','lastName'=>'sullon','secondLastName'=>'pasache','identityType_id' => '1','identityNumber'  =>'47554811'),
			array('name'=>'HUGO HEINRICH','lastName'=>'ORTIZ','secondLastName'=>'RIOS','identityType_id' => '1','identityNumber'  =>'09843023'),
			array('name'=>'Javier','lastName'=>'Reynoso','secondLastName'=>'Oscanoa','identityType_id' => '2','identityNumber'  =>'20072967'),
			array('name'=>'Brenda','lastName'=>'Martinez','secondLastName'=>'Sosa','identityType_id' => '1','identityNumber'  =>'41906061'),
			array('name'=>'Gabriela','lastName'=>'Quispe','secondLastName'=>'Cerrón','identityType_id' => '1','identityNumber'  =>'75619157'),
			array('name'=>'Javier','lastName'=>'Vilcahuaman','secondLastName'=>'Ponce','identityType_id' => '1','identityNumber'  =>'20064379'),
			array('name'=>'Juan Henry','lastName'=>'Taipe','secondLastName'=>'Alanya','identityType_id' => '2','identityNumber'  =>'47499514'),
			array('name'=>'Junior Juan','lastName'=>'Huaman','secondLastName'=>'Medina','identityType_id' => '1','identityNumber'  =>'70078340'),
			array('name'=>'Jesus','lastName'=>'Condori','secondLastName'=>'Cutisaca','identityType_id' => '1','identityNumber'  =>'20054292'),
			array('name'=>'Ignacio Miguel','lastName'=>'Trujillo','secondLastName'=> 'De LaCruz','identityType_id' => '1','identityNumber'  =>'43387335'),
			array('name'=>'Erick Deybis','lastName'=>'Villena','secondLastName'=>'Luis','identityType_id' => '2','identityNumber'  =>'46766882'),
			array('name'=>'Miluska Almida','lastName'=>'Luna','secondLastName'=>'Valdez','identityType_id' => '1','identityNumber'  =>'41084413'),
			array('name'=>'Ruth Lola','lastName'=>'Carrera','secondLastName'=>'Cabezas','identityType_id' => '1','identityNumber'  =>'21286314'),
			array('name'=>'Bryan Raphael','lastName'=>'Vargas','secondLastName'=>'Quispe','identityType_id' => '1','identityNumber'  =>'47100627'),
			array('name'=>'Raul','lastName'=>'Alcarraz','secondLastName'=>'Ricaldi','identityType_id' => '1','identityNumber'  =>'20119165'),
			array('name'=>'Fernando','lastName'=>'Orellana','secondLastName'=>'Canales','identityType_id' => '1','identityNumber'  =>'20015271'),
			array('name'=>'Hugo','lastName'=>'Santillan','secondLastName'=>'Guevara','identityType_id' => '4','identityNumber'  =>'76623127'),
			array('name'=>'Greysi','lastName'=>'Huacho','secondLastName'=>'Chocce','identityType_id' => '1','identityNumber'  =>'70672260'),
			array('name'=>'Rosa America','lastName'=>'Lozano','secondLastName'=>'Eulogio','identityType_id' => '3','identityNumber'  =>'20053245'),
			array('name'=>'Carla Violeta','lastName'=>'Rojas','secondLastName'=>'Cevallos','identityType_id' => '1','identityNumber'  =>'47361250'),
			array('name'=>'Marilyn Hortesiana','lastName'=>'Gomez','secondLastName'=>'Peña','identityType_id' => '1','identityNumber'  =>'19819383'),
			array('name'=>'Nilton Dik','lastName'=>'Campos','secondLastName'=>'Gaspar','identityType_id' => '1','identityNumber'  =>'40824514'),
			array('name'=>'Elmer','lastName'=>'Quispe','secondLastName'=>'Huachos','identityType_id' => '1','identityNumber'  =>'40533588'),
			array('name'=>'Rossio','lastName'=>'Fernandez','secondLastName'=>'Luna','identityType_id' => '1','identityNumber'  =>'42192389'),
			array('name'=>'Juan Jose','lastName'=>'Santillan','secondLastName'=>'Rojas','identityType_id' => '1','identityNumber'  =>'72921793'),
			array('name'=>'Jordan Eugenio','lastName'=>'Sinche','secondLastName'=>'Barra','identityType_id' => '3','identityNumber'  =>'72629945'),
			array('name'=>'Darwin','lastName'=>'Paucar','secondLastName'=>'Vila','identityType_id' => '1','identityNumber'  =>'74033216'),
			array('name'=>'Juan','lastName'=>'Quispa','secondLastName'=>'Huaraccallo','identityType_id' => '1','identityNumber'  =>'71731860'),
			array('name'=>'Miguel Angel','lastName'=>'Serpa','secondLastName'=>'Santillan','identityType_id' => '1','identityNumber'  =>'73592866'),
			array('name'=>'Kevin','lastName'=>'Zamudio','secondLastName'=>'Portocarrero','identityType_id' => '1','identityNumber'  =>'48181374'),
			array('name'=>'shanet','lastName'=>'ESPINOZA','secondLastName'=>'GUETTI','identityType_id' => '1','identityNumber'  =>'44738753'),
			array('name'=>'Edwin Jose','lastName'=>'Osorio','secondLastName'=>'Contreras','identityType_id' => '3','identityNumber'  =>'20107973'),
			array('name'=>'Luis Enrique','lastName'=>'Espejo','secondLastName'=>'Riveros','identityType_id' => '1','identityNumber'  =>'49875892'),
			array('name'=>'Evazeto','lastName'=>'Roger','secondLastName'=>'Ricaldi','identityType_id' => '1','identityNumber'  =>'45428675'),
			array('name'=>'Juan Ubaldo','lastName'=>'Cunya','secondLastName'=>'Muñoz','identityType_id' => '1','identityNumber'  =>'23209975'),
			array('name'=>'Rosana Miloska','lastName'=>'Ordaya','secondLastName'=>'Canchanya','identityType_id' => '3','identityNumber'  =>'45923370'),
			array('name'=>'Celestino Sixto','lastName'=>'Segovia','secondLastName'=>'Paco','identityType_id' => '1','identityNumber'  =>'23549294'),
			array('name'=>'Jacinto Vicente','lastName'=>'Valladolid','secondLastName'=>'Coquel','identityType_id' => '3','identityNumber'  =>'19898545'),
			array('name'=>'Wendy Carolay','lastName'=>'Navarro','secondLastName'=>'Romo','identityType_id' => '1','identityNumber'  =>'70315463'),
			array('name'=>'Bruno','lastName'=>'Welerme','secondLastName'=>'Inga','identityType_id' => '4','identityNumber'  =>'20075696'),
			array('name'=>'Maximo Rocky','lastName'=>'Berrospi','secondLastName'=>'Mercado','identityType_id' => '1','identityNumber'  =>'71481473'),
		);


		$phoneType      = new \Api\Pub\PhoneType();
		
		$user           = new \Api\User\User();
		
		$userPhone      = new \Api\User\Phone();
		
		$userIdentityType = new \Api\User\IdentityType(); 
		
		$metadata       = new \Jmap\Model\MetadataDdl();
		
		//-------------------------------------------------------------------

		$metadata->dropTableIfExists($userPhone->table());

		$metadata->dropTableIfExists($phoneType->table());

		$metadata->dropTableIfExists($user->table());

		$metadata->dropTableIfExists($userIdentityType->table());

		//-------------------------------------------------------------------

		$metadata->createTable($userIdentityType->table());

		$metadata->createTable($user->table());

		$metadata->createTable($phoneType->table());

		$metadata->createTable($userPhone->table());

		//-------------------------------------------------------------------


		$userIdentityType->setData(array('name' => 'DNI'))->save();
		$userIdentityType->setData(array('name' => 'LE'))->save();
		$userIdentityType->setData(array('name' => 'Pasaporte'))->save();
		$userIdentityType->setData(array('name' => 'carnet de extranjeria'))->save();


		$phoneType->setData(array('name' => 'Celular','pattern'=>'[0-9]{8,9}','pattern_msg'=>'Ingresar 9 números'))->save();
		$phoneType->setData(array('name' => 'RPM','pattern'=>'[\*#][0-9]{1,9}','pattern_msg'=>'Ingresar máximo 9 números con el comodín * o # al inicio'))->save();
		$phoneType->setData(array('name' => 'Fijo','pattern'=>'(\([0-9]+\))?[0-9\-]{7,}','pattern_msg'=>'Solo ingresar Números de la forma : (##)###-####'))->save();
		

		foreach ($personas as  $dataPersona) {
			if(!$user->setData($dataPersona)->save()){
				var_dump($user->getMessages());
			}
		}
		//$user->setData(array('identityType_id' => '1','identityNumber'  => '11111111','name'=> 'A','lastName'=> 'AA','secondLastName'  => 'AAA'))->save();
		//$user->setData(array('identityType_id' => '1','identityNumber'  => '22222222','name'=> 'B','lastName'=> 'BB','secondLastName'  => 'BBB'))->save();
		//$user->setData(array('identityType_id' => '2','identityNumber'  => '33333333','name'=> 'C','lastName'=> 'CC','secondLastName'  => 'CCC'))->save();


		$userPhone->setData(array('user_id' => 1, 'number' => '321654', 'phone_type_id' => 1))->save();
		$userPhone->setData(array('user_id' => 1, 'number' => '847567', 'phone_type_id' => 2))->save();
		$userPhone->setData(array('user_id' => 2, 'number' => '564575', 'phone_type_id' => 3))->save();


		$this->assertSame(1,1);

		//$metadata->dropTableIfExists($tablephone->table());
		//$metadata->dropTableIfExists($tableUser->table());
		//$metadata->dropTableIfExists($tablephoneType->table());
		//$metadata->dropTableIfExists($tableIdentiType->table());
		

	}

}
