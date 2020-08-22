<?php
/** 
*
* Breizh ajax checks extension [German (Casual Honorifics)]
*
* @package language
* @copyright (c) 2018-2020 Breizh Code  https://breizhcode.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @translators Sylver35  https://breizhcode.com  pierredu  https://www.insecte.org/forum
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
	'AJAX_CHECK_USERNAME_FALSE'			=> 'Dieser Benutzername wird bereits verwendet! Bitte wähle einen anderen.',
	'AJAX_CHECK_USERNAME_TRUE'			=> 'Der Benutzername ist noch verfügbar',
	'AJAX_CHECK_USERNAME_TOO'			=> 'Der Benutzername ist nicht verfügbar.',
	'AJAX_CHECK_USERNAME_CUR'			=> 'Das ist dein Benutzername im Moment.',
	'AJAX_CHECKING'						=> 'Prüfen mit AJAX',
	'AJAX_CHECKING_USERNAME'			=> 'Überprüfen, ob der Benutzername noch verfügbar ist…',
	'AJAX_CHECKING_PASSWORD'			=> 'Überprüfen, ob die Passwörter übereinstimmen…',
	'AJAX_CHECKING_PASSWORD_CUR'		=> 'Überprüfe Passwort…',
	'AJAX_CHECKING_EMAIL'				=> 'Überprüfe die Gültigkeit deiner E-Mail-Adresse…',
	'AJAX_CHECK_EMAIL_CURRENT'			=> 'Das ist deine derzeit verwendeten E-Mail',
	'AJAX_CHECK_PASSWORD_TRUE'			=> 'Die Passwörter stimmen überein',
	'AJAX_CHECK_PASSWORD_FALSE'			=> 'Die Passwörter stimmen nicht überin',
	'AJAX_CHECK_PASSWORD_STRENGTH'		=> 'Überprüfen des Passwortschutzes.',
	'AJAX_CHECK_PASSWORD_STRENGTH_1'	=> 'Passwortschutz schwach. Die Sicherheit ist zu gering. <strong>Wir lehnen jegliche Verantwortung ab!</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_2'	=> 'Passwortschutz medium! <strong>Die Sicherheit ist nicht optimal.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_3'	=> 'Passwortschutz akzeptabel! <strong>Du kannst fortfahren.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_4'	=> 'Passwortschutz stark! Dein Passwort sorgt für optimalen Schutz! <strong>Möge die Macht mit dir sein!</strong>',
	'AJAX_CHECK_PASSWORD_BIG'			=> 'Das zweite Passwort ist länger als das erste',
	'AJAX_CHECK_PASSWORD_TOO'			=> 'Das Passwort ist nicht verfügbar.',
	'AJAX_CHECK_PASSWORD_OK'			=> 'Das angegebene Passwort stimmt.',
	'AJAX_CHECK_EMAIL_TRUE_FIRST'		=> 'Deine E-Mail-Adresse ist gültig.',
	'AJAX_CHECK_EMAIL_FORMAT_FALSE'		=> 'Das Format der E-Mail-Adresse ist falsch',
	'AJAX_CHECK_EMAIL_FAIL'				=> 'Ungültige E-Mail-Adresse',
	'AJAX_CHECK_INVALID_EMAIL'			=> 'weil : <span>%s</span>',
	'AJAX_CHECK_DISPLAY'				=> 'Passwort anzeigen',
	'AJAX_CHECK_HIDE'					=> 'Passwort ausblenden',
	'IMG_ICON_AJAX_STRENGTH_1'			=> 'AJAX Passwortsicherheit - Sehr schwach',
	'IMG_ICON_AJAX_STRENGTH_2'			=> 'AJAX Passwortsicherheit - Schwach',
	'IMG_ICON_AJAX_STRENGTH_3'			=> 'AJAX Passwortsicherheit - Akzeptabel',
	'IMG_ICON_AJAX_STRENGTH_4'			=> 'AJAX Passwortsicherheit - Stark',
	'AJAX_CHECK_FROM'					=> '<em>Breizh Ajax Checks v%s By Sylver35</em>',
));
