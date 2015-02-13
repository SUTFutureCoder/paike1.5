// JavaScript Document
function alert_custom(text)
{
	document.getElementById('alert_content').innerHTML = text;
	$('#alert').fadeIn(200,function(){$('#alert').fadeOut(1500)});
}
function alert_custom_ask(text)
{
	document.getElementById('alert_content').innerHTML = text;
	$('#alert').fadeIn(200);
	$('#.up').css({'zIndex':'5'});
}
function alert_custom_error(text)
{
	$('#alert_img').attr({'src':'img/appbar.close.png'});
	document.getElementById('alert_content').innerHTML = text;
	$('#alert').fadeIn(200,function(){$('#alert').fadeOut(2500,function(){$('#alert_img').attr({'src':'img/appbar.check.png'});})});	
}
function open_b()
{
	$('.up').css({'zIndex':'5'});
	$('.up').animate({'opacity':'0.5'});
	$('#base_info').fadeIn();	
}
function cancel_b()
{
//	alert('= =!');
	$('.up').animate({'opacity':'0'},function(){$('.up').css({'zIndex':'-5'});});
	$('#base_info').fadeOut();
}