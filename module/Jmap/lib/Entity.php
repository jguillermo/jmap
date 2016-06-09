<?php
namespace Jmap;

class Entity {

	private $fields;

	private $table;

	public function __construct(Model\Field $fields) {

		$this->fields = $fields;
	}

	public function setTable(Model\Table $table) {
		$this->table = $table;
	}

	/**
	 * genera la clase dinamica, conlos atributos generados en getPropertys()
	 * luego se crean las funciones de relacion, usando funciones anonimas y creando un solo objeto a ser reutilizable en todas las llamdas
	 * $obj no se pierde en memoria, se sigue usando aun cuando ingresan a las funciones anonimas
	 * @return [type] [description]
	 */
	public function get() {

		$obj = new Util\StdObject($this->getPropertys(), $this->getPropertyRelation(), $this->fields);

		//var_dump($obj);

		// foreach ($this->fields['relation']['getInfo'] as $name_relation => $attr_relation) {
		// 		//'type' =>'getInfo','name'=>'identityType','entity'=>'Api\User\IdentityType','column'=>'name'
		// 		$objRelation = $this->getRelation('getInfo',$name_relation,$attr_relation);
		// 		//$propertyMethod[$v['relation']['name']] = $objRelation->getFunction();
		// 		$obj->{$name_relation} = function() use ($objRelation,$obj) {
		// 			//var_dump($objRelation);
		// 			//return 'hola desde la funcion';//
		// 			//var_dump($obj);
		// 			//var_dump($obj->id);
		// 			//var_dump($obj->{'relation_'.$v['relation']['name']});
		// 			return $objRelation->getFunction($obj);
		// 		};
		// }

		//foreach ($this->fields['relation'] as $type_relation => $list_relation) {
		//	foreach ($list_relation as $name_relation => $attr_relation) {
		//		//'type' =>'getInfo','name'=>'identityType','entity'=>'Api\User\IdentityType','column'=>'name'
		//		$objRelation = $this->getRelation($type_relation,$name_relation,$attr_relation);
		//		//$propertyMethod[$v['relation']['name']] = $objRelation->getFunction();
		//		$obj->{$name_relation} = function() use ($objRelation,$obj) {
		//			//var_dump($objRelation);
		//			//return 'hola desde la funcion';//
		//			//var_dump($obj);
		//			//var_dump($obj->id);
		//			//var_dump($obj->{'relation_'.$v['relation']['name']});
		//			return $objRelation->getFunction($obj);
		//		};
		//	}
		//
		//}

		foreach ($this->fields->get('relation') as $type_relation => $list_relation) {
			foreach ($list_relation as $name_relation => $attr_relation) {
				$objRelation           = $this->getRelation($type_relation, $name_relation, $attr_relation);
				$obj->{$name_relation} = function () use ($objRelation, $obj) {
					return $objRelation->getFunction($obj);
				};
			}
		}

		return $obj;
	}

	/**
	 * genera un OBJ de tipo relation dependiendo al tipo de repacion que se declaro en el fields
	 * @param  string $columnName nombre de la columna del field
	 * @param  string $columnName nombre de la columna del field
	 * @param  srray $attr        lista de atributos de fields
	 * @return relation           objeto creado de la interface Relation
	 */
	private function getRelation($type_relation, $name_relation, $attr) {

		switch ($type_relation) {
		case 'getInfo':
			$relation = new \Jmap\Relation\GetInfo($name_relation, $attr['entity'], $attr['columnB'], $attr['column_relationA']);
			break;
		case 'getCollection':
			$relation = new \Jmap\Relation\GetCollection($name_relation, $attr['entity'], $attr['columnA'], $attr['columnB'], $attr['column']);
			break;
		case 'getMultiple':
			$relation = new \Jmap\Relation\GetMultiple($name_relation, $attr['entity'], $attr['columnA'], $attr['columnB'], $attr['column'], $this->table);
			break;
		default:
			throw new \Exception("La ralacion entre tablas {$type_relation} no esta definida ");
			break;
		}
		return $relation;
	}

	/**
	 * separa los atributos table y relation de los fields, para poder generar la clase dinamica de la entidad
	 * en el caso de la tabla, al tener valores iniciales, se inicia con dicho valor, caso contrario es NULL ;
	 * tipo private,
	 * @return array retorna array('table')
	 */
	private function getPropertys() {

		$propertyMethod = array();
		$table          = $this->fields->get('table');
		foreach ($table['colums'] as $k => $v) {

			$propertyMethod[$k] = isset($v['value']) ? $v['value'] : null;

		}
		return $propertyMethod;
	}

	/**
	 * separa los atributos table y relation de los fields, para poder generar la clase dinamica de la entidad
	 * en el caso de relation, se crea una nueva propiedad llamada relation_[nombre_de_la_relacion] y se inicia en null
	 * @return array retorna array('table','relation')
	 */
	private function getPropertyRelation() {

		$propertyMethod = array();
		foreach ($this->fields->get('relation') as $type_relation => $list_relation) {

			foreach ($list_relation as $name_relation => $attr_relation) {
				$propertyMethod['relation_' . $name_relation] = null;
			}

		}
		return $propertyMethod;
	}
}