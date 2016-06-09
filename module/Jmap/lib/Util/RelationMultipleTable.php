<?php

namespace Jmap\Util;

class RelationMultipleTable {

	/**
	 * genera un objeto Table de las relaciones GetMultiple
	 * @param array $arguments [description]
	 */

	private $collection;

	public function __construct(\Jmap\Model\Table $table) {

		$this->collection = array();
		$this->processTable($table->getRelations(), $table->getNameTable());

	}

	private function processTable($relations, $nameTable) {

		if (!isset($relations['getMultiple'])) {
			return;
		}
		//var_dump($relations['getMultiple']);
		foreach ($relations['getMultiple'] as $relationName => $attr) {

			$objClass   = new $attr['entity']();
			$nameTable2 = $objClass->table()->getNameTable();

			$fields                                      = array();
			$fields[$nameTable . '_' . $attr['columnA']] = array(
				'table' => array('type' => 'integer', 'primary' => true, 'isNullable' => false, 'index' => array($nameTable, $attr['columnA'])),
			);

			$fields[$nameTable2 . '_' . $attr['columnB']] = array(
				'table'    => array('type' => 'integer', 'primary' => true, 'isNullable' => false, 'index' => array($nameTable2, $attr['columnB'])),
				'relation' => array('type' => 'getInfo', 'name' => $relationName . '_relationf', 'entity' => $attr['entity'], 'column' => $attr['column']),
			);

			$objFields = new \Jmap\Model\Field($fields);
			//var_dump($nameTable,$nameTable2);
			$this->collection[$relationName] = new \Jmap\Model\Table($nameTable . '_' . $nameTable2, $objFields);
		}
	}

	public function getTables() {
		return $this->collection;
	}

	public function getTable($nameRelationTable) {
		if (!isset($this->collection[$nameRelationTable])) {
			return;
		}
		return $this->collection[$nameRelationTable];
	}

}