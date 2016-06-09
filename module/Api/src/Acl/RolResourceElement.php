<?php
namespace Api\Acl;

class RolResourceElement extends \Jmap\Mapper {

	public function __construct($id = null) {
		parent::__construct('acl_rol_resource_element', $id);
	}

	/**
	 * retorna todo slos campos que se deben guardar en la base de datos y los campos de seguridad
	 * @param  boolean $triggerValue true, genera lso datos iniciales de cada campo, false no optien los datos
	 * @return array                array de los campos usados
	 */
	public function listFields($triggerValue = false) {

		$fields = array();

		$fields['rol_id'] = array(

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
			'table'  => array('type' => 'integer', 'primary' => true,  'index' => array('acl_rol', 'id')),
		);

		$fields['resource_element_id'] = array(
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
			'table'  => array('type' => 'integer', 'primary' => true,  'index' => array('acl_resource_element', 'id')),
		);

		$fields['permission'] = array(

			'form'   => array(
				'type' => 'Zend\Form\Element\Hidden',
			),
			'filter' => array(
				'required' => true,
				'filters'  => array(
					array('name' => 'Int'),
				),
			),
			'table'  => array('type' => 'integer'),
		);

		

		return $fields;

	}

}