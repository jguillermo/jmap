<?php
namespace JmapTest\Jmap\Entity\Relation;

class TableUser extends \Jmap\Mapper  {
	
    public function __construct($id=null)
    {
    	parent::__construct('test_user',$id);
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

		$fields['identity_type_id'] = array(
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

		$fields['name'] = array(
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

		$fields['last_name'] = array(
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


		$fields['phone'] = array(
			'relation' => array('type' =>'getCollection','entity'=>'JmapTest\Jmap\Entity\Relation\TablePhone','columnA'=>'id','columnB'=>'user_id','column'=>array('id','number','type_phone_id','tipo_telefono')),
		);

		$fields['nivel'] = array(
			'relation' => array('type' =>'getMultiple','entity'=>'JmapTest\Jmap\Entity\Relation\TableNivelType','columnA'=>'id','columnB'=>'id','column'=>'name'),
		);


		return $fields;

	}



}