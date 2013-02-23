<?php

if (!defined('_PS_VERSION_'))
	exit;

class BlockCallback extends Module
{
	public function __construct()
	{
		$this->name = 'blockcallback';
		$this->tab = 'front_office_features';
		$this->version = 0.1;
		$this->author = 'aggrrrh';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Call back');
		$this->description = $this->l('Call back module description.');
	}

	public function install()
	{
		if(!parent::install() ||
			!$this->registerHook('leftColumn') ||
			!$this->registerHook('header') ||
			!Configuration::updateValue('CALLBACK_EMAIL', '') ||
			!$this->_installModuleTab())
		{
			return false;
		}

		return Db::getInstance()->Execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockcallback` (
				`id_blockcallback` INT NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`phone` VARCHAR(255) NOT NULL,
				`active` TINYINT(1) NOT NULL DEFAULT \'0\',
				`created` DATETIME NULL,
				`color` VARCHAR(7) DEFAULT \'#FEEFB3\',
				`ip` VARCHAR(15) NOT NULL,
				PRIMARY KEY(`id_blockcallback`)
			) ENGINE='._MYSQL_ENGINE_.' default CHARSET=utf8');
	}

	public function uninstall()
	{
		if(!parent::uninstall())
			return false;

		$this->_uninstallModuleTab();

		return Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blockcallback');
	}

	protected function _installModuleTab()
	{
		$tab = new Tab();
		$tab->class_name = 'AdminCallback';
		$tab->id_parent = (int)Tab::getIdFromClassName('AdminCustomers');
		$tab->module = 'blockcallback';

		foreach(Language::getLanguages(false) as $lang)
			$tab->name[(int)$lang['id_lang']] = 'Call Back';

		if(!$tab->save())
		{
			return false;
		}

		@copy(dirname(__FILE__).'/logo.gif', _PS_IMG_DIR_.'t/AdminCallback.gif');

		return true;
	}

	protected function _uninstallModuleTab()
	{
		if($id_tab = Tab::getIdFromClassName('AdminCallback'))
		{
			$tab = new Tab((int)$id_tab);
			$tab->delete();

			@unlink(_PS_IMG_DIR_.'t/AdminCallback.gif');
		}
	}

	function hookHeader($params)
	{
		Tools::addCSS($this->_path.'blockcallback.css', 'all');
	}

	public function hookLeftColumn($params)
	{
		$this->_processInput();
		return $this->display(__FILE__, 'blockcallback.tpl');
	}

	public function hookRightColumn($params)
	{
		return $this->hookLeftColumn($params);
	}

	protected function _processInput()
	{
		global $smarty;

		if(Tools::isSubmit('submitBlockCallback'))
		{
			$error = false;
			$msg = '';

			if(!$this->_validateName())
			{
				$error = true;
				$msg = $this->l('Enter your name');
			}
			else if(!$this->_validatePhone())
			{
				$error = true;
				$msg = $this->l('Enter valid phone number');
			}
			else
			{
				if($this->_save($_POST['BlockCallbackName'], $_POST['BlockCallbackPhone']))
				{
//					$this->_notify($_POST['BlockCallbackName'], $_POST['BlockCallbackPhone']);
					$msg = $this->l('We will call you soon!');
				}
				else
				{
					$error = true;
					$msg = $this->l('Internal error');
				}
			}

			$smarty->assign(array(
				'blockcallback_error' => $error,
				'blockcallback_msg' => $msg,
			));
		}
	}

	protected function _validateName()
	{
		return !empty($_POST['BlockCallbackName']);
	}

	protected function _validatePhone()
	{
		return !empty($_POST['BlockCallbackPhone']) && preg_match('/^[-+()0-9 ]{3,}$/', $_POST['BlockCallbackPhone']);
	}

	protected function _save($name, $phone)
	{
		return Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'blockcallback` (`name`, `phone`, `created`, `ip`) VALUES (\''.pSQL($name).'\', \''.pSQL($phone).'\', NOW(), \''.pSQL(Tools::getRemoteAddr()).'\')');
	}
/*
	protected function _notify($name, $phone)
	{
		$email = Configuration::get('CALLBACK_EMAIL');
		if(empty($email))
		{
			return true;
		}

		$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		$iso = Language::getIsoById($id_lang);

		$templateVars = array();

		if (file_exists(dirname(__FILE__).'/mails/'.$iso.'/callback.txt') &&
			file_exists(dirname(__FILE__).'/mails/'.$iso.'/callback.html'))
		{
			Mail::Send($id_lang, 'callback', Mail::l('Call back request', $id_lang), $templateVars, strval($email), NULL, strval(Configuration::get('PS_SHOP_EMAIL')), strval(Configuration::get('PS_SHOP_NAME')), NULL, NULL, dirname(__FILE__).'/mails/');
		}
	}
*/
	public function getContent()
	{
		global $smarty;

		$output = '<h2>'.$this->displayName.'</h2>';

		if(Tools::isSubmit('btnSubmitBlockCallback'))
		{
			$errors = array();
			$email = Tools::getValue('CALLBACK_EMAIL');

			if(!empty($email) && !Validate::isEmail($email))
			{
				$errors[] = $this->l('Invalid email address');
			}
			else
			{
				Configuration::updateValue('CALLBACK_EMAIL', $email);
			}

			if(!empty($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}

		$smarty->assign(array(
			'CALLBACK_EMAIL' => Configuration::get('CALLBACK_EMAIL'),
		));

		$output .= $this->display(__FILE__, 'settings.tpl');

		return $output;
	}
}
