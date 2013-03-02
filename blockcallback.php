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
			!$this->installConfiguration() ||
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

		$this->uninstallConfiguration();
		$this->_uninstallModuleTab();

		return Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blockcallback');
	}

	protected function installConfiguration()
	{
		return Configuration::updateValue('CALLBACK_EMAIL', '') &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_0', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_1', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_2', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_3', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_4', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_5', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_DAY_6', 1) &&
			Configuration::updateValue('CALLBACK_DISPLAY_TIME_FROM', '') &&
			Configuration::updateValue('CALLBACK_DISPLAY_TIME_TO', '');
	}

	protected function uninstallConfiguration()
	{
		return Configuration::deleteByName('CALLBACK_EMAIL') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_0') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_1') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_2') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_3') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_4') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_5') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_DAY_6') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_TIME_FROM') &&
			Configuration::deleteByName('CALLBACK_DISPLAY_TIME_TO');
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
		if(method_exists('Tools', 'addCSS'))
		{
			Tools::addCSS($this->_path.'blockcallback.css', 'all');
		}
		else
		{
			return '<link href="'._MODULE_DIR_.$this->name.'/blockcallback.css" rel="stylesheet" type="text/css" media="all" />'."\n".
				'<style type="text/css">#blockcallback_block_left input.exclusive { display: inline-block; width: 120px; }</style>'."\n";
		}
	}

	public function hookLeftColumn($params)
	{
		if(!$this->isVisible())
			return;

		$this->_processInput();
		return $this->display(__FILE__, 'blockcallback.tpl');
	}

	public function hookRightColumn($params)
	{
		return $this->hookLeftColumn($params);
	}

	protected function isVisible()
	{
		$dayOfWeek = date('N') - 1;
		if(!Configuration::get('CALLBACK_DISPLAY_DAY_'.$dayOfWeek))
		{
			return false;
		}
		else
		{
			$from = Configuration::get('CALLBACK_DISPLAY_TIME_FROM');
			$to = Configuration::get('CALLBACK_DISPLAY_TIME_TO');
			if(isset($from, $to) && $from !== '' && $to !== '')
			{
				$h = intval(date('G'));
				if($h < $from || $h >= $to)
				{
					return false;
				}
			}
		}

		return true;
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
		$remoteAddr = method_exists('Tools', 'getRemoteAddr') ? Tools::getRemoteAddr() : $_SERVER['REMOTE_ADDR'];
		return Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'blockcallback` (`name`, `phone`, `created`, `ip`) VALUES (\''.pSQL($name).'\', \''.pSQL($phone).'\', NOW(), \''.pSQL($remoteAddr).'\')');
	}

	protected function _notify($name, $phone)
	{
		$email = Configuration::get('CALLBACK_EMAIL');
		if(empty($email))
		{
			return true;
		}

		$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		$iso = Language::getIsoById($id_lang);

		$templateVars = array(
			'{customer_name}' => $name,
			'{customer_phone}' => $phone,
		);

		if(file_exists(dirname(__FILE__).'/mails/'.$iso.'/callback.txt') &&
			file_exists(dirname(__FILE__).'/mails/'.$iso.'/callback.html'))
		{
			Mail::Send($id_lang, 'callback', $this->l('Call back request'), $templateVars, strval($email), NULL, strval(Configuration::get('PS_SHOP_EMAIL')), strval(Configuration::get('PS_SHOP_NAME')), NULL, NULL, dirname(__FILE__).'/mails/');
		}
	}

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

			$timeFrom = Tools::getValue('CALLBACK_DISPLAY_TIME_FROM', '');
			$timeTo = Tools::getValue('CALLBACK_DISPLAY_TIME_TO', '');
			if($timeFrom == '' || $timeTo == '')
			{
				$timeFrom = $timeTo = '';
			}
			else
			{
				if(intval($timeFrom) >= intval($timeTo))
				{
					$errors[] = $this->l('Display time From must be less then time To');
				}
			}

			if(empty($errors))
			{
				Configuration::updateValue('CALLBACK_EMAIL', $email);

				Configuration::updateValue('CALLBACK_DISPLAY_DAY_0', Tools::getValue('CALLBACK_DISPLAY_DAY_0', ''));
				Configuration::updateValue('CALLBACK_DISPLAY_DAY_1', Tools::getValue('CALLBACK_DISPLAY_DAY_1', ''));
				Configuration::updateValue('CALLBACK_DISPLAY_DAY_2', Tools::getValue('CALLBACK_DISPLAY_DAY_2', ''));
				Configuration::updateValue('CALLBACK_DISPLAY_DAY_3', Tools::getValue('CALLBACK_DISPLAY_DAY_3', ''));
				Configuration::updateValue('CALLBACK_DISPLAY_DAY_4', Tools::getValue('CALLBACK_DISPLAY_DAY_4', ''));
				Configuration::updateValue('CALLBACK_DISPLAY_DAY_5', Tools::getValue('CALLBACK_DISPLAY_DAY_5', ''));
				Configuration::updateValue('CALLBACK_DISPLAY_DAY_6', Tools::getValue('CALLBACK_DISPLAY_DAY_6', ''));

				Configuration::updateValue('CALLBACK_DISPLAY_TIME_FROM', $timeFrom);
				Configuration::updateValue('CALLBACK_DISPLAY_TIME_TO', $timeTo);
			}

			if(!empty($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}

		$smarty->assign(array(
			'CALLBACK_EMAIL' => Configuration::get('CALLBACK_EMAIL'),
			'CALLBACK_DISPLAY_DAY_0' => Configuration::get('CALLBACK_DISPLAY_DAY_0'),
			'CALLBACK_DISPLAY_DAY_1' => Configuration::get('CALLBACK_DISPLAY_DAY_1'),
			'CALLBACK_DISPLAY_DAY_2' => Configuration::get('CALLBACK_DISPLAY_DAY_2'),
			'CALLBACK_DISPLAY_DAY_3' => Configuration::get('CALLBACK_DISPLAY_DAY_3'),
			'CALLBACK_DISPLAY_DAY_4' => Configuration::get('CALLBACK_DISPLAY_DAY_4'),
			'CALLBACK_DISPLAY_DAY_5' => Configuration::get('CALLBACK_DISPLAY_DAY_5'),
			'CALLBACK_DISPLAY_DAY_6' => Configuration::get('CALLBACK_DISPLAY_DAY_6'),
			'CALLBACK_DISPLAY_TIME_FROM' => Configuration::get('CALLBACK_DISPLAY_TIME_FROM'),
			'CALLBACK_DISPLAY_TIME_TO' => Configuration::get('CALLBACK_DISPLAY_TIME_TO'),
		));

		$output .= $this->display(__FILE__, 'settings.tpl');

		return $output;
	}
}
