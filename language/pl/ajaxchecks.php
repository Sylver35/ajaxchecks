<?php
/** 
*
* Breizh ajax checks extension [Polish]
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
	'AJAX_CHECK_USERNAME_FALSE'			=> 'Ta nazwa użytkownika jest już zajęta.! Proszę wybrać inną.',
	'AJAX_CHECK_USERNAME_TRUE'			=> 'Ta nazwa użytkownika jest jeszcze dostępna.',
	'AJAX_CHECK_USERNAME_TOO'			=> 'Ta nazwa użytkownika jest niedostępna.',
	'AJAX_CHECK_USERNAME_CUR'			=> 'Ta nazwa użytkownika w tej chwili jest Twoja.',
	'AJAX_CHECKING'						=> 'Sprawdzanie używając AJAX',
	'AJAX_CHECKING_USERNAME'			=> 'Sprawdzanie dostępności Twojej nazwy użytkownika…',
	'AJAX_CHECKING_PASSWORD'			=> 'Sprawdzenie czy Twoje hasła są takie same…',
	'AJAX_CHECKING_PASSWORD_CUR'		=> 'Sprawdzenie hasła…',
	'AJAX_CHECKING_EMAIL'				=> 'Sprawdzanie poprawności Twojego e-mail…',
	'AJAX_CHECK_EMAIL_CURRENT'			=> 'To jest Twój adres e obecnie stosowane',
	'AJAX_CHECK_PASSWORD_TRUE'			=> 'Twoje hasła są takie same',
	'AJAX_CHECK_PASSWORD_FALSE'			=> 'Twoje hasła nie są takie same',
	'AJAX_CHECK_PASSWORD_STRENGTH'		=> 'Sprawdzanie poziomu zabezpieczenia Twojego hasła.',
	'AJAX_CHECK_PASSWORD_STRENGTH_0'	=> 'To hasło jest znane i zbyt powszechne. <strong>Proszę wybierz inny !</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_1'	=> 'Twoje hasło jest bardzo słabe, Bezpieczeństwo będzie niskie. <strong>Nie ponosimy ta to żadnej odpowiedzialności!</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_2'	=> 'Poziom ochrony hasła jest średni! <strong>Zabezpieczenie nie jest optymalne.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_3'	=> 'Hasło umożliwia zadowalający poziom ochrony! <strong>Możesz kontynuować.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_4'	=> 'Silne hasło, Twoje hasło zapewni optymalną ochronę! <strong>Niech moc będzie z Tobą!</strong>',
	'AJAX_CHECK_PASSWORD_BIG'			=> 'Sekund hasło jest dłuższe niż pierwszy',
	'AJAX_CHECK_PASSWORD_TOO'			=> 'Twoje hasło nie jest dostępne.',
	'AJAX_CHECK_PASSWORD_OK'			=> 'Podane hasło jest poprawne.',
	'AJAX_CHECK_PASSWORD_FAIL'			=> 'To hasło jest znane i zbyt powszechne ',
	'AJAX_CHECK_EMAIL_TRUE_FIRST'		=> 'Twój adres e-mail jest prawidłowy.',
	'AJAX_CHECK_EMAIL_FORMAT_FALSE'		=> 'Format Twojego adresu e-mail jest nieprawidłowy',
	'AJAX_CHECK_EMAIL_FAIL'				=> 'Niepoprawny adres email',
	'AJAX_CHECK_INVALID_EMAIL'			=> 'ponieważ : <span>%s</span>',
	'AJAX_CHECK_DISPLAY'				=> 'pokaż hasła',
	'AJAX_CHECK_HIDE'					=> 'ukryj hasła',
	'IMG_ICON_AJAX_STRENGTH_0'			=> 'To hasło jest znane i zbyt powszechne ',
	'IMG_ICON_AJAX_STRENGTH_1'			=> 'AJAX sila hasla - Bardzo slabe',
	'IMG_ICON_AJAX_STRENGTH_2'			=> 'AJAX sila hasla - Slabe',
	'IMG_ICON_AJAX_STRENGTH_3'			=> 'AJAX sila hasla - Dopuszczalne',
	'IMG_ICON_AJAX_STRENGTH_4'			=> 'AJAX sila hasla - Silne',
	'AJAX_CHECK_FROM'					=> '<em>Breizh Ajax Checks v%s By Sylver35</em>',
));
