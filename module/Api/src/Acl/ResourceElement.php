<?php
namespace Api\Acl;

class ResourceElement extends \Jmap\Mapper {

	public function __construct($id = null) {
		parent::__construct('acl_resource_element', $id);
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

		$fields['resource_id'] = array(

			'table'  => array('type' => 'integer',  'index' => array('acl_resource', 'id')),
			'relation' => array('type' => 'getInfo', 'name' => 'resource_element', 'entity' => 'Api\Acl\Rol', 'column' => 'name'),
		);

		

		return $fields;

	}

}