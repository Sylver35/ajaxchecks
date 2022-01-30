<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Ajax Checks Extension
 * @copyright	(c) 2019-2022 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\ajaxchecks\core;

use phpbb\language\language;
use phpbb\user;
use phpbb\config\config;
use phpbb\passwords\manager as passwords_manager;

class ajaxchecks
{
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
	public function __construct(language $language, user $user, config $config, passwords_manager $passwords_manager, $root_path, $php_ext)
	{
		$this->language = $language;
		$this->user = $user;
		$this->config = $config;
		$this->passwords_manager = $passwords_manager;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Send the array to the browser
	 *
	 * @param string		$mode
	 * @param string		$value
	 * @param string		$image
	 * @param int			$type
	 * @param string		$reason
	 * @param string		$strength
	 * @return void
	 * @access public
	 */
	public function return_content($mode, $value, $image = '', $type = 0, $reason = '', $strength = '')
	{
		$response = new \phpbb\json_response;
		$response->send([
			'mode'		=> $mode,
			'content'	=> $this->language->lang($value),
			'image'		=> (($image !== '') ? $image : 'icon_ajax_false') . '.png',
			'type'		=> ($type !== 0) ? $type : 1,
			'strength'	=> ($strength !== '') ? $this->language->lang($strength) : '',
			'reason'	=> $reason,
		], true);
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
			$this->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
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
	public function check_password($mode, $password)
	{
		$check_password = $this->passwords_manager->check($password, $this->user->data['user_password'], $this->user->data);
		if ($mode === 'passwordcur')
		{
			// Check if it the password is ok (false means it is)
			if ($check_password !== false)
			{
				$this->return_content($mode, 'SAME_PASSWORD_ERROR');
			}
			else
			{
				$this->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', 'icon_ajax_true', 2);
			}
		}
		else
		{
			// Check if it the password is ok (true means it is)
			if ($check_password !== false)
			{
				$this->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', 'icon_ajax_true', 2);
			}
			else
			{
				$this->return_content($mode, 'CUR_PASSWORD_ERROR');
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
	public function validation_password($mode, $password1, $password2 = '', $power = false)
	{
		$checkresult = $this->validate_password($password1);
		// Check if the password is ok (false means it is)
		if ($checkresult !== false)
		{
			// Failed the password validation
			$this->return_content($mode, (string) $checkresult . '_NEW_PASSWORD');
			return true;
		}
		else if ($power !== false)
		{
			// Check the "strength" of the password and show an image accordingly
			$strength = $this->check_password_strength($password1);
			$this->return_content($mode, $strength['content'], $strength['image'], $strength['number'] + 2, '', $strength['title']);
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
	 * Clean string in utf8
	 *
	 * @param string	$data
	 * @return string
	 * @access public
	 */
	public function clean_string($data)
	{
		if (!function_exists('utf8_strrpos'))
		{
			include($this->root_path . 'includes/utf/utf_tools.' . $this->php_ext);
		}

		return (string) utf8_clean_string($data);
	}

	/**
	 * Validate password
	 *
	 * @param string	$data
	 * @return bool|string
	 * @access private
	 */
	private function validate_password($data)
	{
		include($this->root_path . 'includes/functions_user.' . $this->php_ext);

		return validate_password($data);
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
		if ($this->clean_string($password1) === $this->clean_string($password2))
		{
			// If the second is the same as the current one
			$check_password = $this->passwords_manager->check($password2, $this->user->data['user_password']);
			if ($check_password !== false)
			{
				$this->return_content($mode, 'SAME_PASSWORD_ERROR');
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
		// Check if first and second passwords are the same
		if ($this->clean_string($password1) === $this->clean_string($password2))
		{
			// Passwords are the same, show a correct message
			$this->return_content($mode, 'AJAX_CHECK_PASSWORD_TRUE', 'icon_ajax_true', 2);
		}
		else
		{
			// Passwords not the same, show the error
			$this->return_content($mode, 'AJAX_CHECK_PASSWORD_FALSE');
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
		$patterns = ['#[a-z]#', '#[A-Z]#', '#[0-9]#', '/[¬!"£$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/'];
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

		return [
			'number'	=> $number,
			'image'		=> 'icon_ajax_strength_' . $number,
			'title'		=> 'IMG_ICON_AJAX_STRENGTH_' . $number,
			'content'	=> 'AJAX_CHECK_PASSWORD_STRENGTH_' . $number,
		];
	}
}
