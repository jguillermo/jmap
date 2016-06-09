<?php

namespace Admin\Controller;

class IdentityTypeController extends EntityController {

	public function __construct() {
		parent::__construct('\Api\User\IdentityType');
	}

}