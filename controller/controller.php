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
use phpbb\user;
use phpbb\config\config;

class controller
{
	/** @var \sylver35\ajaxchecks\core\ajaxchecks */
	protected $ajaxchecks;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string php_ext */
	protected $php_ext;

	/**
	 * Controller constructor
	 */
	public function __construct(ajaxchecks $ajaxchecks, request $request, language $language, user $user, config $config, $root_path, $php_ext)
	{
		$this->ajaxchecks = $ajaxchecks;
		$this->request = $request;
		$this->language = $language;
		$this->user = $user;
		$this->config = $config;
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
		// Load needed language data
		$this->language->add_lang('ajaxchecks', 'sylver35/ajaxchecks');
		$this->language->add_lang('ucp');
		$mode = $this->request->variable('mode', '');

		if ($mode === 'checkemail')
		{
			$this->validation_email($mode, (string) $this->request->variable('email', '', true));
		}
		else if (strpos($mode, 'username') !== false)
		{
			$this->verify_username_first($mode, (string) $this->request->variable('username', '', true));
		}
		else
		{
			$password1 = (string) $this->request->variable('password1', '', true);
			$password2 = (string) $this->request->variable('password2', '', true);

			if ($this->ajaxchecks->verify_password($mode, $password1, $password2))
			{
				return;
			}

			if ($mode !== 'oldpassword')
			{
				$validation = $this->ajaxchecks->validation_password($mode, $password1, $password2, $mode === 'strength');
				if ($mode !== 'passwordcur' || ($mode === 'passwordcur') && $validation)
				{
					return;
				}
			}

			$this->ajaxchecks->check_password($mode, $password1);
		}
	}

	/**
	 * Validate email
	 *
	 * @param string	$mode
	 * @param string	$email
	 * @return void
	 * @access private
	 */
	private function validation_email($mode, $email)
	{
		// if email is too small
		if (strlen($email) < 9)
		{
			$this->ajaxchecks->return_content($mode, 'TOO_SHORT_EMAIL');
			return;
		}

		include($this->root_path . 'includes/functions_user.' . $this->php_ext);

		// Check the email is not in use, has the correct format, is for a "real" domain, etc.
		$checkresult = validate_user_email($email);
		// Check if it the email is ok (false means it is)
		if ($checkresult !== false)
		{
			// Failed the email validation
			// Return the real reason
			$checkresult = (string) $checkresult;
			$result = $this->language->is_set($checkresult . '_EMAIL') ? $this->language->lang($checkresult . '_EMAIL') : $checkresult;
			$this->ajaxchecks->return_content($mode, 'AJAX_CHECK_EMAIL_FAIL', '', 0, $this->language->lang('COMMA_SEPARATOR') . $this->language->lang('AJAX_CHECK_INVALID_EMAIL', $result));
		}
		else if ($this->user->data['is_registered'] && ($this->ajaxchecks->clean_string($email) === $this->ajaxchecks->clean_string($this->user->data['user_email'])))
		{
			// Only in page profile & mode reg_details for the current email in use
			$this->ajaxchecks->return_content($mode, 'AJAX_CHECK_EMAIL_CURRENT', 'icon_ajax_true', 2);
		}
		else
		{
			$this->ajaxchecks->return_content($mode, 'AJAX_CHECK_EMAIL_TRUE_FIRST', 'icon_ajax_true', 2);
		}
	}

	/**
	 * Verify the length of username
	 *
	 * @param string	$mode
	 * @param string	$username
	 * @return void
	 * @access private
	 */
	private function verify_username_first($mode, $username)
	{
		// if username is too small
		if (strlen($username) < $this->config['min_name_chars'])
		{
			$this->ajaxchecks->return_content($mode, 'TOO_SHORT_USERNAME');
			return;
		}
		// if username is too long
		if (strlen($username) > $this->config['max_name_chars'])
		{
			$this->ajaxchecks->return_content($mode, 'TOO_LONG_USERNAME');
			return;
		}

		$this->verify_username($mode, $username);
	}

	/**
	 * Verify if username respect all the obligations
	 *
	 * @param string		$mode
	 * @param string		$username
	 * @return void
	 * @access private
	 */
	private function verify_username($mode, $username)
	{
		// it's actual username?
		if ($mode === 'usernamecur')
		{
			if ($this->verify_actual_username($username))
			{
				return;
			}
		}
		// Check that the username given has not already been used
		$checkresult = $this->validation_username($username);
		// Check if it the username is ok (false means it is)
		if ($checkresult !== false)
		{
			// if the username already exists, not allowed or does not respect all the obligations
			$this->ajaxchecks->return_content($mode, (string) $checkresult . '_USERNAME');
		}
		else
		{
			// if username doesn't exist and respect all the obligations
			$this->ajaxchecks->return_content($mode, 'AJAX_CHECK_USERNAME_TRUE', 'icon_ajax_true', 2);
		}
	}

	/**
	 * Verify if username is the actual
	 *
	 * @param string		$mode
	 * @param string		$username
	 * @return bool
	 * @access private
	 */
	private function verify_actual_username($username)
	{
		if ($this->ajaxchecks->clean_string($username) === $this->ajaxchecks->clean_string($this->user->data['username']))
		{
			$this->ajaxchecks->return_content('usernamecur', 'AJAX_CHECK_USERNAME_CUR', 'icon_ajax_true', 2);
			return true;
		}

		return false;
	}

	/**
	 * Validate username
	 *
	 * @param string	$data
	 * @return bool|string
	 * @access private
	 */
	private function validation_username($data)
	{
		include($this->root_path . 'includes/functions_user.' . $this->php_ext);

		return validate_username($data);
	}
}
