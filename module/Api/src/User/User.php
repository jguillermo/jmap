<?php
namespace Api\User;

class User extends \Jmap\Mapper {

	public function __construct($id = null) {
		parent::__construct('user', $id);
	}

	/**
	 * retorna todo slos campos que se deben guardar en la base de datos y los campos de seguridad
	 * @param  boolean $triggerValue true, genera lso datos iniciales de cada campo, false no optien los datos
	 * @return array                array de los campos usados
	 */
	public function listFields($triggerValue = false) {

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
			'crypt'  => true,
		);

		$fields['identityType_id'] = array(
			'form'     => array(
				//'type' => 'Zend\Form\Element\Select',
				//'name' => 'identityType_id',
				//'options' => array(
				//	'label' => 'Tipo de documento : ',
				//	'value_options' => array(), //\Core\Model\Select::tableToArray('identity_type','id','name'),
				//),
				//'attributes' => array(
				//	'value' => '1',
				//),
				'type'       => 'Zend\Form\Element\Text',
				'options'    => array(
					'label' => 'Nro. Documento : ',
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
			'table'    => array('type' => 'integer', 'index' => array('user_identity_type', 'id')),
			'relation' => array('type' => 'getInfo', 'name' => 'identityType', 'entity' => 'Api\User\IdentityType', 'column' => 'name'),
		);

		$fields['identityNumber'] = array(
			'form'   => array(
				'type'       => 'Zend\Form\Element\Text',
				'options'    => array(
					'label' => 'Nro. Documento : ',
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
			'table'  => array('type' => 'integer'),
		);

		$fields['name'] = array(
			'form'   => array(
				'type'       => 'Zend\Form\Element\Text',
				'name'       => 'name',
				'options'    => array(
					'label' => 'Nombre : ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required'   => true,
				'name'       => 'name',
				'filters'    => array(
					array('name' => 'null'),
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 100,
						),
					),
				),
			),
			'table'  => array('type' => 'varchar'),
		);

		$fields['lastName'] = array(
			'form'   => array(
				'type'       => 'Zend\Form\Element\Text',
				'name'       => 'lastName',
				'options'    => array(
					'label' => 'Ap. Paterno : ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required'   => true,
				'name'       => 'lastName',
				'filters'    => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 100,
						),
					),
				),
			),
			'table'  => array('type' => 'varchar'),
		);

		$fields['secondLastName'] = array(
			'form'   => array(
				'type'       => 'Zend\Form\Element\Text',
				'name'       => 'secondLastName',
				'options'    => array(
					'label' => 'Ap. Materno : ',
				),
				'attributes' => array(
					'autocomplete' => 'off',
				),
			),
			'filter' => array(
				'required'   => false,
				'name'       => 'secondLastName',
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
							'max'      => 100,
						),
					),
				),
			),
			'table'  => array('type' => 'varchar'),
		);

		$fields['submit'] = array(
			'form' => array(
				'type'       => 'Zend\Form\Element\Submit',
				'name'       => 'submit',
				'attributes' => array(
					'value' => 'Submit',
				),
				'options'    => array(
					'label' => 'Guardar',
				),
			),
		);

		$fields['phone'] = array(
			'relation' => array('type' => 'getCollection', 'entity' => 'Api\User\Phone', 'columnA' => 'id', 'columnB' => 'user_id', 'column' => array('id', 'number', 'phone_type_id', 'phone_type')),
		);

		return $fields;

	}

}