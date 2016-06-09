<?php

namespace Wread\Api;

class ProcessEntity {

	private $entity;

	public function __construct($entity) {

		$this->entity = $entity;

	}

	public function getContGroup($url) {

		return $this->getEntity()->getGuidGroup($url);

	}

	public function getTableGuid($guid) {
        return $this->getEntity()->getTableGuid($guid);
	}

	private function getEntity() {
		switch ($this->entity) {
		case 'msi':
			$ent = new Entity\Msi();
			break;

		default:

			break;
		}
		return $ent;
	}

}