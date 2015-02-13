<?php 
session_start();
if(!isset($_SESSION['teacher_id']))
	echo "<script>window.top.location.href=\"../teacher/index.php\";</script>";
else
	if($_SESSION['limits'] !=0)
		echo "<script>window.top.location.href=\"../teacher/index.php\";</script>";
include "../include/conn.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
</head>

<body style="margin-top:100px; margin-left:200px;">
<form name="form_psw">
<p class="admin_tips">提示：可修改管理员密码</p>
<input type="text" name = "admin_id" style="display:none" value="<?php echo $_SESSION['teacher_id']?>"/>
<p>
原密码：&nbsp;&nbsp;&nbsp;<input  type="password" name="old_psw" class="input_text"/>
<p>
新密码：&nbsp;&nbsp;&nbsp;<input type="password" name="new_psw1" class="input_text"/>
<p>
确认密码：<input type="password" name="new_psw2" class="input_text"/>
<p>
<input type="button" value="确定" onclick="update_sure()" class="button"/>
</form>
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
<script>
document.form_psw.old_psw.focus();
function update_sure()
{
	var admin_id = document.form_psw.admin_id.value;
	var old_psw = document.form_psw.old_psw.value;
	var new_psw1 = document.form_psw.new_psw1.value;
	var new_psw2 = document.form_psw.new_psw2.value;
	if(old_psw=="")
	{
		alert("请输入原密码");
		document.form_psw.old_psw.focus();
	}
	else if(new_psw1=="")
	{
		alert("请输入新密码");
		document.form_psw.new_psw1.focus();
	}
	else if(new_psw2=="")
	{
		alert("请输入确认密码");
		document.form_psw.new_psw2.focus();
	}
	else if(new_psw1!=new_psw2)
	{
		alert("新密码与确认密码不一致");
		document.form_psw.new_psw2.focus();
	}
	else
	{
		$.ajax({
			type:"POST",
			url:"update_psw.ajax.php",
			data:"teacher_id="+admin_id+"&old_password="+old_psw+"&new_password="+new_psw1,
			success: function(msg)
			{
					if(msg == 0)
					{
						alert('数据库写入错误,请联系管理员');	//查询出错
					}
					else if(msg == 1)
					{
						alert('原密码错误,请确认填写信息');
						document.form_psw.old_psw.focus();
					}
					else if(msg == 2)
					{
						alert('密码修改成功,请牢记新密码');
						document.form_psw.new_psw1.value="";
						document.form_psw.new_psw2.value="";
						document.form_psw.old_psw.value="";	
					}
					else if(msg == 3)
					{
						alert('数据库写入错误,请联系管理员');	//密码正确,修改出错
					}
			}
		});
	}
}
</script>
</body>
</html>