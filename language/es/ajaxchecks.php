<?php
/** 
*
* Breizh ajax checks extension [Spanish]
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
	'AJAX_CHECK_USERNAME_FALSE'			=> 'El nombre de usuario que introdujo ya está en uso, por favor elija otro.',
	'AJAX_CHECK_USERNAME_TRUE'			=> 'Este nombre de usuario está disponible',
	'AJAX_CHECK_USERNAME_TOO'			=> 'Este nombre de usuario no está disponible.',
	'AJAX_CHECK_USERNAME_CUR'			=> 'Este es su nombre de usuario en este momento.',
	'AJAX_CHECKING'						=> 'Comprobando usando AJAX',
	'AJAX_CHECKING_USERNAME'			=> 'Comprobando que su nombre de usuario está disponible…',
	'AJAX_CHECKING_PASSWORD'			=> 'Comprobando que las contraseñas sean iguales…',
	'AJAX_CHECKING_PASSWORD_CUR'		=> 'Comprobando contraseña…',
	'AJAX_CHECKING_EMAIL'				=> 'Verificando la validez de su e-mail…',
	'AJAX_CHECK_EMAIL_CURRENT'			=> 'Este es un e-mail se utilizan actualmente',
	'AJAX_CHECK_PASSWORD_TRUE'			=> 'Las contraseñas son las mismas',
	'AJAX_CHECK_PASSWORD_FALSE'			=> 'Las contraseñas no son las mismas',
	'AJAX_CHECK_PASSWORD_STRENGTH'		=> 'Comprobando el nivel de protección de su contraseña.',
	'AJAX_CHECK_PASSWORD_STRENGTH_1'	=> 'Su contraseña es muy débil, la seguridad será baja. <strong>Renunciamos a cualquier responsabilidad!</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_2'	=> 'El nivel de protección de la contraseña es medio! <strong>La seguridad no es óptima.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_3'	=> 'Contraseña a un nivel aceptable de protección! <strong>Puede continuar.</strong>',
	'AJAX_CHECK_PASSWORD_STRENGTH_4'	=> 'Contraseña fuerte, Su contraseña asegurará una protección óptima! <strong>Que la Fuerza te acompañe!</strong>',
	'AJAX_CHECK_PASSWORD_BIG'			=> 'La segunda contraseña es más larga que la primera',
	'AJAX_CHECK_PASSWORD_TOO'			=> 'Su contraseña no está disponible.',
	'AJAX_CHECK_PASSWORD_OK'			=> 'La contraseña proporcionada es correcta.',
	'AJAX_CHECK_EMAIL_TRUE_FIRST'		=> 'Su dirección de correo electrónico es válida.',
	'AJAX_CHECK_EMAIL_FORMAT_FALSE'		=> 'El formato de su dirección de correo electrónico es incorrecto',
	'AJAX_CHECK_EMAIL_FAIL'				=> 'Dirección de correo electrónico denegada',
	'AJAX_CHECK_INVALID_EMAIL'			=> 'porque : <span>%s</span>',
	'AJAX_CHECK_DISPLAY'				=> 'mostrar contraseña',
	'AJAX_CHECK_HIDE'					=> 'ocultar contraseña',
	'IMG_ICON_AJAX_STRENGTH_1'			=> 'AJAX fortaleza de la contraseña - Muy débil',
	'IMG_ICON_AJAX_STRENGTH_2'			=> 'AJAX fortaleza de la contraseña - Débil',
	'IMG_ICON_AJAX_STRENGTH_3'			=> 'AJAX fortaleza de la contraseña - Aceptable',
	'IMG_ICON_AJAX_STRENGTH_4'			=> 'AJAX fortaleza de la contraseña - Fuerte',
	'AJAX_CHECK_FROM'					=> '<em>Breizh Ajax Checks v%s By Sylver35</em>',
));
