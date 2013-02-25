<?php

require_once(dirname(__FILE__).'/callbackmodel.php');

class AdminCallback extends AdminTab
{
	public $table = 'blockcallback';
	public $className = 'CallbackModel';

	public $delete = true;
	public $deleted = false;

	public $noLink = true;
	public $colorOnBackground = true;

	public function __construct()
	{
		parent::__construct();

		$this->fieldsDisplay = array(
			'id_blockcallback' => array('title' => $this->l('#'), 'align' => 'center', 'width' => 25),
			'name' => array('title' => $this->l('Customer name')),
			'phone' => array('title' => $this->l('Customer phone number')),
			'active' => array('title' => $this->l('Processed'), 'type' => 'bool', 'active' => 'status'),
			'created' => array('title' => $this->l('Date'), 'type' => 'datetime',),
			'ip' => array('title' => $this->l('IP'), 'type' => 'text'),
		);
	}

	public function displayListHeader($token = NULL)
	{
		echo '<style type="text/css">form.form>table, form.form table.table { width: 100%; }</style>', "\n";
		return parent::displayListHeader($token);
	}
}
