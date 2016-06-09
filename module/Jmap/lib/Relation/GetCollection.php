<?php
namespace Jmap\Relation;

class GetCollection implements RelationInterface {

	private $name;
	private $entity;
	private $columnA;
	private $columnB;
	private $column;

	/**
	 * en esta relacion se busca crear una function que retorne el valor de la tabla relacionada
	 * @param string $name           nombre de la relacion
	 * @param string $entity         ruta de la clase a ser instanciada '\Api\User\User'
	 * @param string $column         culumna de la clase entity que se desea retornar [nombre]
	 * @param string $columnRelation columna del obj buscar ['fk_id']
	 */
	public function __construct($name, $entity, $columnA, $columnB, $column) {

		$this->name    = $name;
		$this->entity  = $entity;
		$this->columnA = $columnA;
		$this->columnB = $columnB;
		$this->column  = $column;

	}

	/**
	 * retorna el resultado de llamr a la clase y hacer consultas a la base de datos,
	 * primero verifica si la columna a buscar es null, si es el caso retorna null, para no instanciar la clase entity
	 * verifica si la propiedad auxiliar relation[xxxxxxxx] es null, este caso significa que aun no se hace la consulta a la entidad
	 * por eso se debe instanciar un objeto entidad y optener el valor
	 * @param  StdObject $obj objeto creado en la entidad, esta instancia no se piede, se puede cambiar cualquier campo en este objeto y se actualizara en l aentidad
	 * @return cualquier valor que retorna la entidad, puede ser string o numero
	 */
	public function getFunction($obj) {

		if (is_null($obj->{'relation_' . $this->name})) {

			$objClass = new $this->entity();
			$datadb   = $objClass->table()->getRelationFilter(array($this->columnB => $obj->{'prv_' . $this->columnA}));

			$data = array();
			foreach ($datadb as $id_db => $row) {
				foreach ($row as $key => $value) {
					if (in_array($key, $this->column)) {
						//$data[$id_db][$this->name.'_'.$key] = $value;
						$data[$id_db][$key] = $value;
					}
				}
			}
			$obj->{'relation_' . $this->name} = $data;

		}

		return $obj->{'relation_' . $this->name};

	}

}