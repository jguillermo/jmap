<?php

namespace Jmap\Model;

use Zend\Db\Metadata\Metadata;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Ddl\Column;
use Zend\Db\Sql\Ddl\Constraint;
use Zend\Db\Sql\Sql;

class MetadataDdl {

	public function createTable(\Jmap\Model\Table $table, $showSql = false) {

		$keys      = $table->getKeys();
		$colums    = $table->getColums();
		$nameTable = $table->getNameTable();

		$tableDdl = new Ddl\CreateTable($nameTable);

		if ($showSql) {
			var_dump($colums, $keys, $nameTable);
		}

		//$table->addColumn(new Column\Integer('id'));
		foreach ($table->getColums() as $name => $attr) {
			$attrExtend = $this->attrExtend($attr);
			//var_dump($attrExtend);
			switch ($attr['type']) {
			case 'integer':

				$column = new Column\Integer($name);

				$column->setOptions(array(
					'length'   => $attrExtend['length'],
					'unsigned' => $attrExtend['unsigned'],
				));

				// el auto incrementable solo se puede añadir a primary key
				if (isset($keys['pk'][$name])) {
					$column->setOption('autoincrement', $attrExtend['autoincrement']);
				}

				break;
			case 'varchar':
				$column = new Column\Varchar($name, $attrExtend['length']);
				break;
			case 'datetime':
				$column = new Column\Datetime($name);
				break;
			case 'date':
				$column = new Column\Date($name);
				break;
			case 'time':
				$column = new Column\Time($name);
				break;
			default:

				break;
			}

			$column->setNullable($attrExtend['isNullable']);
			$column->setDefault($attrExtend['default']);

			$tableDdl->addColumn($column);
		}

		if (count($keys['pk']) > 0) {
			$pks = array();
			foreach ($keys['pk'] as $name => $value) {
				$pks[] = $name;
			}
			$tableDdl->addConstraint(new Constraint\PrimaryKey($pks, 'pk_' . date('YmdHis') . rand()));
		} else {
			throw new \Exception('al menos define un Primary Key');
		}

		if (count($keys['fk']) > 0) {
			foreach ($keys['fk'] as $name => $attr) {
				$namefk = 'fk_' . date('YmdHis') . rand();
				$tableDdl->addConstraint(new Constraint\ForeignKey(
					$namefk, $name, $attr['table'], $attr['column']
				));
			}
		}

		//$table->addConstraint(
		//    new Constraint\UniqueKey(['name', 'foo'], 'my_unique_key')
		//);

		$this->executingDdl($tableDdl, $showSql);

		$this->createTableManyToMany($table);

	}

	private function createTableManyToMany(\Jmap\Model\Table $table) {

		//if (!isset($relations['getMultiple']) || count($relations['getMultiple']) == 0) {
		//	return;
		//}

		$objCollectionTablesMultiple = new \Jmap\Util\RelationMultipleTable($table);

		foreach ($objCollectionTablesMultiple->getTables() as $tableRelation) {
			$this->createTable($tableRelation);
		}

	}

	private function dropTableManyToMany(\Jmap\Model\Table $table) {

		//if (!isset($relations['getMultiple']) || count($relations['getMultiple']) == 0) {
		//	return;
		//}

		$objCollectionTablesMultiple = new \Jmap\Util\RelationMultipleTable($table);

		foreach ($objCollectionTablesMultiple->getTables() as $tableRelation) {

			$nameTableDrop = $tableRelation->getNameTable();

			if ($this->isTable($nameTableDrop)) {
				// ya exite se tiene  que eliminar
				$drop = new Ddl\DropTable($nameTableDrop);
				$this->executingDdl($drop);
			}
		}

		return true;
	}

	private function attrExtend($attr) {

		//   $fieldDefaults = array(
		//   	'default'       => null,
		//   	'length'        => null,
		//   	'isNullable'       => false,
		//   	'unsigned'      => false,
		//   	'autoincrement' => false
		//   );
		//   'decimal' => [
		//           'length' => [10, 2]
		//   ],
		//
		$defaults = array(
			'varchar'  => array(
				'length'     => 255,
				'default'    => null,
				'isNullable' => true,
			),
			'integer'  => array(
				'length'        => 10,
				'unsigned'      => true,
				'default'       => null,
				'isNullable'    => true,
				'autoincrement' => false,
			),
			'datetime' => array(
				'default'    => null,
				'isNullable' => true,
			),
			'date'     => array(
				'default'    => null,
				'isNullable' => true,
			),
			'time'     => array(
				'default'    => null,
				'isNullable' => true,
			),
		);

		if (!isset($defaults[$attr['type']])) {
			throw new \Exception('no estan definidos las propiedades para : ' . $attr['type']);
		}

		// solo se remplazan los atributos que estan definidos en $defaults
		foreach ($defaults[$attr['type']] as $name => $value) {
			if (isset($attr[$name])) {
				$defaults[$attr['type']][$name] = $attr[$name];
			}
		}

		return $defaults[$attr['type']];

	}

	public function dropTableIfExists(\Jmap\Model\Table $table) {

		$nameTableDrop = $table->getNameTable();

		$this->dropTableManyToMany($table);

		if ($this->isTable($nameTableDrop)) {
			// ya exite se tiene  que eliminar
			$drop = new Ddl\DropTable($nameTableDrop);
			$this->executingDdl($drop);
		}
		return true;
	}

	public function isTable($nameTable) {

		$metadata   = new Metadata(Adapter::getAdapter());
		$tableNames = $metadata->getTableNames();

		$isTable = false;

		//var_dump($tableNames);
		foreach ($tableNames as $table) {
			if ($table == $nameTable) {
				$isTable = true;
			}
		}
		return $isTable;
	}

	private function executingDdl($ddl, $showSql = false) {

		$adapter = Adapter::getAdapter();

		$sql = new Sql($adapter);

		if ($showSql) {
			var_dump($sql->getSqlStringForSqlObject($ddl));
		}

		$adapter->query(
			$sql->getSqlStringForSqlObject($ddl),
			$adapter::QUERY_MODE_EXECUTE
		);
	}

	public function getTableColums($tableName) {
		$metadata = new Metadata(Adapter::getAdapter());

		if (!$this->isTable($tableName)) {
			return false;
		}

		$table_info = $metadata->getTable($tableName);

		$data = array();
		foreach ($table_info->getColumns() as $column) {

			$type = strtolower($column->getDataType());
			if (strpos($type, 'varchar') !== false) {
				$type = 'varchar';
			}
			if (strpos($type, 'int') !== false) {
				$type = 'integer';
			}
			$data[$column->getName()] = array(
				'type'       => $type,
				'default'    => $column->getColumnDefault(),
				'isNullable' => $column->getIsNullable(),
				'unsigned'   => $column->getNumericUnsigned(),
				'length_max' => $column->getCharacterMaximumLength(),
			);
		}
		return $data;
	}

	public function getTableConstraints($tableName) {
		$metadata = new Metadata(Adapter::getAdapter());

		if (!$this->isTable($tableName)) {
			return false;
		}

		$data = array();
		foreach ($metadata->getConstraints($tableName) as $constraint) {

			if (!$constraint->hasColumns()) {
				continue;
			}

			foreach ($constraint->getColumns() as $column) {
				$data[$constraint->getType()][] = $column;
			}
		}
		return $data;
	}

}
