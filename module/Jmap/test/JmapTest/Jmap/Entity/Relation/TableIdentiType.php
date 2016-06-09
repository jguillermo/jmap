<?php
namespace JmapTest\Jmap\Entity\Relation;

class TableIdentiType extends \Jmap\Mapper  {
	
    public function __construct($id=null)
    {
    	parent::__construct('test_identity_type',$id);

    	//var_dump('me estan llamdno');
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

		$fields['name'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Nombre: ',
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
							'min' => 1,
							'max' => 24,
						),
					),
				),
			),
			'table' => array('type' => 'varchar',),
		);
		
		return $fields;

	}



}