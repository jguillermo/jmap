<?php
namespace JmapTest\Jmap;

class T12FieldsTest extends \JmapTest\Base {

	public function test_inicio_de_fields() {
		
		$lista=array();

		$lista['id'] = array(
			
			'form' => array(
				'type' => 'Zend\Form\Element\Hidden',
			),
			'filter' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'Jmap\Filter\PrimaryKeyInt'),
					array('name' => 'Int'),
				),
			),
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
		);

		$lista['identity_type_id'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => ' ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'tonull'),
					array('name' => 'Int'),
				),
			),
			'table' => array('type' => 'integer', 'index' => array('test_identity_type', 'id')),
			'relation' => array('type' =>'getInfo','name'=>'valorforaneo','entity'=>'JmapTest\Jmap\Entity\Relation\TableIdentiType','column'=>'name'),
		);

		$lista['name'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => ' ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required' => false,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 0,
							'max' => 12,
						),
					),
				),
			),
			'table' => array('type' => 'varchar',),
		);





		$obj = new \Jmap\Model\Field($lista);

		$data_procesada = $obj->get();

		$fields = array(
			'table' => array(
				'colums' => array(),
				'pks' => array(
					'ai' => array(),
					'nai' => array(),
				),
				'fks' => array(),
			),
			'relation' => array(
				'getInfo' => array(),
				'getCollection' => array(),
			),
			'form' => array(),
			'filter' => array(),
			'crypt'=>array(),
		);

		foreach ($fields as $key => $value) {
			$this->assertSame(true,is_array($data_procesada[$key]) );
			foreach ($value as $key2 => $value2) {
				$this->assertSame(true,is_array($data_procesada[$key][$key2]) );
			}
		}

		//falta definir mas test
		//execpcion cuando se reppiten los relation_names
		//excepcion cuando no esta declarado el PK
		//si es PK se debe pasar directamente a notnull


	}

}
