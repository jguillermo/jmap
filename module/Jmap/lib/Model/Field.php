<?php

namespace Jmap\Model;
/**
 * se define en esta clase como tableA la tabla actual y como tableB la tabla donde se va a sacer información
 * se define como columa_relation(colRelationA = colRelationB) a la relacion de union entre las 2 tablas
 * se define como columB las columnas de la tabla externa que se desea la información
 */
class Field {
	private $list;
	private $fields;

	public function __construct(array $list) {
		$this->list   = $list;
		$this->fields = array(
			'table'    => array(
				'name'   => '',
				'colums' => array(),
				'pks'    => array(),
				'fks'    => array(),
			),
			'relation' => array(
				'getInfo'       => array(),
				'getCollection' => array(),
				'getMultiple'   => array(),
			),
			'form'     => array(),
			'filter'   => array(),
			'crypt'    => array(),
			'defauld'  => array(),
		);
		$this->process();
	}

	private function process() {

		foreach ($this->list as $columnName => $columsDetails) {

			if (isset($columsDetails['table'])) {

				if (isset($columsDetails['crypt']) && $columsDetails['crypt'] === true) {
					$this->fields['crypt'][] = $columnName;
				}

				$this->processTable($columnName, $columsDetails['table']);

			}

			if (isset($columsDetails['relation'])) {

				$this->processRelation($columnName, $columsDetails['relation']);

			}

			if (isset($columsDetails['form'])) {
				$this->fields['form'][$columnName] = $columsDetails['form'];
			}

			if (isset($columsDetails['filter'])) {
				$this->fields['filter'][$columnName] = $columsDetails['filter'];
			}
		}

		if (count($this->fields['table']['colums']) > 0 && count($this->fields['table']['pks']) == 0) {
			throw new \Exception('Definir los Pk de la tabla');
		}

	}

	private function processTable($columnName, $attr) {

		$this->fields['table']['colums'][$columnName] = $attr;

		if (isset($attr['primary']) && $attr['primary'] === TRUE) {

			// todo PK debe ser notnull
			$this->fields['table']['colums'][$columnName]['isNullable'] = false;

			$this->fields['table']['pks'][$columnName] = (isset($attr['autoincrement']) && $attr['autoincrement'] === TRUE) ? true : false;

		}

		if (isset($attr['index'])) {

			// lanza un error cuando el valor no es un array o no tiene 2 elementos
			if (!array($attr['index']) || (is_array($attr['index']) && count($attr['index']) !== 2)) {
				throw new \Exception(" Definir el index en formato de array, en al comumna : $columnName  ");
			}

			// cambiar este campo para que sea PK, se debe cambiar de nobre en el tools
			$this->fields['table']['fks'][$columnName] = array(
				'table'  => $attr['index'][0],
				'column' => $attr['index'][1],
			);
		}

		if(isset($attr['default'])) {
			$this->fields['default'][$columnName] = $attr['default'];
		}
	}

	private function processRelation($columnName, $attr) {

		if (!isset($attr['type'])) {
			throw new \Exception("Definir el tipo de Relacion en la columna {$relationName}.");
		}

		$relationName = $columnName;
		// si esta definida el nombre de la relacion se cambia por ese nombre,
		// caso contrario es el nombre de la columna
		if (isset($attr['name'])) {
			$relationName = $attr['name'];
			unset($attr['name']);
		}

		$relationType = $attr['type'];
		unset($attr['type']);

		if (isset($this->fields['relation'][$relationType][$relationName])) {
			throw new \Exception("El nombre de relación {$relationName} ya esta definida.");
		}

		// se definen las columans A y B para que funcione la table->relation

		//si existe table FK, son para hacer relaciones con las tablas
		if (isset($this->fields['table']['fks'][$columnName])) {

			if ($relationType != 'getInfo') {
				throw new \Exception("La relacion {$relationName} debe ser de tipo getInfo, por tener index FKs ");
			}

			$attr['column_relationA'] = $columnName;
			$attr['column_relationB'] = $this->fields['table']['fks'][$columnName]['column'];
			$attr['tableB']           = $this->fields['table']['fks'][$columnName]['table'];

			// vamos a crear las columnas de l atablas para que no existe duplicidad
			$column_b_aux = array();
			if (isset($attr['column'])) {
				$column_b_aux = $attr['column'];
				unset($attr['column']);
			}

			$columnB = array();
			// se va a poner el nombre de la tabla antes de cada nombre de columna
			if (is_array($column_b_aux)) {
				foreach ($column_b_aux as $value) {
					$columnB[$attr['tableB'] . '_' . $value] = $value;
				}
			} else {
				// hay que pensar que debe paser en este modo, para que saquen los valores de la relacion o de la tabla
				// por ahora es del nombre de l arelacion, hay que tener cuidado de no repetir nombres de columnas
				//

				// en este caso no s epueden llamar de la misma forma
				// por eso se debe cambiar
				if ($relationName == $columnName) {
					$columnB[$attr['tableB'] . '_' . $column_b_aux] = $column_b_aux;
				} else {
					$columnB[$relationName] = $column_b_aux;
				}
			}

			$attr['columnB'] = $columnB;
		}

		if ($relationType == 'getMultiple') {

			if (!is_array($attr['column'])) {
				$attr['column'] = array($attr['column']);
			}

		}

		if (!isset($attr['join'])) {
			$attr['join'] = 'left';
		}

		$this->fields['relation'][$relationType][$relationName] = $attr;

		//var_dump("---------------------------------------");
		//var_dump($this->fields['relation'][$relationType][$relationName]);

		return true;

	}

	public function get($attr = null) {
		if (is_null($attr)) {
			return $this->fields;
		} else {
			if (isset($this->fields[$attr])) {
				return $this->fields[$attr];
			} else {
				return;
			}
		}

	}

	// verifica si existe la relacion multiple, manyToMany para poder mandar la tabla
	public function isRelationMultiple() {
		return (count($this->fields['relation']['getMultiple']) > 0) ? true : false;
	}

}
