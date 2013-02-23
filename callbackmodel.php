<?php

class CallbackModel extends ObjectModel
{
	protected $table = 'blockcallback';
	protected $identifier = 'id_blockcallback';

	public $active = false;

	public function getFields()
	{
		$fields = parent::getFields();
		$fields['active'] = intval($this->active);
		$fields['color'] = $this->active ? '#DFF2BF' : '#FEEFB3';

		return $fields;
	}
}
