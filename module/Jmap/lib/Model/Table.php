<?php

namespace Jmap\Model;

class Table {
	private $table;
	private $nameTable;
	private $pk;
	private $fk;
	private $colums;

	private $msg;

	private $actionSave;

	private $relations;

	private $crypt;
	private $cryptList;
	private $filter;

	private $fields;

	public function __construct($nameTable = '', Field $fields, $crypt = false) {

		$this->crypt     = $crypt;
		$this->nameTable = trim($nameTable);
		
		$this->msg       = array();
		$this->colums    = array();
		
		$this->fields    = $fields;

		//var_dump($fields->get());

		$dataProcesada   = $fields->get();

		$this->pk        = $dataProcesada['table']['pks'];
		$this->fk        = $dataProcesada['table']['fks'];
		$this->colums    = $dataProcesada['table']['colums'];
		$this->relations = $dataProcesada['relation'];
		$this->cryptList = $dataProcesada['crypt'];

		// en esta variable se guardan todos los PKs, a ser generados o guardados
		// solo puede ver un auto incremental en una tabla
		$this->actionSave = array(
			'create'    => false, // define si la acion de save fue un create
			'id_insert' => null, // el valor genrado por el aitoincremental
			'column'    => null, // la columna que tiene autoincemental
		);

	}

	private function filter() {
		if (is_null($this->filter)) {
			$this->filter = new \Jmap\Model\Filter($this->fields);
		}
		return $this->filter;
	}

	public function table() {
		if (is_null($this->table)) {
			if ($this->nameTable == '') {
				throw new \Exception('Ingrese el nombre de la tabla');
			}
			$this->table = new \Zend\Db\TableGateway\TableGateway($this->nameTable, Adapter::getAdapter());
		}
		return $this->table;
	}

	// puede ser un "numero", o un array
	public function getById($id) {

		if (is_null($id)) {
			return;
		}

		$ids = $this->filterPk($id);

		$rowset = $this->table()->select(function (\Zend\Db\Sql\Select $select) use ($ids) {
			$select->where($ids);
			$select->limit(1);
		});

		$row = $rowset->current();
		return (is_object($row)) ? $this->processDataDb($row) : NULL;
	}

	/**
	 *
	 * retorna todos los elemtos que
	 * @param  array   $listValues nombreColumna => valorColumna
	 * @param  bool    $toArray    determina si el reultado es en formato array
	 * @return obj             retorna todo los resultados de la base de datos
	 */
	public function getByColumnName(array $listValues, $toArray = true) {

		$rowset = $this->table()->select($listValues);
		if (!$toArray) {
			return $rowset;
		}

		$data_return = array();
		foreach ($rowset as $key => $value) {
			$row = array();
			foreach ($value as $key2 => $value2) {
				$row[$key2] = $value2;
			}
			$data_return[] = $row;
		}
		return $this->processDataDb($data_return);

	}

	/**
	 *
	 * retorna la tabla filtrada por el nombre de la columan y el valor
	 * @param  array   $listValues nombreColumna => valorColumna
	 * @param  bool    $toArray    determina si el reultado es en formato array
	 * @return obj             retorna todo los resultados de la base de datos
	 */
	public function getFirstByColumnName($listValues, $toArray = true) {

		//$rowset = $this->table()->select($listValues);
		$rowset = $this->table()->select(function (\Zend\Db\Sql\Select $select) use ($listValues) {
			$select->where($listValues);
			$select->limit(1);
		});

		$row = $rowset->current();

		$dataReturn = array();
		if ($toArray) {
			if (is_object($row)) {

				foreach ($row as $key => $value) {
					$dataReturn[$key] = $value;
				}
			}
		} else {
			$dataReturn = (is_object($row)) ? $row : NULL;
		}

		return $this->processDataDb($dataReturn);
	}

	/*
		filtra los datos pasados al PK
		-> si $id es string, el Pk debe ser string
		-> si $id es array, el PK debe ser array, y deben tener lso mismos campos para que pase
	*/
	private function filterPk($id) {

		$ids = array();

		if (count($this->pk) == 1) {
			// caso que el PK sea unico
			if (!is_string($id) && !is_numeric($id)) {
				// el ID que pasa debe ser un string o numero
				throw new \Exception("El ID debe ser un String o un Numero");
			}
			foreach ($this->pk as $columnName => $attr) {
				$ids = array($columnName => $id);
			}
		} else {
			// caso que existan varios PKs, los ids que ingresan tambien deben array, se filtra solo los campos que son de pk, los demas campos se eliminan
			if (!is_array($id)) {
				// si no es array, lanza un error
				throw new \Exception('Los IDS deben estar contenido en un array ');
			}
			foreach ($this->pk as $columnName => $attr) {
				if (!isset($id[$columnName])) {
					// si en el array no existe el campo, laza un error
					throw new \Exception("No esta definido el ID :  $columnName ");
				}
				$ids[$columnName] = $id[$columnName];
			}
		}

		return $ids;
	}

	public function getAll($toArray = true, $rp = null, $page = null) {

		// debe ser la data del entity
		if (is_null($page) || is_null($rp)) {
			$rowset = $this->table()->select();
		} else {
			$rowset = $this->table()->select(function (\Zend\Db\Sql\Select $select) use ($rp, $page) {
				$offset = (int) (($page - 1) * $rp);
				$select->limit($rp);
				$select->offset($offset);
			});
		}

		if ($toArray) {
			return $this->processDataDb($this->toArray($rowset));
		} else {
			return $this->processDataDb($rowset);
		}
	}

	/**
	 * retorna los datos con los filtro que se definio en el fileds,
	 * por lo general se usa par aobtener pequeños datos
	 * como tipo de documento, tipos de telefonos, donde se necesite que el id sea de tipo int
	 * @param  boolean $toArray [description]
	 * @param  [type]  $rp      [description]
	 * @param  [type]  $page    [description]
	 * @return [type]           [description]
	 */
	public function getAllFilter($toArray = true, $rp = null, $page = null) {

		$data = $this->getAll($toArray, $rp, $page);

		return $this->filter()->collection($data);

	}

	/**
	 * retorna un rowset con todos los relationGetinfo incluidos en sus filas
	 * @param  boolean $toArray si se va a convertir en array
	 * @return obj           resultado de la consulta uniendo las tablas
	 */
	public function getRelation($where = array(), $column = array(), $toArray = true) {

		$relations = $this->relations;
		$fks = $this->fk;
		//$columns = array_keys($this->colums);
		$nameTable = $this->nameTable;
		//var_dump($columns);
		//var_dump($fks);
		$where = $this->processWhere($where);
		//$column = $this->processColumn($column);

		$rowset = $this->table()->select(function (\Zend\Db\Sql\Select $select) use ($relations, $nameTable, $where, $column) {

			foreach ($relations as $typeRelation => $relation) {
				foreach ($relation as $attr) {
					// es el primer tipo de relacion definido
					/*
					'getinfo' =>
					array (size=4)
					'column_relationA' => string 'identity_type_id' (length=16)
					'column_relationB' => string 'id' (length=2)
					'tableB' => string 'test_identity_type' (length=33)
					'columnB' =>
					array (size=1)
					'valorforaneo' => string 'name' (length=4)
					'join' => string 'left' (length=4)
					 */
					if ($typeRelation == 'getInfo') {
						$select->join(
							$attr['tableB'], // table name
							"{$nameTable}.{$attr['column_relationA']} = {$attr['tableB']}.{$attr['column_relationB']}", // expression to join on (will be quoted by platform object before insertion),
							$attr['columnB'], // (optional) list of columns, same requirements as columns() above
							$select::JOIN_LEFT// (optional), one of inner, outer, left, right also represented by constants in the API
						);
					}
				}
			}

			if (count($where) > 0) {
				$select->where($where);
			}

			if (count($column) > 0) {
				$select->columns($column);
			}
		});

		if ($toArray) {
			return $this->processDataDb($this->toArray($rowset));
		} else {
			return $this->processDataDb($rowset);
		}

	}

	/**
	 * retorna los datos con los filtro que se definio en el fileds,
	 * por lo general se usa par aobtener pequeños datos
	 * como tipo de documento, tipos de telefonos, donde se necesite que el id sea de tipo int
	 * @param  boolean $toArray [description]
	 * @param  [type]  $rp      [description]
	 * @param  [type]  $page    [description]
	 * @return [type]           [description]
	 */
	public function getRelationFilter($where = array(), $column = array(), $toArray = true) {

		$data = $this->getRelation($where, $column, $toArray);

		return $this->filter()->collection($data);

	}

	public function search(array $data) {

		//array('column'=>$column,'value'=>$value,'type'=>'like'),

		$where = new \Zend\Db\Sql\Where();
		foreach ($data as $row) {
			$where->like($this->nameTable . '.' . $row['column'], '%' . $row['value'] . '%');
		}

		return $this->getRelation($where);
	}

	/**
	 * filtra las columnas de la tabla para que no ingresen otras columnas
	 * @param  array  $where [description]
	 * @return [type]        [description]
	 */
	private function processWhere($where) {
		//array('id' => 2,'column'=>'a');
		if ($where instanceof \Zend\Db\Sql\Where) {
			return $where;
		}
		$where_filter = array();
		foreach ($where as $key => $value) {
			$where_filter[$this->nameTable . '.' . $key] = $value;
		}
		return $where_filter;
	}

	//private function processColumn(array $column) {
	//	// aqui se debe filtrar si estam bien escritos los nombres de las columnas
	//}

	private function toArray($rowset) {
		$data_return = array();
		foreach ($rowset as $key => $value) {
			$row = array();
			foreach ($value as $key2 => $value2) {
				$row[$key2] = $value2;
			}
			$data_return[] = $row;
		}
		return $data_return;
	}

	public function getCount() {
		//$rowset = $this->table()->select(function (\Zend\Db\Sql\Select $select) {
		//	$select->columns(array('count' => new \Zend\Db\Sql\Expression('COUNT(*)')));
		//});
		//$row = $rowset->current();
		//return (int) $row->count;

		return $this->getAll(false)->count();

	}

	/*
		separa los Pk, Fk de los datos generales de la entidad,
		tambien indica si debo actualizar o insertar
	*/
	private function prepareData($data, $showPrepa = false) {
		$prepare = array('pk' => array(), 'fk' => array(), 'element' => array(), 'uc' => '', 'pkNai' => 0);

		foreach ($data as $columnName => $value) {

			if (isset($this->pk[$columnName]) || isset($this->fk[$columnName])) {

				if (isset($this->pk[$columnName])) {
					if (!$this->pk[$columnName]) {
						$prepare['pkNai']++;
					}
					// un primary key no debe ser null o 0
					if (is_null($value) || $value == 0) {
						if (!$this->pk[$columnName]) {
							// esta tratando de ingresar ingresar un campo que no tiene autoincremental
							throw new \Exception("El campo  $columnName debe ser auto incremental; o debe colocar un nunero en el PK ");
						} else {
							// guardo el campo autoincremtal , para poder guardar el insert asignado
							$this->actionSave['column'] = $columnName;
						}
					} else {
						$prepare['pk'][$columnName] = $value;
					}

				}

				if (isset($this->fk[$columnName])) {
					$prepare['fk'][$columnName] = $value;
					$prepare['element'][$columnName] = $value;
				}

			} else {
				$prepare['element'][$columnName] = $value;
			}
		}

		//if($showPrepa) {
		//	var_dump(count($prepare['fk']));
		//	var_dump(count($prepare['pk']));
		//	var_dump(count($prepare['element']));
		//	var_dump($prepare['pkNai']);
		//}

		// en el caso que el numero de elemntos de PK, FK, elemts, num de PkNai sean iguales, se trata de una tabla manyToMany
		// generado por la funcion relation de Jmap
		if (count($prepare['fk']) == count($prepare['pk']) && count($prepare['fk']) == count($prepare['element']) && $prepare['pkNai'] == count($prepare['pk'])) {

			// en esta primera etapa solo vamos a insertar los datos
			// se bebe analizar mas para saber como hacer un update o insert
			// un pista es que se debe consultar en la base de datos si existe el row

			$this->actionSave['create'] = true;
			$prepare['uc'] = 'create';
		} else {
			if (count($prepare['pk']) > 0) {
				// pude ser que se quiera hacer un update
				$this->actionSave['create'] = false;
				$prepare['uc'] = 'update';
			} else {
				// no inserto PK , necesita que sea un insert
				$this->actionSave['create'] = true;
				$prepare['uc'] = 'create';
			}
		}

		return $prepare;
	}

	public function save($data = array(), $showPrepa = false) {

		$this->msg = array();
		try {
			$prepareData = $this->prepareData($data, $showPrepa);

			//if($showPrepa) { var_dump($prepareData);}

			if ($prepareData['uc'] == 'update') {
				return $this->update($prepareData['element'], $prepareData['pk']);
			} else {
				return $this->create($prepareData['element']);
			}
		} catch (\Exception $e) {
			$this->msg[] = $e->getMessage();
			return false;
		}

	}

	private function update($dataUpdate, $dataWhere) {
		// seteo a null, el id porque en estw caso no se insrto nada
		$this->actionSave['id_insert'] = null;

		//var_dump('table update');
		//var_dump($dataUpdate);
		//var_dump($dataWhere);

		$this->table()->update($dataUpdate, $dataWhere);
		return true;
	}

	private function create($dataInsert) {

		//if($showPrepa) {
		//	var_dump('table insert');
		//	var_dump($dataInsert);
		//}

		$this->table()->insert($dataInsert);

		// si la columan no tenia un autoincremental, entonces retorna un null, caso contrario retorna un numero
		$this->actionSave['id_insert'] = (is_null($this->actionSave['column'])) ? null : (int) $this->table()->getLastInsertValue();

		return true;
	}

	/**
	 * esta funcion filtra los datos de la consulta
	 * @param  obj $data data de la bse de datos
	 * @return obj|array       respuesta procesada de la bas e de datos
	 */
	public function processDataDb($data = null) {
		if ($this->crypt === false) {
			return $data;
		}

		$encrip = new \Jmap\Util\Crypt();
		if (is_array($data)) {
			foreach ($data as $idRow => $row) {
				foreach ($this->cryptList as $columnCryp) {
					if (isset($row[$columnCryp])) {
						$data[$idRow][$columnCryp] = $encrip->dynamicEncode($row[$columnCryp]);
					}
				}
			}
		}
		//var_dump($this->cryptList);
		//var_dump($data);
		return $data;
	}

	public function getActionSave() {
		//var_dump($this->actionSave);
		return $this->actionSave;
	}

	public function getMessages() {
		return $this->msg;
	}

	public function getKeys() {
		return array(
			'pk' => $this->pk,
			'fk' => $this->fk,
		);
	}

	public function getColums() {
		return $this->colums;
	}

	public function getNameTable() {
		return $this->nameTable;
	}

	public function getRelations() {
		return $this->relations;
	}

}
