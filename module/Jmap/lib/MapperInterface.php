<?php
namespace Jmap;

interface MapperInterface
{
    
 	//private $entity;
	//private $table;
	//protected $nTable;
	//private $form;
	//protected $msg;
	//public function __construct($nTable, $id = null);

	//public function table();

	//protected function form($elements = array());

	public function entity();

	public function setData($data = array());

	public function getData($elements = array());

	public function isValid($elements = array());

	public function getMessages();

	public function save();

	public function getForm($elements = array());

	public function loadById($id);
}
