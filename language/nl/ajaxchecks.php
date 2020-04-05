<?php
/** 
*
* Breizh ajax checks extension [Dutch]
*
* @package language
* @copyright (c) 2018-2020 Breizh Code  https://breizhcode.com
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
	'AJAX_CHECK_USERNAME_FALSE'			=> 'Deze gebruikersnaam is al in gebruik! Kies a.u.b. een andere gebruikersnaam.',
	'AJAX_CHECK_USERNAME_TRUE'			=> 'Deze gebruikersnaam is nog beschikbaar',
	'AJAX_CHECK_USERNAME_TOO'			=> 'Deze gebruikersnaam is niet beschikbaar.',
	'AJAX_CHECK_USERNAME_CUR'			=> 'Deze gebruikersnaam wordt op dit moment gebruikt voor jouw account.',
	'AJAX_CHECKING'						=> 'Controleert door gebruik te maken van AJAX',
	'AJAX_CHECKING_USERNAME'			=> 'Controleert of de gebruikersnaam nog beschikbaar is…',
	'AJAX_CHECKING_PASSWORD'			=> 'Controleert of de opgegeven wachtwoorden gelijk zijn…',
	'AJAX_CHECKING_PASSWORD_CUR'		=> 'Controleert wachtwoord…',
	'AJAX_CHECKING_EMAIL'				=> 'Controleert de geldigheid van jou e-mailadres…',
	'AJAX_CHECK_EMAIL_CURRENT'			=> 'Dit is uw e-mail die momenteel gebruikt',
	'AJAX_CHECK_PASSWORD_TRUE'			=> 'De opgegeven wachtwoorden zijn gelijk',
	'AJAX_CHECK_PASSWORD_FALSE'			=> 'De opgegeven wachtwoorden zijn niet gelijk',
	'AJAX_CHECK_PASSWORD_STRENGTH'		=> 'Controleert de veiligheidsgraad van het opgegeven wachtwoord.',
	'AJAX_CHECK_PASSWORD_STRENGTH_1'	=> 'Het opgegeven wachtwoord is erg zwak, de veiligheid ervan zal erg laag zijn. <strong>Wij kunnen op geen enkele wijze aansprakelijk gesteld worden!</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_2'	=> 'Het opgegeven wachtwoord is gemiddeld, de veiligheid ervan zal gemiddeld zijn <strong>De veiligheid is niet optimaal.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_3'	=> 'Het opgegeven wachtwoord is goed, de veiligheid ervan zal voldoende zijn! <strong>Je kunt verder gaan met de registratie.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_4'	=> 'Het opgegeven wachtwoord is erg sterk, de veiligheid ervan kan niet beter! <strong>Je kunt verder gaan met de registratie.</strong>',
	'AJAX_CHECK_PASSWORD_BIG'			=> 'De tweede wachtwoord langer is dan de eerste',
	'AJAX_CHECK_PASSWORD_TOO'			=> 'Het wachtwoord is niet beschikbaar.',
	'AJAX_CHECK_PASSWORD_OK'			=> 'Het opgegeven wachtwoord is oke.',
	'AJAX_CHECK_EMAIL_TRUE_FIRST'		=> 'Het opgegeven e-mailadres is geldig.',
	'AJAX_CHECK_EMAIL_FORMAT_FALSE'		=> 'Het opgegeven e-mailadres formaat is niet geldig',
	'AJAX_CHECK_EMAIL_FAIL'				=> 'Het opgegeven e-mailadres geweigerd',
	'AJAX_CHECK_INVALID_EMAIL'			=> 'omdat : <span>%s</span>',
	'AJAX_CHECK_DISPLAY'				=> 'toon wachtwoord',
	'AJAX_CHECK_HIDE'					=> 'wachtwoord verbergen',
	'IMG_ICON_AJAX_STRENGTH_1'      	=> 'AJAX wachtwoord sterkte - Erg zwak',
	'IMG_ICON_AJAX_STRENGTH_2'      	=> 'AJAX wachtwoord sterkte - Zwak',
	'IMG_ICON_AJAX_STRENGTH_3'      	=> 'AJAX wachtwoord sterkte - Acceptabel',
	'IMG_ICON_AJAX_STRENGTH_4'      	=> 'AJAX wachtwoord sterkte - Sterk',
	'AJAX_CHECK_FROM'					=> '<em>Breizh Ajax Checks v%s By Sylver35</em>',
));
