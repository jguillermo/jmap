<?php
namespace Api\User;

class Phone extends \Jmap\Mapper {

	public function __construct($id = null) {
		parent::__construct('user_phone', $id);
	}

	protected function listFields($triggerValue = false) {

		$fields = array();

		$fields['id'] = array(

			'form'   => array(
				'type' => 'Zend\Form\Element\Hidden',
			),
			'filter' => array(
				'required' => true,
				'filters'  => array(
					array('name' => 'Jmap\Filter\PrimaryKeyInt'),
					array('name' => 'Int'),
				),
			),
			'table'  => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
		);

		$fields['user_id'] = array(
			'form'     => array(
				'type'       => 'Zend\Form\Element\Text',
				'options'    => array(
					'label' => ' ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter'   => array(
				'required' => true,
				'filters'  => array(
					array('name' => 'Null'),
					array('name' => 'Int'),
				),
			),
			'table'    => array('type' => 'integer', 'index' => array('user', 'id')),
			'relation' => array('type' => 'getInfo', 'name' => 'user_name', 'entity' => 'Api\User\User', 'column' => array('name', 'lastName')),
		);

		$fields['number'] = array(
			'form'   => array(
				'type'       => 'Zend\Form\Element\Text',
				'options'    => array(
					'label' => ' ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required'   => false,
				'filters'    => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 0,
							'max'      => 12,
						),
					),
				),
			),
			'table'  => array('type' => 'varchar'),
		);

		$fields['phone_type_id'] = array(
			'form'     => array(
				'type'       => 'Zend\Form\Element\Text',
				'options'    => array(
					'label' => ' ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter'   => array(
				'required' => true,
				'filters'  => array(
					array('name' => 'Null'),
					array('name' => 'Int'),
				),
			),
			'table'    => array('type' => 'integer', 'default'=>'1', 'index' => array('pub_phone_type', 'id')),
			'relation' => array('type' => 'getInfo', 'name' => 'phone_type', 'entity' => 'Api\Pub\PhoneType', 'column' => 'name'),
		);

		return $fields;

	}

}