<?php
/** 
*
* Breizh ajax checks extension [French]
*
* @package language
* @copyright (c) 2018-2021 Breizh Code  https://breizhcode.com
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'AJAX_CHECK_USERNAME_FALSE'			=> 'Ce nom d’utilisateur est déjà utilisé ! Veuillez en choisir un autre.',
	'AJAX_CHECK_USERNAME_TRUE'			=> 'Ce nom d’utilisateur est disponible.',
	'AJAX_CHECK_USERNAME_TOO'			=> 'Ce nom d’utilisateur ne convient pas.',
	'AJAX_CHECK_USERNAME_CUR'			=> 'Ce nom d’utilisateur est le votre actuellement.',
	'AJAX_CHECKING'						=> 'Vérification en utilisant AJAX.',
	'AJAX_CHECKING_USERNAME'			=> 'Vérifie que le nom d’utilisateur choisi est disponible…',
	'AJAX_CHECKING_PASSWORD'			=> 'Vérifie si vos mots de passe sont les mêmes…',
	'AJAX_CHECKING_PASSWORD_CUR'		=> 'Vérification du mot de passe…',
	'AJAX_CHECKING_EMAIL'				=> 'Vérifie la validité de votre adresse courriel…',
	'AJAX_CHECK_EMAIL_CURRENT'			=> 'Ceci est votre adresse courriel actuellement utilisée',
	'AJAX_CHECK_PASSWORD_TRUE'			=> 'Vos mots de passe sont bien les mêmes. Vous pouvez continuer.',
	'AJAX_CHECK_PASSWORD_FALSE'			=> 'Vos mots de passe ne sont pas les mêmes, veuillez recommencer.',
	'AJAX_CHECK_PASSWORD_STRENGTH'		=> 'Vérification du niveau de protection de votre mot de passe.',
	'AJAX_CHECK_PASSWORD_STRENGTH_1'	=> 'Mot de passe très faible, la sécurité sera d’un niveau bas. <strong>Nous déclinons toute responsabilité !</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_2'	=> 'Mot de passe d’un niveau de protection moyen ! <strong>La sécurité ne sera pas optimale.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_3'	=> 'Mot de passe d’un niveau de protection acceptable ! <strong>Vous pouvez continuer.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_4'	=> 'Votre mot de passe vous assure une protection optimale ! <strong>Que la force soit avec vous !</strong>',
	'AJAX_CHECK_PASSWORD_BIG'			=> 'Le deuxième mot de passe est plus long que le premier',
	'AJAX_CHECK_PASSWORD_TOO'			=> 'Ce mot de passe ne convient pas.',
	'AJAX_CHECK_PASSWORD_OK'			=> 'Le mot de passe indiqué est correct.',
	'AJAX_CHECK_EMAIL_TRUE_FIRST'		=> 'Votre adresse courriel est valide.',
	'AJAX_CHECK_EMAIL_FORMAT_FALSE'		=> 'Le format de votre adresse courriel n’est pas correct ! veuillez recommencer.',
	'AJAX_CHECK_EMAIL_FAIL'				=> 'Adresse courriel non valide',
	'AJAX_CHECK_INVALID_EMAIL'			=> 'cause : <span>%s</span>',
	'AJAX_CHECK_DISPLAY'				=> 'afficher le mot de passe',
	'AJAX_CHECK_HIDE'					=> 'cacher le mot de passe',
	'IMG_ICON_AJAX_STRENGTH_1'			=> 'AJAX puissance du mot de passe = Très faible',
	'IMG_ICON_AJAX_STRENGTH_2'			=> 'AJAX puissance du mot de passe = Faible',
	'IMG_ICON_AJAX_STRENGTH_3'			=> 'AJAX puissance du mot de passe = Acceptable',
	'IMG_ICON_AJAX_STRENGTH_4'			=> 'AJAX puissance du mot de passe = Puissant',
	'AJAX_CHECK_FROM'					=> '<em>Breizh Ajax Checks v%s Par Sylver35</em>',
));
