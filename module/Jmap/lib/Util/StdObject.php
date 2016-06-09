<?php

namespace Jmap\Util;

class stdObject {

	/**
	 * genera una clase dinamica a ser usada en la entidades
	 * @param array $arguments [description]
	 */

	/**
	 * gesdf
	 * @param array $arguments         los campos que son de la tabla se debe crar el get y set a estas variables
	 * @param array $argumentRelations los campos de la relacion, solo con fines de guaradr en memoria cache los datos
	 */
	public function __construct(array $arguments = array(), array $argumentRelations = array(), \Jmap\Model\Field $field) {

		$objFilter = new \Jmap\Model\Filter($field);
		$filter    = $objFilter->get();

		$default = $field->get('default');

		//var_dump($default);exit();

		$obj = $this;
		foreach ($arguments as $property => $argument) {


			// se crean los valores "privados" de la entidad
			$this->{'prv_' . $property} = $argument;

			//$obj->{$name_relation}

			// se crea la funcion get en la entidad
			$this->{'get' . ucfirst($property)} = function () use ($obj, $property,$default) {

				// si tiene valores por defecto y es null, se debe llenar los datos del default filtrado
				if(is_null($obj->{'prv_' . $property}) && isset($default[$property]) ) {
					
					$obj->{'set'.ucfirst($property)}($default[$property]);
				}

				return $obj->{'prv_' . $property};
			};

			// se crea la funcion set de la entidad, filtrando los datos pasados.
			$this->{'set' . ucfirst($property)} = function ($value) use ($obj, $property, $filter) {
				if (isset($filter[$property])) {
					$value = $filter[$property]->filter($value);
				}
				$obj->{'prv_' . $property} = $value;
			};

		}

		foreach ($argumentRelations as $property => $argument) {
			$this->{$property} = $argument;
		}

	}

	public function __call($method, $arguments) {
		if (isset($this->{$method}) && is_callable($this->{$method})) {
			return call_user_func_array($this->{$method}, $arguments);
		} else {
			throw new \Exception("Fatal error: Call to undefined method stdObject::{$method}()");
		}
	}
}
//$this->{$property} = $argument;
//if ($argument instanceOf Closure) { cuando se trata de una funcion anonima
//
//} else {
//    $this->{$property} = $argument;
//}
/*
 * modo de uso

$person = new stdObject(array(
"name" => "nick",
"age" => 23,
"friends" => array("frank", "sally", "aaron"),
"sayHi" => function() {
return "Hello there";
}
));

$person->sayHi2 = function() {
return "Hello there 2";
};

$person->test = function() {
return "test";
};

var_dump($person->name, $person->test(), $person->sayHi2());

 */