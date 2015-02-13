<?php 
session_start();
if(!isset($_SESSION['teacher_id']))
	echo "<script>window.top.location.href=\"../teacher/index.php\";</script>";
else
	if($_SESSION['limits'] !=0)
		echo "<script>window.top.location.href=\"../teacher/index.php\";</script>";
include "../include/conn.php"; 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>教师用户添加</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<script src="../include/js/Jquery.js"></script>

</head>

<body style="margin-top:100px; margin-left:200px;">
<form name="form">
<p class="admin_tips">提示：可添加一名教师，其默认密码为：000000</p>
教师号:&nbsp;&nbsp;<input type="text" id="teacher_id" maxlength="5" class="input_text"><p>
教师名:&nbsp;&nbsp;<input type="text" id="teacher_name" class="input_text"><p>
所在院:&nbsp;&nbsp;<select name="school" id="school">           	
            	</select><p>
   				<input type="button" value="添加" onClick="check()" class="button">
 
</form>
<script src="../include/js/school_major_class.js"></script>
<script>
document.getElementById('school').options[04].selected = true;
function check()
{	
//	alert(document.getElementById('school').options[document.getElementById('school').selectedIndex].text);
	var id_value = document.getElementById('teacher_id').value;
	var name_value = document.getElementById('teacher_name').value;
	var school_value = document.getElementById('school').options[document.getElementById('school').selectedIndex].text;
//	alert('teacher_id='+id_value+'&teacher_name='+name_value+'&school_value='+school_value);
	if(id_value == '')
	{
		alert('您需要输入教师号');
		document.getElementById("teacher_id").focus();
	}
	else if(name_value=='')
	{
		alert('您需要输入教师名');
		document.getElementById("teacher_name").focus();
	}
	else
	{
		$.ajax({
			type: 'POST',
			url: 'add_teacher.ajax.php',
			data: 'teacher_id='+id_value+'&teacher_name='+name_value+'&teacher_school='+school_value,
			success: function(msg)
			{
//				alert(msg);
				if(msg == '1')
				{
					alert('添加成功.');	
				}
				if(msg == '0')
				{
					alert('数据库写入错误.请联系管理员.');	
				}
				if(msg == '2')
				{
					alert('此教师号已存在.请使用其他账号添加.');	
					document.getElementById("teacher_id").focus();
				}
			}
		});
	}	
}
</script>
</body>
</html>