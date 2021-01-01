<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Ajax Checks Extension
 * @copyright	(c) 2018-2021 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\ajaxchecks\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\auth\auth;
use phpbb\language\language;
use phpbb\extension\manager;
use phpbb\path_helper;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/* @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string ext path */
	protected $ext_path;

	/** @var string ext path web */
	protected $ext_path_web;

	/**
	 * Listener constructor
	 */
	public function __construct(config $config, helper $helper, template $template, auth $auth, language $language, manager $ext_manager, path_helper $path_helper)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->auth = $auth;
		$this->language = $language;
		$this->ext_manager = $ext_manager;
		$this->path_helper = $path_helper;
		$this->ext_path = $this->ext_manager->get_extension_path('sylver35/ajaxchecks', true);
		$this->ext_path_web = $this->path_helper->update_web_root_path($this->ext_path);
	}

	/**
	 * Function that returns the subscribed events
	 *
	 * @return array Array with the subscribed events
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.ucp_register_data_before'		=> 'ajax_register_data',
			'core.ucp_profile_reg_details_data'	=> 'ajax_profile_data',
		];
	}

	/**
	 * Function to assign all needed data to the registration form
	 */
	public function ajax_register_data()
	{
		// Load language data
		$this->language->add_lang('ajaxchecks', 'sylver35/ajaxchecks');
		$this->template->assign_vars([
			'S_IN_AJAX_CHECKS'			=> true,
			'S_IN_AJAX_CHECKS_REGISTER'	=> true,
			'S_IN_AJAX_CHECKS_DETAILS'	=> false,
			'S_CHANGE_EMAIL_ON'			=> true,
			'S_CHANGE_PASSWORD_ON'		=> false,
			'AJAX_CHECKS_FILE'			=> $this->helper->route('sylver35_ajaxchecks_controller'),
			'AJAX_CHECKS_PATH'			=> $this->ext_path_web . 'images/',
			'L_AJAX_CHECK_FROM'			=> $this->language->lang('AJAX_CHECK_FROM', $this->get_version()),
		]);
	}

	/**
	 * Function to assign all needed data to the profile form
	 */
	public function ajax_profile_data()
	{
		// Load language data
		$this->language->add_lang('ajaxchecks', 'sylver35/ajaxchecks');
		$this->template->assign_vars([
			'S_IN_AJAX_CHECKS'			=> true,
			'S_IN_AJAX_CHECKS_REGISTER'	=> false,
			'S_IN_AJAX_CHECKS_DETAILS'	=> true,
			'S_CHANGE_EMAIL_ON'			=> ($this->auth->acl_get('u_chgemail')) ? true : false,
			'S_CHANGE_PASSWORD_ON'		=> ($this->auth->acl_get('u_chgpasswd')) ? true : false,
			'AJAX_CHECKS_FILE'			=> $this->helper->route('sylver35_ajaxchecks_controller'),
			'AJAX_CHECKS_PATH'			=> $this->ext_path_web . 'images/',
			'L_AJAX_CHECK_FROM'			=> $this->language->lang('AJAX_CHECK_FROM', $this->get_version()),
		]);
	}

	/**
	 * Function to get the version of extension
	 */
	private function get_version()
	{
		$md_manager = $this->ext_manager->create_extension_metadata_manager('sylver35/ajaxchecks');
		$meta = $md_manager->get_metadata();

		return $meta['version'];
	}
}
