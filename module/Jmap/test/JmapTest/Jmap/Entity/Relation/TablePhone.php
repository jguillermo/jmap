<?php
namespace JmapTest\Jmap\Entity\Relation;

class TablePhone extends \Jmap\Mapper  {
	
    public function __construct($id=null)
    {
    	parent::__construct('test_phone',$id);
    }
    
	protected function listFields( $triggerValue = false ) {

		$fields = array();

		$fields['id'] = array(
			
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

		$fields['user_id'] = array(
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
			'table' => array('type' => 'integer', 'index' => array('test_user', 'id')),
			'relation' => array('type' =>'getInfo','name'=>'nombre_usuario','entity'=>'JmapTest\Jmap\Entity\Relation\TableUser','column'=>array('name','last_name')),
		);

		$fields['number'] = array(
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


		$fields['type_phone_id'] = array(
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
			'table' => array('type' => 'integer', 'index' => array('test_phone_type', 'id')),
			'relation' => array('type' =>'getInfo','name'=>'tipo_telefono','entity'=>'JmapTest\Jmap\Entity\Relation\TablePhoneType','column'=>'name'),
		);


		return $fields;

	}



}