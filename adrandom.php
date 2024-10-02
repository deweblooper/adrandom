<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class AdRandom extends Module
{
	
	public function __construct()
	{
		$this->name = 'adrandom';
		$this->tab = 'front_office_features';
		$this->version = '0.0.1';
		$this->author = 'waterwhite';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		
		$this->bootstrap = true;
		parent::__construct();
		
		$this->displayName = $this->l('Ad Banners');
		$this->description = $this->l('Add random ad banners to selected page anywhere to eshop.');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
		
//		if (!Configuration::get('ADRANDOM'))
//			$this->warning = $this->l('No name provided');
	}
	
	
	public function install()
	{
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);
		/*
		if (!parent::install() ||
			!$this->registerHook('header') ||
			!$this->registerHook('displayCategoryTop') ||
			!Configuration::updateValue('ADRANDOM', '1')
			)
			return false;
			
		return true;
		*/
		
		return parent::install()
		&&    $this->registerHook('header')
//	&&    $this->registerHook('top')
		&&    $this->registerHook('displayTopColumn')
//	&&    $this->registerHook('home')
//	&&    $this->registerHook('leftColumn')
//	&&    $this->registerHook('rightColumn')
//	&&    $this->registerHook('displayCategoryTop')
// 	&&    Configuration::updateValue('ADRANDOM', '1')
		;
	}
	
	
	public function uninstall()
	{
		if (!parent::uninstall() ||
			!Configuration::deleteByName('ADRANDOM')
			)
			return false;
			
		return true;
	}
	
	
	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS($this->_path.'css/adrandom.css', 'all');
	}
	
	
	public function hookTop($params)
	{
		return $this->hookDisplayLeftColumn($params);
	}
	
	
	public function hookDisplayTopColumn($params)
	{
		return $this->hookDisplayLeftColumn($params);
	}
	
	
	public function hookDisplayHome($params)
	{
		return $this->hookDisplayLeftColumn($params);
	}


	public function hookDisplayRightColumn($params)
	{
		return $this->hookDisplayLeftColumn($params);
	}
	
	
	public function hookDisplayLeftColumn($params)
	{
		
//		$adr_img = 'banner01.png';
//		$adr_link = 'http://lieky24.sk/1971-ibalgin-400-mg-48-tbl-8594739217669.html';
		
//		$banner1 = 'banner01.png';
//		$banner2 = 'banner02.png';
		$banners = array(
				array('banner_doprava.jpg', '#'),
				array('banner_ibalgin.png', './1971-ibalgin-400-mg-48-tbl-8594739217669.html'),
				array('banner_nutrilon.png', './search?controller=search&orderby=price&orderway=asc&search_query=Nutrilon+Pronutra+800g'),
		);
		
		shuffle($banners);
		$adr_img = $banners[0][0];
		$adr_link = $banners[0][1];

		// hard assign for home page
		if ($this->context->controller->php_self == 'index') {
			$adr_img = 'banner_doprava.jpg';
			$adr_link = '#';
		}
		
		
		$this->context->smarty->assign(
			array(
				'adr_img' => $adr_img,
				'adr_link' => $adr_link
				)
			);
		return $this->display(__FILE__, 'adrandom_banner.tpl');
	}
	
}