<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教学辅助平台后台管理</title>
<script src="../include/js/jquery.js">
</script>
<style>
body{
	background-image:url(../image/bg.bmp);
	font-weight:400;
}
.index{
	border-radius:20px;
	background-color:#EF8333;
	position:absolute;
	font-family:微软雅黑;
	color:#FFF;
	width:450px;
	height:265px;
	margin-top:200px;
	margin-left:450px;
}
form
{
	margin-top:40px;
	margin-left:50px;
}
input{
	font-size:16px;
	margin-left:20px;
	text-align:left;
}
button{
	 font-family:微软雅黑;
	 border-radius:5px;
	 background-color:#323941;
	  color:#FFFFFF; 
	  border:#C0BDA5;
	  font-size:20px;
	  width:80px;
	  height:40px;
}
.tips{
	width:100px;
	border-radius:5px;
	margin-left:10px;
	background-color:#323941;
	padding-top:6px;
	padding-bottom:6px;
	padding-left:15px;
	padding-right:15px;
	font-size:12px;
	-moz-opacity:0.6; /* Moz + FF 透明度20%*/
	filter:alpha(opacity=40); /* IE 透明度20% */
	 opacity: 0.6; /* 支持CSS3的浏览器（FF 1.5也支持）透明度20%*/
	 display:none;
}
.yzm_tips{
	margin-left:10px;
	border-radius:5px;
	background-color:#323941;
	padding-top:9px;
	padding-bottom:9px;
	padding-left:25px;
	padding-right:25px;
	font-size:18px;
	-moz-opacity:0.6; /* Moz + FF 透明度20%*/
	filter:alpha(opacity=40); /* IE 透明度20% */
	 opacity: 0.6; /* 支持CSS3的浏览器（FF 1.5也支持）透明度20%*/
	 display:none;
}
</style>
</head>
<?php include "yanzhengma.php" ?>
<body onLoad="createCode();"><!--createCode()为js函数，在yanzhengma.js里-->
<div class="index">
<form name="form">
用户名:<input type="text" name="admin_user" name="admin_user" /><font id="f_user" class="tips">请输入用户名</font><br /><br />

密&nbsp;&nbsp;&nbsp;码:<input type="password" name="admin_psw" /><font id="f_psw" class="tips">请输入密码</font><br /><br />

验证码:<input type="text" id="input1" style="width:90px;" name="admin_yzm"/><!--输入验证码框-->
<input type="button" id="checkCode" class="code" style="width:60px" onClick="createCode()" />&nbsp;&nbsp;&nbsp;<font id="f_yzm" class="tips">请输入验证码</font><!--验证码 图片，指定class、onClick和id-->
<br /><br />

<button type="button" onClick="validate();" value="确定" onmousemove="change()" onmouseout="change1()" name="btn">登录</button><font id="f_error" class="yzm_tips">用户名或密码错误</font><!--按钮需指定onclick="validate()函数"-->
</form>
</div>
<!--js验证码-->
<script>

function change()
{
	form.btn.style.backgroundColor="#039145";
}
function change1()
{
	form.btn.style.backgroundColor="#323941";
}

function validate ()
{
	var inputCode = document.getElementById("input1").value.toUpperCase();
	if(form.admin_user.value=="")
	{
		$("#f_user").fadeIn("slow");
		$("#f_psw").fadeOut("slow");
		$("#f_yzm").fadeOut("slow");
		$("#f_error").fadeOut("slow");
		form.admin_user.focus();
		return  false;
	}
	else if(form.admin_psw.value=="")
	{
		$("#f_user").fadeOut("slow");
		$("#f_yzm").fadeOut("slow");
		$("#f_psw").fadeIn("slow");
		$("#f_error").fadeOut("slow");
		form.admin_psw.focus();
		return false;
	}
	
	else if(inputCode.length <=0) 
	{
		document.getElementById("f_yzm").innerHTML="请输入验证码";
		$("#f_user").fadeOut("slow");
		$("#f_psw").fadeOut("slow");
		$("#f_yzm").fadeIn("slow");
		$("#f_error").fadeOut("slow");
		form.admin_yzm.focus();
   	    return false;
	}
	else if(inputCode != code)	
	{
		document.getElementById("f_yzm").innerHTML="验证码输入错误";
   		//alert("验证码输入错误！");
		$("#f_user").fadeOut("slow");
		$("#f_psw").fadeOut("slow");
		$("#f_yzm").fadeIn("slow");
		$("#f_error").fadeOut("slow");
		form.admin_yzm.focus();
		
   		createCode();
  	 	return false;
	}
	else 
	{
		var user=form.admin_user.value;
		var psw=form.admin_psw.value;
		//jquery封装的ajax
   		$.ajax({
   		type: "POST",
  		url: "login.php",
  	 	data: "admin_user="+user+"&admin_psw="+psw,
   		success: function(msg)
		{
     		if(msg==1)
	 		{
				$("#f_user").fadeOut("slow");
				$("#f_psw").fadeOut("slow");
				$("#f_yzm").fadeOut("slow");
				$("#f_error").fadeOut("slow");
				window.location.href="test.php";
			}
	 		else
	 		{
				$("#f_user").fadeOut("slow");
				$("#f_psw").fadeOut("slow");
				$("#f_yzm").fadeOut("slow");
				$("#f_error").fadeIn("slow");
				form.admin_user.focus();
			}
   		}
	   }); 
	}
}
</script>
</body>
</html>