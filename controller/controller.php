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

	/**
	 * Controller constructor
	 */
	public function __construct(ajaxchecks $ajaxchecks, request $request, language $language)
	{
		$this->ajaxchecks = $ajaxchecks;
		$this->request = $request;
		$this->language = $language;
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
		// mode for switch
		$mode = (string) $this->request->variable('mode', '');

		if ($mode === 'checkemail')
		{
			$this->ajaxchecks->validation_email($mode, (string) $this->request->variable('email', '', true));
		}
		else if (strpos($mode, 'username') !== false)
		{
			$this->ajaxchecks->verify_username_length($mode, (string) $this->request->variable('username', '', true));
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
}
