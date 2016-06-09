<?php
namespace Jmap;

class Mapper implements MapperInterface {

	private $entity;
	private $table;
	protected $nTable;
	private $form;
	protected $msg;
	private $fields;
	private $filters;

	public function __construct($nTable, $id = null) {
		$this->nTable = $nTable;
		if (!is_null($id)) {
			$this->loadById($id);
		}
	}

	/**
	 * este metodo se debe sobreescribir, aqui van todo los campos de la tabla y/o formulario
	 * tambien se definen todos los tipos de relacion que tiene un entity
	 * @return [type] [description]
	 */
	protected function listFields() {
		return array();
	}

	/**
	 * este metodo debe ser llamado una sola vez, y se encarga de filtrar y mejorar el array, para no tener errores
	 * @return array Fields filtrados
	 */
	public function fields() {

		if (is_null($this->fields)) {
			$this->fields = new Model\Field($this->listFields());

		}
		return $this->fields;
	}

	/**
	 * genera un array de filtros que se debe pasar a cada campo
	 * @return array de filtros obj
	 */
	public function filters() {

		if (is_null($this->filters)) {
			$objFilter     = new Model\Filter($this->fields());
			$this->filters = $objFilter->get();

		}
		return $this->filters;
	}

	/**
	 * genera un object para poder escribir dentro de los campos, tambien genera las funcciones de relacion de cada campo
	 * @return obj
	 */
	public function entity() {
		if (is_null($this->entity)) {
			$objEntity = new Entity($this->fields());
			if ($this->fields()->isRelationMultiple()) {
				$objEntity->setTable($this->table());
			}
			$this->entity = $objEntity->get();
		}
		return $this->entity;
	}

	/**
	 * ingresa los datos en formado de array
	 * @param array   $data  datos de los campos a ingresar
	 * @param boolean $force si es TRUE, la entidad se pone a null y de nuevo se ingresan los datos
	 */
	public function setData($data = array()) {
		$this->entity = null;
		//if (is_null($data)) {return;}
		$this->entity();
		$table = $this->fields()->get('table');
		foreach ($table['colums'] as $columnName => $attr) {

			if (isset($data[$columnName])) {
				$this->entity->{'set' . ucfirst($columnName)}($data[$columnName]);
			} else {
				$this->entity->{'prv_' . $columnName} = null;
			}

		}

		return $this;
		/*
		filtrar lso campos que quiere buscar
		 */
		//$this->form($data)
	}

	/**
	 * retorna los datos selccionados en un array, si esta vacio retorna todos los elemtos
	 * @return array , datos de la entidad
	 */
	public function getData($elements = array()) {
		//
		// trabajr mejor en este script
		//
		//
		$this->entity();
		$data  = array();
		$table = $this->fields()->get('table');
		
		foreach ($table['colums'] as $columnName => $attr) {

			if (count($elements) > 0) {
				if (in_array($columnName, $elements)) {
					$data[$columnName] = $this->entity->{'get' . ucfirst($columnName)}();
				}
			} else {
				$data[$columnName] = $this->entity->{'get' . ucfirst($columnName)}();
				
			}

		}

		
		//var_dump($data);
		return $data;
	}

	/**
	 * retorna todos los datos de la entidad incluido los datos de las relaciones
	 * @param  int $id id de la entidaa buscar
	 * @return array     datos de la entidad incuiyendo las relaciones
	 */
	public function getAllData($id) {
		$this->loadById($id);
		$data = $this->getData();

		foreach ($this->fields()->get('relation') as $list_relation) {
			foreach ($list_relation as $name_relation => $attr_relation) {
				$data[$name_relation] = $this->entity()->{$name_relation}();
			}
		}
		return $data;

	}

	/**
	 * geenra un formualrio de acuerdo a los elementos que se le pasa
	 * @param  array  $elements lista de campos que se desea usar para fabricar el formulario
	 * @return obj           Form
	 */
	protected function form($elements = array()) {
		$frmKey = md5(implode('', $elements));
		if (!isset($this->form[$frmKey])) {
			$frm                 = new Model\Form($this->fields(), $elements);
			$this->form[$frmKey] = $frm->getForm();
		}
		return $this->form[$frmKey];
	}

	/**
	 * retorna el formulario creado, so no esta creado lo crea inmediatamente
	 * @param  array  $elements elemtos del formulario
	 * @return obj           ZEND/Form
	 */
	public function getForm($elements = array()) {
		return $this->form($elements);
	}

	/**
	 * valida todos los campos que se desea verificar,
	 * usarlo unicamente cuando se necesita validar algunos campos o se dese filtrar los datos ingresados
	 * @param  array   $elements lista de campos que se desea analizar, si es array(), se analizan todos los campos
	 * @return bool           est=> retorna si los campos sin validos o no
	 */
	public function isValid($elements = array()) {

		$this->msg['form'] = array();

		$this->form($elements)->setData($this->getData($elements));
		$isvalid = $this->form($elements)->isValid();

		//var_dump($isvalid);

		if (!$isvalid) {
			$this->msg['form'] = $this->form($elements)->getMessages();
		}

		//var_dump( $this->form($elements)->getMessages());
		//var_dump($this->form($elements)->getData());
		$this->setData($this->form($elements)->getData());
		//foreach ($this->form($elements)->getData() as $key => $value) {}

		//var_dump($this->form($elements)->getData());
		return $isvalid;
	}

	/**
	 * retorna los mesajes que genera la validacion de formuario o el crud en la base de datos
	 * @return array lista de mensajes
	 */
	public function getMessages() {
		if (is_null($this->msg)) {
			$this->msg['form']  = array();
			$this->msg['table'] = array();
		}
		return $this->msg;
	}

	/**
	 * retorna un objeto TableGateway para poder usar el crud
	 * Crypt es para obtener y encriptar los datos que tenguel el atributo Crypt=true
	 * @return obj
	 */
	public function table($crypt = false) {
		if (is_null($this->table)) {
			$this->table = new Model\Table($this->nTable, $this->fields(), $crypt);
		}
		return $this->table;
	}

	/**
	 * carga a la entidad la tabla de la base de datos
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function loadById($id) {

		$data = $this->table()->getById($id);
		//var_dump($data);
		// si no existe el registro , se pone a null la entidad , parq que se genere de nuevo
		if (is_null($data)) {
			$this->entity = null;
		} else {
			$this->setData($data);
			$this->isValid();
		}
		return $this;
	}

	/**
	 * va a validar todos los campos del formulario, si es corecto se va a guardar, caso contrario va a retornar un error
	 * @return [type] [description]
	 */
	public function save() {
		if ($this->isValid()) {
			if ($this->table()->save($this->getData())) {
				// aqui se debe guardar los id o pk generados
				$actionSave = $this->table()->getActionSave();
				// se l aaccion fue de crear y se uso un autoincrementar en la tabla
				if ($actionSave['create'] && !is_null($actionSave['column'])) {
					$this->entity()->{$actionSave['column']} = $actionSave['id_insert'];
				}
				return true;
			} else {
				$this->msg['table'] = $this->table()->getMessages();
				return false;
			}
		} else {
			return false;
		}
	}

}