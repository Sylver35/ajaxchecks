<?php
/** 
*
* Breizh ajax checks extension [English]
*
* @package language
* @copyright (c) 2019-2022 Breizh Code  https://breizhcode.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @translator Sylver35  https://breizhcode.com
* 
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'AJAX_CHECK_USERNAME_FALSE'			=> 'This username has already been taken! Please choose another one.',
	'AJAX_CHECK_USERNAME_TRUE'			=> 'This username is still available',
	'AJAX_CHECK_USERNAME_TOO'			=> 'This username is not available.',
	'AJAX_CHECK_USERNAME_CUR'			=> 'This username is your in this moment.',
	'AJAX_CHECKING'						=> 'Checking using AJAX',
	'AJAX_CHECKING_USERNAME'			=> 'Checking that your username is still available…',
	'AJAX_CHECKING_PASSWORD'			=> 'Checking that your passwords are the same…',
	'AJAX_CHECKING_PASSWORD_CUR'		=> 'Checking password…',
	'AJAX_CHECKING_EMAIL'				=> 'Checks the validity of your e-mail…',
	'AJAX_CHECK_EMAIL_CURRENT'			=> 'This is your email currently being used',
	'AJAX_CHECK_PASSWORD_TRUE'			=> 'Your passwords are the same',
	'AJAX_CHECK_PASSWORD_FALSE'			=> 'Your passwords are not the same',
	'AJAX_CHECK_PASSWORD_STRENGTH'		=> 'Checking the level of protection for your password.',
	'AJAX_CHECK_PASSWORD_STRENGTH_1'	=> 'Your password is very weak, security will be low. <strong>We disclaim any responsibility!</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_2'	=> 'Password protection level of a medium! <strong>The security is not optimal.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_3'	=> 'Password to an acceptable level of protection! <strong>You can continue.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_4'	=> 'Strong password, your password will ensure optimal protection! <strong>May the force be with you!</strong>',
	'AJAX_CHECK_PASSWORD_BIG'			=> 'The second password is longer than the first',
	'AJAX_CHECK_PASSWORD_TOO'			=> 'Your password is not available.',
	'AJAX_CHECK_PASSWORD_OK'			=> 'The password given is correct.',
	'AJAX_CHECK_EMAIL_TRUE_FIRST'		=> 'Your e-mail address is valid.',
	'AJAX_CHECK_EMAIL_FORMAT_FALSE'		=> 'Your email address format is incorrect',
	'AJAX_CHECK_EMAIL_FAIL'				=> 'Invalid email address',
	'AJAX_CHECK_INVALID_EMAIL'			=> 'because : <span>%s</span>',
	'AJAX_CHECK_DISPLAY'				=> 'show password',
	'AJAX_CHECK_HIDE'					=> 'hide password',
	'IMG_ICON_AJAX_STRENGTH_1'			=> 'AJAX password strength - Very weak',
	'IMG_ICON_AJAX_STRENGTH_2'			=> 'AJAX password strength - Weak',
	'IMG_ICON_AJAX_STRENGTH_3'			=> 'AJAX password strength - Acceptable',
	'IMG_ICON_AJAX_STRENGTH_4'			=> 'AJAX password strength - Strong',
	'AJAX_CHECK_FROM'					=> '<em>Breizh Ajax Checks v%s By Sylver35</em>',
));
