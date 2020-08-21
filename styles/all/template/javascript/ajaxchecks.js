/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Ajax Checks Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*/

/** global: config */
/** global: ajaxLang */
/** global: checks */
var checks = {
	block : 'block',
	inline : (config.register) ? 'inline' : 'block',
	autowidth : (config.register) ? ' autowidth" size="25' : '',
	ajaxCheckingImg : '<img src="'+config.path+'checking.gif" alt="'+ajaxLang['CHECKING']+'" title="'+ajaxLang['CHECKING']+'" /> ',
	ajaxCheckingTrue : '<img src="'+config.path+'icon_ajax_true.png" alt="'+ajaxLang['CHECKING']+'" title="'+ajaxLang['CHECKING']+'" /> ',
};

(function($) {  // Avoid conflicts with other libraries
	'use strict';

	// Insert elements object and attributes into DOM
	if(config.register){
		$('#username').on({
			'keyup': function(){checks.sendData('usernamecheck','username',this.value,false,'')},
			'blur': function(){checks.sendData('usernamecheck','username',this.value,false,'')},
		});
		$('<div id="usernamecheck" class="ajaxchecks"></div>').insertAfter('#username').css('display',checks.inline);
	}else if(config.details){
		if($('#username').length){
			$('#username').on({
				'keyup': function(){checks.sendData('usernamecur','username',this.value,false,'')},
				'blur': function(){checks.sendData('usernamecur','username',this.value,false,'')},
			});
			$('<div id="usernamecur" class="ajaxchecks"></div>').insertAfter('#username').css('display',checks.inline);
		}
	}

	if(config.email){
		if($('#email').length){
			$('#email').on({
				'keyup': function(){checks.sendData('checkemail','email',this.value,false,'')},
				'blur': function(){checks.sendData('checkemail','email',this.value,false,'')},
			});
			$('<div id="checkemail" class="ajaxchecks"></div>').insertAfter('#email').css('display',checks.inline);
		}
	}

	if($('#new_password').length){
		$('<div id="passwordContainer"></div><div id="passwordcur" class="ajaxchecks" style="display:'+checks.inline+';"></div><div id="strength" class="ajaxchecks" style="display:'+checks.block+';"></div>').insertBefore('#new_password');
		$('#passwordContainer').prepend($('#new_password'));
		$('<input id="passwordTxt" maxlength="255" value="" class="inputbox'+checks.autowidth+'" type="text" autocomplete="off" autocapitalize="none" spellcheck="false" autocorrect="off"></input>').insertAfter('#new_password').hide();
		$('<div id="assist-visual" class="input-control-visual"><div class="assist-area"><div id="assist-icon" class="eui-svg-assist eui-icon-assist-hide"><button id="assist-btn" type="button" class="transparent-btn" title="'+ajaxLang['DISPLAY']+'"><span id="assist-msg" class="sr-only">'+ajaxLang['DISPLAY']+'</span></button></div></div></div>').insertAfter('#passwordTxt');
		$('#assist-btn').on({'click': function(){checks.passwordSwitch('new_password','passwordTxt','assist-icon','assist-msg','assist-btn')}});
		if(config.details){
			$('#new_password').on({
				'keyup': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'')},
				'blur': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'');checks.sendData('oldpassword','password1',$('#cur_password').val(),'password2',$('#new_password').val())},
			});
			$('#passwordTxt').on({
				'keyup': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'')},
				'blur': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'');checks.sendData('oldpassword','password1',$('#cur_password').val(),'password2',$('#new_password').val())},
			});
		}else if(config.register){
			$('#new_password').on({
				'keyup': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'')},
				'blur': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'')},
			});
			$('#passwordTxt').on({
				'keyup': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'')},
				'blur': function(){checks.sendData('passwordcur','password1',this.value,false,'');checks.sendData('strength','password1',this.value,false,'')},
			});
		}
	}

	if($('#password_confirm').length){
		$('<div id="passwordContainerTwo"></div><div id="passwordcheck" class="ajaxchecks" style="display:'+checks.inline+';"></div>').insertBefore('#password_confirm');
		$('#passwordContainerTwo').prepend($('#password_confirm'));
		$('<input id="passwordTxtTwo" maxlength="255" value="" class="inputbox'+checks.autowidth+'" type="text" autocomplete="off" autocapitalize="none" spellcheck="false" autocorrect="off"></input>').insertAfter('#password_confirm').hide();
		$('<div id="assist-visual-two" class="input-control-visual"><div class="assist-area"><div id="assist-icon-two" class="eui-svg-assist eui-icon-assist-hide"><button id="assist-btn-two" type="button" class="transparent-btn" title="'+ajaxLang['DISPLAY']+'"><span id="assist-msg-two" class="sr-only">'+ajaxLang['DISPLAY']+'</span></button></div></div></div>').insertAfter('#passwordTxtTwo');
		$('#assist-btn-two').on({'click': function(){checks.passwordSwitch('password_confirm','passwordTxtTwo','assist-icon-two','assist-msg-two','assist-btn-two')}});
		if(config.details){
			$('#password_confirm').on({
				'keyup': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value)},
				'blur': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value);checks.sendData('oldpassword','password1',$('#cur_password').val(),'password2',$('#new_password').val())},
			});
			$('#passwordTxtTwo').on({
				'keyup': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value)},
				'blur': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value);checks.sendData('oldpassword','password1',$('#cur_password').val(),'password2',$('#new_password').val())},
			});
		}else if(config.register){
			$('#password_confirm').on({
				'keyup': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value)},
				'blur': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value)},
			});
			$('#passwordTxtTwo').on({
				'keyup': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value)},
				'blur': function(){checks.sendData('passwordcheck','password1',$('#new_password').val(),'password2',this.value)},
			});
		}
	}

	if(config.details && config.password){
		if($('#cur_password').length){
			$('<div id="nopassword"></div>').insertBefore('#cur_password').css({'color':'red', 'margin':'5px'}).hide();
			$('<div id="passwordContainerTer"></div>').insertBefore('#cur_password');
			$('#passwordContainerTer').prepend($('#cur_password'));
			$('<div id="oldpassword" class="ajaxchecks"></div>').insertAfter('#cur_password').css('display',checks.block);
			$('<input id="passwordTxtTer" maxlength="255" value="" class="inputbox'+checks.autowidth+'" type="text" autocomplete="off" autocapitalize="none" spellcheck="false" autocorrect="off"></input>').insertAfter('#cur_password').hide();
			$('<div id="assist-visual-ter" class="input-control-visual"><div class="assist-area"><div id="assist-icon-ter" class="eui-svg-assist eui-icon-assist-hide"><button id="assist-btn-ter" type="button" class="transparent-btn" title="'+ajaxLang['DISPLAY']+'"><span id="assist-msg-ter" class="sr-only">'+ajaxLang['DISPLAY']+'</span></button></div></div></div>').insertAfter('#passwordTxtTer');
			$('#assist-btn-ter').on({'click': function(){checks.passwordSwitch('cur_password','passwordTxtTer','assist-icon-ter','assist-msg-ter','assist-btn-ter')}});
			$('#cur_password').on({
				'keyup': function(){checks.sendData('oldpassword','password1',this.value,'password2',$('#new_password').val())},
				'blur': function(){checks.sendData('oldpassword','password1',this.value,'password2',$('#new_password').val())},
			});
			$('#passwordTxtTer').on({
				'keyup': function(){checks.sendData('oldpassword','password1',this.value,'password2',$('#new_password').val())},
				'blur': function(){checks.sendData('oldpassword','password1',this.value,'password2',$('#new_password').val())},
			});
		}
	}
	$('<div id="ajaxfrom"></div>').insertAfter('#passwordcheck').hide();

	checks.sendData = function(mode,name1,value1,name2,value2){
		if($('#ajaxfrom').is(':hidden')){
			$('#ajaxfrom').html(checks.ajaxCheckingTrue+ajaxLang['FROM']).show();
		}
		// Show that the request is running
		switch(mode){
			case 'usernamecheck':
				if(value1.length > 2){
					$('#usernamecheck').html(checks.ajaxCheckingImg+ajaxLang['USERNAME']);
				}else{
					return;
				}
			break;
			case 'passwordcur':
				if(value1.length > 3){
					$('#passwordcur').html(checks.ajaxCheckingImg+ajaxLang['PASSWORD_CUR']);
				}else{
					return;
				}
			break;
			case 'strength':
				if(value1.length > 3){
					$('#strength').html(checks.ajaxCheckingImg+ajaxLang['PASSWORD_CUR']);
				}else{
					return;
				}
			break;
			case 'passwordcheck':
				if(value1 !== '' && value2 !== '' && value2.length > 3){
					$('#passwordcheck').html(checks.ajaxCheckingImg+ajaxLang['PASSWORD']);
				}else{
					return;
				}
			break;
			case 'checkemail':
				if(value1.length > 6){
					$('#checkemail').html(checks.ajaxCheckingImg+ajaxLang['EMAIL']);
				}else{
					return;
				}
			break;
			case 'usernamecur':
				if(value1 !== '' && value1.length > 2){
					$('#usernamecur').html(checks.ajaxCheckingImg+ajaxLang['USERNAME']);
				}else{
					return;
				}
			break;
			case 'oldpassword':
				if(value1.length > 3){
					$('#oldpassword').html(checks.ajaxCheckingImg+ajaxLang['PASSWORD_CUR']);
				}else if(value1 === ''){
					checks.actualPassword();
					return;
				}else{
					return;
				}
			break;
		}
		// Verify actual password if needed
		if(config.details){
			checks.actualPassword();
		}

		var postData = 'mode='+mode+'&'+name1+'='+encodeURIComponent(value1);
		if(name2 !== false){
			postData += '&'+name2+'='+encodeURIComponent(value2);
		}
		// For register page, change language if needed
		if(config.register && $('#lang').length){
			postData += '&lang='+$('#lang option:selected').val();
		}

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: config.file,
			data: postData,
			async: true,
			cache: false,
			success: function(result){
				var title = (result.strength !== false) ? result.strength : result.content;
				$('#'+result.mode).html('<img src="'+config.path+result.image+'" alt="'+title+'" title="'+title+'" /> <span>'+result.content+result.reason+'</span>');
				$('#'+result.mode+' > span').css('color',checks.colorMessage(result.type));
				$('#'+result.mode+' > span > span').css('color','initial');
			},
			error: function(){
				$('#'+mode).html('');
			}
		});
	};

	checks.actualPassword = function(){
		if($('#cur_password').val() === ''){
			$('#nopassword').html(ajaxLang['PASSWORD_EMPTY']).show();
			$('#oldpassword').html('');
		}else{
			$('#nopassword').hide();
		}
	};

	checks.colorMessage = function(value){
		var color = '';
		switch(value){
			case 1:
			case 3:
				color = 'red';
			break;
			case 2:
				color = 'green';
			break;
			case 4:
				color = 'darkorange';
			break;
			case 5:
				color = 'royalblue';
			break;
			case 6:
				color = 'green';
			break;
		}
		return color;
	};

	checks.passwordSwitch = function(inputPassword,inputText,assistIcon,assistMsg,assistBtn){
		if(!$('#'+inputText).is(':visible')){
			// Change the icon
			$('#'+assistIcon).removeClass('eui-icon-assist-hide').addClass('eui-icon-assist-show');
			// Change show inputs
			$('#'+inputPassword).addClass('off-screen').prop('aria-hidden', true);
			$('#'+inputText).val($('#'+inputPassword).val()).show().prop('aria-hidden', false);
			// Populate the value into the hidden password field
			$('#'+inputText).on({'input': function(){$('#'+inputPassword).val($('#'+inputText).val())}});
			// If the browser fills in the password populate this value into the the text field
			$('#'+inputPassword).on({'input': function(){$('#'+inputText).val($('#'+inputPassword).val())}});
			// a bit of accessibility
			$('#'+assistMsg).text(ajaxLang['HIDE']);
			$('#'+assistBtn).attr('title', ajaxLang['HIDE']);
		}else{
			// Change the icon
			$('#'+assistIcon).removeClass('eui-icon-assist-show').addClass('eui-icon-assist-hide');
			// Hide the text field & display the password
			$('#'+inputText).hide().prop('aria-hidden', true).off('input');
			$('#'+inputPassword).removeClass('off-screen').prop('aria-hidden', false).off('input', function(){$('#'+inputText).val($('#'+inputPassword).val())});
			// a bit of accessibility
			$('#'+assistMsg).text(ajaxLang['DISPLAY']);
			$('#'+assistBtn).attr('title', ajaxLang['DISPLAY']);
		}
	};
})(jQuery);
