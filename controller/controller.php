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
		$this->config 				= $config;
		$this->request				= $request;
		$this->user					= $user;
		$this->language				= $language;
		$this->passwords_manager 	= $passwords_manager;
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
		$mode 		= $this->request->variable('mode', '');
		$username 	= $this->request->variable('username', '', true);
		$email 		= $this->request->variable('email', '', true);
		$password1 	= $this->request->variable('password1', '', true);
		$password2 	= $this->request->variable('password2', '', true);
		$img_true	= 'icon_ajax_true.png';

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
				// Verify the length of username before
				$length = strlen($username);
				if ($length < $this->config['min_name_chars'])// if username is too small
				{
					$this->return_content($mode, 'TOO_SHORT_USERNAME');
					break;
				}
				if ($length > $this->config['max_name_chars'])// if username is too long
				{
					$this->return_content($mode, 'TOO_LONG_USERNAME');
					break;
				}
				// Check that the username given has not already been used and respect all the obligations
				$checkresult = validate_username($username);
				// Check if it the username is ok (false means it is)
				if ($checkresult !== false)// if the username already exists, is banned or does not respect all the obligations
				{
					$this->return_content($mode, $checkresult . '_USERNAME');
				}
				else// if username doesn't exist and respect all the obligations
				{
					$this->return_content($mode, 'AJAX_CHECK_USERNAME_TRUE', $img_true, 2);
				}
			break;

			case 'usernamecur':
				// Verify the length of username before
				$length = strlen($username);
				if ($length < $this->config['min_name_chars'])// if username is too small
				{
					$this->return_content($mode, 'TOO_SHORT_USERNAME');
					break;
				}
				else if ($length > $this->config['max_name_chars'])// if username is too long
				{
					$this->return_content($mode, 'TOO_LONG_USERNAME');
					break;
				}
				// it's actual username?
				if (utf8_case_fold_nfc($username) === utf8_case_fold_nfc($this->user->data['username']))
				{
					$this->return_content($mode, 'AJAX_CHECK_USERNAME_CUR', $img_true, 2);
					break;
				}
				// Check that the username given has not already been used
				$checkresult = validate_username($username);
				// Check if it the username is ok (false means it is)
				if ($checkresult === false)// if username doesn't exist and respect all the obligations
				{
					$this->return_content($mode, 'AJAX_CHECK_USERNAME_TRUE', $img_true, 2);
				}
				else// if the username already exists, not banned or does not respect all the obligations
				{
					$this->return_content($mode, $checkresult . '_USERNAME');
				}
			break;

			case 'checkemail':
				// Verify the length
				$length = strlen($email);
				if ($length < 6)// Don't check it before
				{
					break;
				}
				if ($length < 8)// if email is too small
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
					$this->return_content($mode, 'AJAX_CHECK_EMAIL_CURRENT', $img_true, 2);
				}
				else
				{
					$this->return_content($mode, 'AJAX_CHECK_EMAIL_TRUE_FIRST', $img_true, 2);
				}
			break;

			case 'passwordcheck':
				// Check that the two passwords given are the same
				// Verify the length before
				$length1 = strlen($password1);
				$length2 = strlen($password2);
				if ($length1 < $this->config['min_pass_chars'])// if password1 is too small
				{
					$this->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
					break;
				}
				// Since phpbb 3.3 no max_pass_chars
				if ($this->config->offsetExists('max_pass_chars'))
				{
					if ($length1 > $this->config['max_pass_chars'])// if password1 is too long
					{
						$this->return_content($mode, 'TOO_LONG_NEW_PASSWORD');
						break;
					}
				}
				if ($length2 < $this->config['min_pass_chars'])// if password2 is too small
				{
					$this->return_content($mode, 'TOO_SHORT_PASSWORD_CONFIRM');
					break;
				}
				// Since phpbb 3.3 no max_pass_chars
				if ($this->config->offsetExists('max_pass_chars'))
				{
					if ($length2 > $this->config['max_pass_chars'])// if password2 is too long
					{
						$this->return_content($mode, 'TOO_LONG_PASSWORD_CONFIRM');
						break;
					}
				}
				if ($length1 !== $length1)// If the passwords have different lengths
				{
					$this->return_content($mode, 'AJAX_CHECK_PASSWORD_BIG');
					break;
				}
				// Only in page i=profile&mode=reg_details for the current password in use
				if ($this->user->data['is_registered'])
				{
					$same_password = $this->passwords_manager->check($password1, $this->user->data['user_password']);
					if ($same_password)
					{
						$this->return_content($mode, 'SAME_PASSWORD_ERROR');
						break;
					}
				}
				// Check the password doesn't contain any illegal chars, etc.
				$checkresult = validate_password($password1);
				// Check if the password is ok (false means it is)
				if ($checkresult === false)
				{
					// Check if the passwords are the same
					if (utf8_case_fold_nfc($password1) === utf8_case_fold_nfc($password2))
					{
						// Passwords are the same, show a correct message
						$this->return_content($mode, 'AJAX_CHECK_PASSWORD_TRUE', $img_true, 2);
					}
					else
					{
						// Passwords not the same, show the error
						$this->return_content($mode, 'AJAX_CHECK_PASSWORD_FALSE');
					}
				}
				else
				{
					// Failed the password validation
					$this->return_content($mode, $checkresult . '_NEW_PASSWORD');
				}
			break;

			case 'strength';
				$length1 = strlen($password1);
				if ($length1 < $this->config['min_pass_chars'])// if password1 is too small
				{
					$this->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
					break;
				}
				// Since phpbb 3.3 no max_pass_chars
				if ($this->config->offsetExists('max_pass_chars'))
				{
					if ($length1 > $this->config['max_pass_chars'])// Check if password is too long
					{
						$this->return_content($mode, 'TOO_LONG_NEW_PASSWORD');
						break;
					}
				}
				// Check if the password is ok (false means it is)
				$validate = validate_password($password1);
				if ($validate !== false)
				{
					// Failed the password validation
					$this->return_content($mode, $validate . '_NEW_PASSWORD');
				}
				else
				{
					// Check the "strength" of the password and show an image accordingly
					$strength = $this->check_password_strength($password1);
					$this->return_content($mode, $strength['content'], $strength['image'], $strength['number']+2, false, $strength['title']);
				}
			break;

			case 'passwordcur':
				// Verify the length
				$length = strlen($password1);
				if ($length < $this->config['min_pass_chars'])// if password is too small
				{
					$this->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
					break;
				}
				// Since phpbb 3.3 no max_pass_chars
				if ($this->config->offsetExists('max_pass_chars'))
				{
					if ($length > $this->config['max_pass_chars'])// if password is too long
					{
						$this->return_content($mode, 'TOO_LONG_NEW_PASSWORD');
						break;
					}
				}
				// Only in page reg_details for the current password in use
				if ($this->user->data['is_registered'])
				{
					$same_password = $this->passwords_manager->check($password1, $this->user->data['user_password']);
					if ($same_password)
					{
						$this->return_content($mode, 'SAME_PASSWORD_ERROR');
						break;
					}
				}
				// Check the password doesn't contain any illegal chars, etc.
				$checkresult = validate_password($password1);
				// Check if it the password is ok (false means it is)
				if ($checkresult !== false)
				{
					// Failed the password validation
					$this->return_content($mode, $checkresult . '_NEW_PASSWORD');
					break;
				}
				$check_password = $this->passwords_manager->check($password1, $this->user->data['user_password']);
				// Check if it the password is ok (false means it is)
				if ($check_password !== false)
				{
					$this->return_content($mode, 'SAME_PASSWORD_ERROR');
				}
				else
				{
					$this->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', $img_true, 2);
				}
			break;

			case 'oldpassword':
				// Now check both are the same
				// Verify the length
				$length = strlen($password1);
				if ($length < $this->config['min_pass_chars'])// if password is too small
				{
					$this->return_content($mode, 'TOO_SHORT_NEW_PASSWORD');
					break;
				}
				// Since phpbb 3.3 no max_pass_chars
				if ($this->config->offsetExists('max_pass_chars'))
				{
					if ($length > $this->config['max_pass_chars'])// if password is too long
					{
						$this->return_content($mode, 'TOO_LONG_NEW_PASSWORD');
						break;
					}
				}
				if (utf8_case_fold_nfc($password1) === utf8_case_fold_nfc($password2))
				{
					$this->return_content($mode, 'SAME_PASSWORD_ERROR');
					break;
				}
				$check_password = $this->passwords_manager->check($password1, $this->user->data['user_password']);
				// Check if it the password is ok (true means it is)
				if ($check_password !== false)
				{
					$this->return_content($mode, 'AJAX_CHECK_PASSWORD_OK', $img_true, 2);
				}
				else
				{
					$this->return_content($mode, 'CUR_PASSWORD_ERROR');
				}
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
			'image'		=> (!$image) ? 'icon_ajax_false.png' : $image,
			'type'		=> (!$type) ? 1 : $type,
			'reason'	=> (!$reason) ? '' : $reason,
			'strength'	=> (!$strength) ? false : $this->language->lang($strength),
		), true);
	}

	/**
	* check the "strength" of the password
	* show an image and color text accordingly
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
