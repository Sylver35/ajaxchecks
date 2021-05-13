<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Ajax Checks Extension
 * @copyright	(c) 2018-2021 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\ajaxchecks\controller;

use sylver35\ajaxchecks\core\ajaxchecks;
use phpbb\request\request;
use phpbb\language\language;

class controller
{
	/** @var \sylver35\ajaxchecks\core\ajaxchecks */
	protected $ajaxchecks;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Controller constructor
	 */
	public function __construct(ajaxchecks $ajaxchecks, request $request, language $language, $root_path, $php_ext)
	{
		$this->ajaxchecks = $ajaxchecks;
		$this->request = $request;
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * data checks according to configuration
	 *
	 * @return void
	 * @access public
	 */
	public function ajax()
	{
		$mode = (string) $this->request->variable('mode', '');
		$email = (string) $this->request->variable('email', '', true);
		$username = (string) $this->request->variable('username', '', true);
		$password1 = (string) $this->request->variable('password1', '', true);
		$password2 = (string) $this->request->variable('password2', '', true);

		// Load needed language data
		$this->language->add_lang('ajaxchecks', 'sylver35/ajaxchecks');
		$this->language->add_lang('ucp');

		switch ($mode)
		{
			case 'usernamecheck':
			case 'usernamecur':
				$this->ajaxchecks->verify_username_length($mode, $username);
			break;

			case 'checkemail':
				$this->ajaxchecks->validation_email($mode, $email);
			break;

			case 'passwordcheck':
				if ($this->ajaxchecks->verify_password($mode, $password1, $password2))
				{
					break;
				}
				$this->ajaxchecks->validation_password($mode, $password1, $password2);
			break;

			case 'passwordcur':
				if ($this->ajaxchecks->verify_password($mode, $password1))
				{
					break;
				}
				if ($this->ajaxchecks->validation_password($mode, $password1))
				{
					break;
				}
				$this->ajaxchecks->check_password($mode, $password1);
			break;

			case 'oldpassword':
				if ($this->ajaxchecks->verify_password($mode, $password1, $password2))
				{
					break;
				}
				$this->ajaxchecks->check_password($mode, $password1);
			break;

			case 'strength';
				if ($this->ajaxchecks->verify_password($mode, $password1))
				{
					break;
				}
				$this->ajaxchecks->validation_password($mode, $password1, '', true);
			break;
		}
		
		switch ($mode)
		{
			case 'usernamecheck':
			case 'usernamecur':
				$this->ajaxchecks->verify_username_length($mode, (string) $this->request->variable('username', '', true));
			break;

			case 'checkemail':
				$this->ajaxchecks->validation_email($mode, (string) $this->request->variable('email', '', true));
			break;

			case 'passwordcheck':
			case 'passwordcur':
			case 'oldpassword':
			case 'strength';
				$password1 = (string) $this->request->variable('password1', '', true);
				$password2 = (string) $this->request->variable('password2', '', true);

				if ($this->ajaxchecks->verify_password($mode, $password1, $password2))
				{
					break;
				}

				if ($mode !== 'oldpassword')
				{
					$validation = $this->ajaxchecks->validation_password($mode, $password1, $password2, $mode === 'strength');
					if ($mode !== 'passwordcur' || ($mode === 'passwordcur') && $validation)
					{
						break;
					}
				}

				$this->ajaxchecks->check_password($mode, $password1);
			break;
		}
	}
}
