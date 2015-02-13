// JavaScript Document

function wz_index()
{
	window.location = '../index.php';
}
function log_out()
{
	$.ajax(
		{
			type:'POST',
			url:'logout.ajax.php',
			success: function()
			{
				window.location = '../index.php';	
			}	
		}
	);	
}
function alert_custom(text)
{
	document.getElementById('alert_content').innerHTML = text;
	$('#alert').fadeIn(200,function(){$('#alert').fadeOut(1500)});
}
function alert_custom_ask(text)
{
	document.getElementById('alert_content').innerHTML = text;
	$('#alert').fadeIn(200);
	$('#mask').css({'zIndex':'5'});
}
function alert_custom_error(text)
{
	$('#alert_img').attr({'src':'img/appbar.close.png'});
	document.getElementById('alert_content').innerHTML = text;
	$('#alert').fadeIn(200,function(){$('#alert').fadeOut(2500,function(){$('#alert_img').attr({'src':'img/appbar.check.png'});})});	
}
function open_b()
{
	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.5'});
	$('#base_info').fadeIn();	
}
function cancel_b()
{
//	alert('= =!');
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#base_info').fadeOut();
}
function open_p()
{
	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.5'});	
	$('#psw_info').fadeIn();
}
function cancel_p()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#psw_info').fadeOut();	
}
function open_u()
{
	document.getElementById('course').innerHTML = '';
	$('#course').load('teacher_management_get_option.ajax.php');
	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.5'});	
	$('#upload_info').fadeIn();
}
function cancel_u()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#upload_info').fadeOut();	
}
function check_file()
{
	var course_name = document.getElementById('course').options[document.getElementById('course').selectedIndex].text;
	if(course_name == '==请选择课程==' || document.getElementById('file').value == '')
	{
		alert_custom_error('请选择课程或文件.');	
	}
	else
	{
		document.getElementById('file_form').submit();	
	}	
}
$('.del_img').hover(
	function()
	{
		$(this).attr({'src':'img/cancel_active.png'});
	},
	function()
	{
		$(this).attr({'src':'img/cancel.png'});	
	}
);
$('#base_info_img').hover(
	function()
	{
		$(this).attr({'src':'img/base_info_active.png'});	
	},
	function()
	{
		$(this).attr({'src':'img/base_info.png'});	
	}
);
$('#psw_info_img').hover(
	function()
	{
		$(this).attr({'src':'img/psw_info_active.png'});	
	},
	function()
	{
		$(this).attr({'src':'img/psw_info.png'});	
	}
);
$('#upload_img').hover(
	function()
	{
		$(this).attr({'src':'img/upload_active.png'});
		$('#upload_button').css({'backgroundColor':'#2d2d2d'});	
	},
	function()
	{
		$(this).attr({'src':'img/upload.png'});
		$('#upload_button').css({'backgroundColor':'#FFF'});	
	}
);
$('#schedule_img').hover(
	function()
	{
		$(this).attr({'src':'img/schedule_active.png'});
		$('#schedule_button').css({'backgroundColor':'#2d2d2d'});	
	},
	function()
	{
		$(this).attr({'src':'img/schedule.png'});
		$('#schedule_button').css({'backgroundColor':'#FFF'});	
	}
);
$('#disp_course').hover(
	function()
	{
		$('#disp_title').animate({'backgroundColor':'#2d2d2d','boxShadow':'#2d2d2d 0 0 3px'});	
	},
	function()
	{
		$('#disp_title').animate({'backgroundColor':'#6e6e6e','boxShadow':'#6e6e6e 0 0 3px'});	
	}
);
$('#add_course').hover(
	function()
	{
		$('#add_title').animate({'backgroundColor':'#2d2d2d','boxShadow':'#2d2d2d 0 0 3px'});	
	},
	function()
	{
		$('#add_title').animate({'backgroundColor':'#6e6e6e','boxShadow':'#6e6e6e 0 0 3px'});	
	}
);
$('#modify_psw').hover(
	function()
	{
		$('#mod_title').animate({'backgroundColor':'#2d2d2d','boxShadow':'#2d2d2d 0 0 3px'});	
	},
	function()
	{
		$('#mod_title').animate({'backgroundColor':'#6e6e6e','boxShadow':'#6e6e6e 0 0 3px'});	
	}
);
$('.input_text').focus(
	function()
	{
		$(this).animate({'backgroundColor':'#2d2d2d'},300);	
	}
);
$('.input_text').blur(
	function()
	{
		$(this).animate({'backgroundColor':'#6e6e6e'},300);	
	}
);
$('.psw').focus(
	function()
	{
		$(this).animate({'backgroundColor':'#2d2d2d'},300);	
	}
);
$('.psw').blur(
	function()
	{
		$(this).animate({'backgroundColor':'#6e6e6e'},300);	
	}
);