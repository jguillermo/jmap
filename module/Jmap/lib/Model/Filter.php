<?php

namespace Jmap\Model;

class Filter {

	private $filter;
	private $fields_array;

	public function __construct(Field $fields) {

		$dataProcesada      = $fields->get();
		$this->fields_array = $dataProcesada['filter'];

	}

	/**
	 * genral el array de filtro de cada entidad
	 * @return array de filtros
	 */
	public function get() {
		$filter = array();
		foreach ($this->fields_array as $columnName => $value) {
			if (isset($value['filters']) && is_array($value['filters'])) {
				$filter[$columnName] = new \Zend\Filter\FilterChain();
				foreach ($value['filters'] as $filterName) {
					if (strpos($filterName['name'], '\\') === false) {
						$filter[$columnName]->attachByName($filterName['name']);
					} else {
						$filter[$columnName]->attach(new $filterName['name']());
					}
				}
			}
		}
		return $filter;
	}

	public function collection($data) {

		foreach ($this->get() as $columnName => $filter) {
			foreach ($data as $id_row => $row) {
				if (isset($row[$columnName])) {
					$data[$id_row][$columnName] = $filter->filter($row[$columnName]);
				}
			}
		}

		return $data;
	}

}
