<?php
namespace JmapTest\Jmap\Entity;

class Entity extends \Jmap\Mapper  {
	
    public function __construct($id=null)
    {
    	parent::__construct('test',$id);
    }
    
	public function listFields( $triggerValue = false ) {

		$fields = array();

		$fields['id'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Hidden',
			),
			'filter' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'Jmap\Filter\PrimaryKeyInt'),
				),
				'validators' => array(
					array(
						'name' => 'isint',
					),
				),
			),
			'table' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true,'isNullable'=>false),
		);

		$fields['colum1'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'colum ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required' => true,
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
							'max' => 12,
						),
					),
				),
			),
			'table' => array('type' => 'varchar'),
		);

		$fields['colum2'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'colum ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required' => true,
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
							'max' => 12,
						),
					),
				),
			),
			'table' => array('type' => 'varchar'),
		);

		$fields['colum3'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'colum ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required' => true,
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
							'max' => 12,
						),
					),
				),
			),
			'table' => array('type' => 'varchar'),
		);

		$fields['submit'] = array(
			'form' => array(
				'type' => 'Zend\Form\Element\Submit',
				'name' => 'submit',
				'attributes' => array(
					'value' => 'Submit',
				),
				'options' => array(
					'label' => 'Guardar',
				),
			),
		);

		return $fields;

	}



}