<?php

require_once(dirname(__FILE__).'/CallbackModel.php');

class AdminCallback extends AdminTab
{
	public $table = 'blockcallback';
	public $className = 'CallbackModel';

	public $delete = true;
	public $deleted = false;

	public $colorOnBackground = true;

	public function __construct()
	{
		parent::__construct();

		$this->fieldsDisplay = array(
			'id_blockcallback' => array('title' => $this->l('#'), 'align' => 'center', 'width' => 25),
			'name' => array('title' => $this->l('Customer name'), 'width' => 300),
			'phone' => array('title' => $this->l('Customer phone number'), 'width' => 300),
			'active' => array('title' => $this->l('Processed'), 'type' => 'bool', 'active' => 'status'),
			'created' => array('title' => $this->l('Date'), 'type' => 'datetime', 'width' => 120),
			'ip' => array('title' => $this->l('IP'), 'type' => 'text'),
		);
	}
}
