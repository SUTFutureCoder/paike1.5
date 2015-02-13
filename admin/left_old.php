<?php 
session_start();
if(!isset($_SESSION['teacher_id']))
	header("location:../teacher/index.php");
else
	if($_SESSION['limits'] !=0)
		header("location:../teacher/index.php");
include "../include/conn.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>left</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
</head>

<body style="background-color:#FFF;">
<a onclick="shouye()" class="a">首页</a>
<p>
<a href="initialize.php" target="right" class="a" title="每学期都应进行初始化，加机房后系统自动生成所加学期和所加机房的信息，教师就可以在所加学期所加机房排课了">学期初始化</a>
<p>
<a href="calendar.php" target="right" class="a" title="每学期都应进行校历校准，为在排课表里显示 第几周周几 对应的日期">校历校准</a>
<p>
<a href="manage_course_schedule.php" target="right" class="a" title="管理员可对课程加锁，删除非法课程">排课表管理</a>
<p>
<a href="data_all_select.php" target="right" class="a" title="可 查看打印 对应选择的 往年排课信息">历史记录</a>
<p>
<a href="add_teacher.php" target="right" class="a" title="可添加一名教师">添加教师</a>
<p>
<a href = "delete_data.php"; target="right" class="a" title="可删除 对应选择的 往年记录">删除记录</a>
<p>
<a href = "update_psw.php"; target="right" class="a">修改密码</a>
<p>
<a onclick="zhuxiao()" class="a">注销</a>

<script>
function zhuxiao()
{
	x = "000";
	$.ajax({
   		type: "POST",
  		url: "../teacher/logout.ajax.php",
		data:"x="+x,
   		success: function(msg)
		{
			window.top.location.href = "../index.php";
   		}
	   }); 
}
function shouye()
{
	window.top.location.href="../index.php";
}
</script>
</body>
</html>
