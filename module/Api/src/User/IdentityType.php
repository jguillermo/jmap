<?php
namespace Api\User;

class IdentityType extends \Jmap\Mapper {

	public function __construct($id = null) {
		parent::__construct('user_identity_type', $id);
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
				'options'    => array(
					'label' => 'Nombre: ',
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
							'min'      => 1,
							'max'      => 24,
						),
					),
				),
			),
			'table'  => array('type' => 'varchar'),
		);

		//$fields['user_csrf'] = array(
		//	'form' => array(
		//		'type' => 'Zend\Form\Element\Csrf',
		//		'name' => 'user_csrf',
		//		'options' => array(
		//			'csrf_options' => array(
		//				'timeout' => 600,
		//			),
		//		),
		//	),
		//);

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

		return $fields;

	}

	/**
	 * retorna la cantidad de usurios que tiene un determinado tipo de documento
	 * @return array lista de tipos de documentos y usuarios
	 */
	public function getListCountUser() {
		$data = array(
			array('Tipo', 'Cantidad'),
		);

		$rowset = $this->table()->table()->select(function (\Zend\Db\Sql\Select $select) {
				$select->join(
					'user', // table name
					"user.identityType_id = user_identity_type.id", // expression to join on (will be quoted by platform object before insertion),
					array(), // (optional) list of columns, same requirements as columns() above
					$select::JOIN_LEFT// (optional), one of inner, outer, left, right also represented by constants in the API
				);
				$select->columns(array(
					'count' => new \Zend\Db\Sql\Expression('COUNT(*)'),
					'name'

					));
				$select->group('user_identity_type.id');
		});

		
		foreach ($rowset as $key => $row) {
			$data[]=array($row->name,(int) $row->count);
		}
		
		return $data;

	}

}