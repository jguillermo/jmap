<?php
namespace Jmap\Relation;

class GetInfo implements RelationInterface {

	private $name;
	private $entity;
	private $column;
	private $columnRelation;

	/**
	 * en esta relacion se busca crear una function que retorne el valor de la tabla relacionada
	 * @param string $name           nombre de la relacion
	 * @param string $entity         ruta de la clase a ser instanciada '\Api\User\User'
	 * @param string $column         culumna de la clase entity que se desea retornar [nombre]
	 * @param string $columnRelation columna del obj buscar ['fk_id']
	 */
	public function __construct($name, $entity, $column, $columnRelation) {

		$this->name           = $name;
		$this->entity         = $entity;
		$this->column         = $column;
		$this->columnRelation = $columnRelation;

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

		//var_dump($obj->id);
		//var_dump($obj);
		//var_dump($obj->{$this->columnRelation});

		//$obj->{$this->columnRelation}
		//var_dump($obj->{$this->columnRelation});
		//var_dump('----------------------------');

		// en el caso que se va a buscar un NULL, ya no es necesario crear una entidad,
		// solo retorna un valor null.
		if (is_null($obj->{'prv_' . $this->columnRelation})) {
			return;
		}

		if (is_null($obj->{'relation_' . $this->name})) {

			$objClass = new $this->entity();
			//var_dump('se esta llamando a la entidad');
			$objClass->loadById($obj->{'prv_' . $this->columnRelation});

			$valores_revueltos = '';

			foreach ($this->column as $column) {
				$valores_revueltos .= $objClass->entity()->{'prv_' . $column};
			}
			//var_dump($objClass);
			$obj->{'relation_' . $this->name} = trim($valores_revueltos);

		}

		return $obj->{'relation_' . $this->name};

	}

}