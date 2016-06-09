<?php
namespace Jmap\Relation;

interface RelationInterface {

	/**
	 * retorna el resultado de llamr a la clase y hacer consultas a la base de datos,
	 * @param  StdObject $obj objeto creado en la entidad, esta instancia no se piede, se puede cambiar cualquier campo en este objeto y se actualizara en l aentidad
	 */
	public function getFunction($obj);

}