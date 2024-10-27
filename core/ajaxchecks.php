<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Ajax Checks Extension
 * @copyright	(c) 2019-2024 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\ajaxchecks\core;

use sylver35\ajaxchecks\core\work;
use phpbb\language\language;
use phpbb\user;
use phpbb\config\config;
use phpbb\passwords\manager as passwords_manager;

class ajaxchecks
{
	/** @var \sylver35\ajaxchecks\core\work */
	protected $work;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\passwords\manager */
	protected $passwords_manager;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string php_ext */
	protected $php_ext;

	/**
	 * Constructor
	 */
	public function __construct(work $work, language $language, user $user, config $config, passwords_manager $passwords_manager, $root_path, $php_ext)
	{
		$this->work = $work;
		$this->language = $language;
		$this->user = $user;
		$this->config = $config;
		$this->passwords_manager = $passwords_manager;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Verify length of passwords
	 *
	 * @param string		$mode
	 * @param string		$password1
	 * @param string		$password2
	 * @return bool
	 * @access public
	 */
	public function verify_password($mode, $password1, $password2 = '')
	{
		$length1 = strlen($password1);
		// if password is too small
		if ($length1 < $this->config['min_pass_chars'])
		{
			$this->work->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
			return true;
		}

		if ($mode === 'oldpassword')
		{
			if ($this->verify_old_password($mode, $password1, $password2))
			{
				return true;
			}
		}
		else if ($mode !== 'strength')
		{
			if ($this->verify_second_password($mode, $password1, $password2))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the password is ok
	 *
	 * @param string		$mode
	 * @param string		$password
	 * @return void
	 * @access public
	 */
	public function check_password($mode, $password, $username)
	{
		$passname = false;
		$check_pass = $this->passwords_manager->check($password, $this->user->data['user_password'], $this->user->data);
		if ($this->work->check_frequency_password($password) !== false)
		{
			if ($mode === 'passwordcur')
			$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_FAIL');
			return;
		}

		if ($this->work->clean_string($password) === $this->work->clean_string($username))
		{
			if ($mode === 'oldpassword')
			{
				$passname = true;
			}
			else
			{
				$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_NAME');
				return;
			}
		}

		if ($mode === 'passwordcur')
		{
			// Check if it the password is ok (false means it is)
			if ($check_pass !== false)
			{
				$this->work->return_content($mode, 'SAME_PASSWORD_ERROR');
			}
			else
			{
				$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', 'icon_ajax_true', 2);
			}
		}
		else
		{
			// Check if it the password is ok (true means it is)
			if ($check_pass !== false)
			{
				$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', 'icon_ajax_true', 2, '', '', $passname);
			}
			else
			{
				$this->work->return_content($mode, 'CUR_PASSWORD_ERROR', '', 0, '', '', $passname);
			}
		}
	}

	/**
	 * Check the password doesn't contain any illegal chars etc.
	 *
	 * @param string		$mode
	 * @param string		$password1
	 * @param string		$password2
	 * @param bool			$power
	 * @return bool
	 * @access public
	 */
	public function validation_password($mode, $password1, $password2 = '', $username, $power = false)
	{
		if ($this->work->clean_string($password1) === $this->work->clean_string($username))
		{
			$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_NAME');
			return;
		}

		$checkresult = $this->work->validate_password($password1);
		// Check if the password is ok (false means it is)
		if ($checkresult !== false)
		{
			// Failed the password validation
			$this->work->return_content($mode, (string) $checkresult . '_NEW_PASSWORD');
			return true;
		}
		else if ($power !== false)
		{
			// Check the "strength" of the password and show an image accordingly
			$strength = $this->work->check_password_strength($password1);
			$this->work->return_content($mode, $strength['content'], $strength['image'], $strength['number'], '', $strength['title']);
			return true;
		}
		else if ($password2 !== '')
		{
			$this->check_two_passwords($mode, $password1, $password2);
			return true;
		}

		return false;
	}

	/**
	 * Verify if passwords are identical
	 *
	 * @param string		$mode
	 * @param string		$password1
	 * @param string		$password2
	 * @return bool
	 * @access private
	 */
	private function verify_old_password($mode, $password1, $password2)
	{
		// The two passwords are identical ?
		if ($this->work->clean_string($password1) === $this->work->clean_string($password2))
		{
			// If the second is the same as the current one
			$check_pass = $this->passwords_manager->check($password2, $this->user->data['user_password']);
			if ($check_pass !== false)
			{
				$this->work->return_content($mode, 'SAME_PASSWORD_ERROR');
				return true;
			}
		}

		return false;
	}

	/**
	 * Verify the second password
	 *
	 * @param string		$mode
	 * @param string		$password1
	 * @param string		$password2
	 * @return bool
	 * @access private
	 */
	private function verify_second_password($mode, $password1, $password2)
	{
		if ($password2 !== '')
		{
			$length1 = strlen($password1);
			$length2 = strlen($password2);
			// if password2 is too small
			if ($length2 < $this->config['min_pass_chars'])
			{
				$this->work->return_content($mode, 'TOO_SHORT_PASSWORD_CONFIRM');
				return true;
			}
			// If the passwords have different lengths
			if ($length2 > $length1)
			{
				$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_BIG');
				return true;
			}
		}
		// Only in page reg_details for the current password in use
		if ($this->user->data['is_registered'])
		{
			$same_password = $this->passwords_manager->check($password1, $this->user->data['user_password']);
			if ($same_password)
			{
				$this->work->return_content($mode, 'SAME_PASSWORD_ERROR');
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the passwords are the same
	 *
	 * @param string		$mode
	 * @param string		$password1
	 * @param string		$password2
	 * @return void
	 * @access private
	 */
	private function check_two_passwords($mode, $password1, $password2)
	{
		if ($this->work->check_frequency_password($password1) !== false)
		{
			$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_FAIL');
			return;
		}
		// Check if first and second passwords are the same
		if ($this->work->clean_string($password1) === $this->work->clean_string($password2))
		{
			// Passwords are the same, show a correct message
			$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_TRUE', 'icon_ajax_true', 2);
		}
		else
		{
			// Passwords not the same, show the error
			$this->work->return_content($mode, 'AJAX_CHECK_PASSWORD_FALSE');
		}
	}
}
