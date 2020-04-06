<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Ajax Checks Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\ajaxchecks\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\user;
use phpbb\language\language;
use phpbb\passwords\manager;

class controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\passwords\manager */
	protected $passwords_manager;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Controller constructor
	*/
	public function __construct(config $config, request $request, user $user, language $language, manager $passwords_manager, $root_path, $php_ext)
	{
		$this->config				= $config;
		$this->request				= $request;
		$this->user					= $user;
		$this->language				= $language;
		$this->passwords_manager	= $passwords_manager;
		$this->root_path			= $root_path;
		$this->php_ext				= $php_ext;
	}

	/**
	* data checks according to configuration
	*
	* @return void
	* @access public
	*/
	public function ajax()
	{
		$mode		= $this->request->variable('mode', '');
		$username	= $this->request->variable('username', '', true);
		$email		= $this->request->variable('email', '', true);
		$password1	= $this->request->variable('password1', '', true);
		$password2	= $this->request->variable('password2', '', true);

		// Load needed language data
		$this->language->add_lang('ajaxchecks', 'sylver35/ajaxchecks');
		$this->language->add_lang('ucp');

		if (!function_exists('validate_username'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		switch ($mode)
		{
			case 'usernamecheck':
				if ($this->verify_length($mode, $username))
				{
					break;
				}
				$this->verify_username($mode, $username);
			break;

			case 'usernamecur':
				if ($this->verify_length($mode, $username))
				{
					break;
				}
				// it's actual username?
				if (utf8_case_fold_nfc($username) === utf8_case_fold_nfc($this->user->data['username']))
				{
					$this->return_content($mode, 'AJAX_CHECK_USERNAME_CUR', 'icon_ajax_true.png', 2);
					break;
				}
				$this->verify_username($mode, $username);
			break;

			case 'checkemail':
				// Verify the length
				$length = strlen($email);
				if ($length < 6)// Don't check it before
				{
					break;
				}
				if ($length < 9)// if email is too small
				{
					$this->return_content($mode, 'TOO_SHORT_EMAIL');
					break;
				}
				// Check the email is not in use, has the correct format, is for a "real" domain, etc.
				$checkresult = validate_user_email($email);
				// Check if it the email is ok (false means it is)
				if ($checkresult !== false)
				{
					// Failed the email validation
					$this->return_content($mode, 'AJAX_CHECK_EMAIL_FAIL', false, false, $this->language->lang('COMMA_SEPARATOR') . $this->language->lang('AJAX_CHECK_INVALID_EMAIL', $this->language->lang($checkresult . '_EMAIL')));
				}
				else if ($this->user->data['is_registered'] && (utf8_case_fold_nfc($email) === utf8_case_fold_nfc($this->user->data['user_email'])))
				{
					// Only in page profile & mode reg_details for the current email in use
					$this->return_content($mode, 'AJAX_CHECK_EMAIL_CURRENT', 'icon_ajax_true.png', 2);
				}
				else
				{
					$this->return_content($mode, 'AJAX_CHECK_EMAIL_TRUE_FIRST', 'icon_ajax_true.png', 2);
				}
			break;

			case 'passwordcheck':
				if ($this->verify_password($mode, $password1, $password2))
				{
					break;
				}
				$this->validation_password($mode, $password1, $password2);
			break;

			case 'passwordcur':
				if ($this->verify_password($mode, $password1))
				{
					break;
				}
				if ($this->validation_password($mode, $password1))
				{
					break;
				}
				$this->check_password($mode, $password1);
			break;

			case 'oldpassword':
				if ($this->verify_password($mode, $password1, $password2))
				{
					break;
				}
				$this->check_password($mode, $password1);
			break;

			case 'strength';
				if ($this->verify_password($mode, $password1))
				{
					break;
				}
				$this->validation_password($mode, $password1, false, true);
			break;
		}
	}

	/**
	* Send the array to the browser
	* @param string		$mode
	* @param string		$value
	* @param string		$image
	* @param int		$type
	* @param string		$reason
	* @param string		$strength
	* @return void
	* @access private
	*/
	private function return_content($mode, $value, $image = false, $type = false, $reason = false, $strength = false)
	{
		$response = new \phpbb\json_response;

		$response->send(array(
			'mode'		=> $mode,
			'content'	=> $this->language->lang($value),
			'image'		=> ($image !== false) ? $image : 'icon_ajax_false.png',
			'type'		=> ($type !== false) ? $type : 1,
			'reason'	=> ($reason !== false) ? $reason : '',
			'strength'	=> ($strength !== false) ? $this->language->lang($strength) : false,
		), true);
	}

	/**
	* Verify the length of username
	*
	* @param string		$mode
	* @param string		$username
	* @return bool
	* @access private
	*/
	private function verify_length($mode, $username)
	{
		$length = strlen($username);
		// if username is too small
		if ($length < $this->config['min_name_chars'])
		{
			$this->return_content($mode, 'TOO_SHORT_USERNAME');
			return true;
		}
		// if username is too long
		if ($length > $this->config['max_name_chars'])
		{
			$this->return_content($mode, 'TOO_LONG_USERNAME');
			return true;
		}

		return false;
	}

	/**
	* Verify if username respect all the obligations
	*
	* @param string		$mode
	* @param string		$username
	* @return bool
	* @access private
	*/
	private function verify_username($mode, $username)
	{
		// Check that the username given has not already been used
		$checkresult = validate_username($username);
		// Check if it the username is ok (false means it is)
		// if the username already exists, not banned or does not respect all the obligations
		if ($checkresult !== false)
		{
			$this->return_content($mode, $checkresult . '_USERNAME');
			return true;
		}
		else
		{
			// if username doesn't exist and respect all the obligations
			$this->return_content($mode, 'AJAX_CHECK_USERNAME_TRUE', 'icon_ajax_true.png', 2);
			return true;
		}

		return false;
	}

	/**
	* Verify length of passwords
	*
	* @param string		$mode
	* @param string		$password1
	* @param string		$password2
	* @return bool
	* @access private
	*/
	private function verify_password($mode, $password1, $password2 = false)
	{
		$length1 = strlen($password1);
		// if password1 is too small
		if ($length1 < $this->config['min_pass_chars'])
		{
			$this->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
			return true;
		}
		if ($mode == 'oldpassword')
		{
			// The two passwords are identical ?
			if (utf8_case_fold_nfc($password1) === utf8_case_fold_nfc($password2))
			{
				// If the second is the same as the current one
				$check_password = $this->passwords_manager->check($password2, $this->user->data['user_password']);
				if ($check_password !== false)
				{
					$this->return_content($mode, 'SAME_PASSWORD_ERROR');
					return true;
				}
			}
		}
		else if ($mode != 'strength')
		{
			if ($password2 !== false)
			{
				$length2 = strlen($password2);
				// if password2 is too small
				if ($length2 < $this->config['min_pass_chars'])
				{
					$this->return_content($mode, 'TOO_SHORT_PASSWORD_CONFIRM');
					return true;
				}
				// If the passwords have different lengths
				if ($length2 > $length1)
				{
					$this->return_content($mode, 'AJAX_CHECK_PASSWORD_BIG');
					return true;
				}
			}
			// Only in page reg_details for the current password in use
			if ($this->user->data['is_registered'])
			{
				$same_password = $this->passwords_manager->check($password1, $this->user->data['user_password']);
				if ($same_password)
				{
					$this->return_content($mode, 'SAME_PASSWORD_ERROR');
					return true;
				}
			}
		}

		return false;
	}

	/**
	* Check the password doesn't contain any illegal chars etc.
	*
	* @param string		$mode
	* @param string		$password
	* @return bool
	* @access private
	*/
	private function validation_password($mode, $password1, $password2 = false, $strenght = false)
	{
		$checkresult = validate_password($password1);
		// Check if the password is ok (false means it is)
		if ($checkresult !== false)
		{
			// Failed the password validation
			$this->return_content($mode, $checkresult . '_NEW_PASSWORD');
			return true;
		}
		else if ($strenght !== false)
		{
			// Check the "strength" of the password and show an image accordingly
			$strength = $this->check_password_strength($password1);
			$this->return_content($mode, $strength['content'], $strength['image'], $strength['number']+2, false, $strength['title']);
			return true;
		}
		else if ($password2 !== false)
		{
			// Check if first and second passwords are the same
			if (utf8_case_fold_nfc($password1) === utf8_case_fold_nfc($password2))
			{
				// Passwords are the same, show a correct message
				$this->return_content($mode, 'AJAX_CHECK_PASSWORD_TRUE', 'icon_ajax_true.png', 2);
				return true;
			}
			else
			{
				// Passwords not the same, show the error
				$this->return_content($mode, 'AJAX_CHECK_PASSWORD_FALSE');
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
	* @access private
	*/
	private function check_password($mode, $password)
	{
		$check_password = $this->passwords_manager->check($password, $this->user->data['user_password'], $this->user->data);
		switch ($mode)
		{
			case 'passwordcur':
				// Check if it the password is ok (false means it is)
				if ($check_password !== false)
				{
					$this->return_content($mode, 'SAME_PASSWORD_ERROR');
				}
				else
				{
					$this->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', 'icon_ajax_true.png', 2);
				}
			break;

			case 'oldpassword':
				// Check if it the password is ok (true means it is)
				if ($check_password !== false)
				{
					$this->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', 'icon_ajax_true.png', 2);
				}
				else
				{
					$this->return_content($mode, 'CUR_PASSWORD_ERROR');
				}
			break;
		}
	}

	/**
	* Check the "strength" of the password and show an image and color text accordingly
	*
	* @param string $password
	* @return array
	* @access private
	*/
	private function check_password_strength($password)
	{
		$number = 0;
		$patterns = array('#[a-z]#', '#[A-Z]#', '#[0-9]#', '/[¬!"£$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/');
		foreach ($patterns as $pattern)
		{
			if (preg_match($pattern, $password, $matches))
			{
				$number++;
			}
		}
		$length = strlen($password);
		if ($length < 8 && $number > 1)
		{
			// If the length is less than 7 maximum can be rating can be 1
			$number = 1;
		}
		else if ($length < 9 && $number > 2)
		{
			// If the length is less than 9 maximum can be rating can be 2
			$number = 2;
		}
		else if ($length >= 15 && $number != 4)
		{
			// If the length is 15 or more then give it one higher rating (unless 4 already)
			$number++;
		}

		return array(
			'number'	=> $number,
			'image'		=> 'icon_ajax_strength_' . $number . '.png',
			'title'		=> 'IMG_ICON_AJAX_STRENGTH_' . $number,
			'content'	=> 'AJAX_CHECK_PASSWORD_STRENGTH_' . $number,
		);
	}
}
