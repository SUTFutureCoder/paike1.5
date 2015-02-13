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
<link rel="stylesheet" href="include/css/admin.css" />

<script src="../include/js/Jquery.js">
</script>
<title>menu</title>
</head>

<body>
	<ul id="dh_one">
    	<li><a onclick="shouye()">首页</a></li>
        <li><a href="initialize.php" target="right" >学期初始化</a></li>
         <li><a onclick="hide_show('dh_two2',this)"><font>+</font>&nbsp;排课管理</a></li>
        	<span id="dh_two2">
            	<li><a href="manage_course_schedule.php" target="right" >当前记录</a></li>
                <li><a href="data_all_select.php" target="right" >往年记录</a></li>
                <li><a href = "delete_data.php"; target="right" >删除记录</a></li>
            </span>
    	<li><a onclick="hide_show('dh_two1',this)"><font>+</font>&nbsp;教师管理</a></li>
        	<span id="dh_two1">
                <li><a href="add_teacher.php" target="right" >增加教师</a></li>
                <li><a href="manage_teacher.php" target="right">删改教师</a></li>
            </span>
        <li><a href="manage_course.php" target="right">课程管理</a></li>   
        <li><a href="calendar.php" target="right">校历校准</a></li>
        <li><a href="add_class.php" target="right">班级添加</a></li>
        <li><a href="data_dump.php" target="right">数据导入导出</a></li>
        <li><a href = "update_psw.php"; target="right" >修改密码</a></li>
        <li><a onclick="zhuxiao()">注销</a></li>
    </ul>
</body>
<script>
document.getElementById("dh_two1").style.display="none";
document.getElementById("dh_two2").style.display="none";
function hide_show(ndx,obj)
{
	var showHideTemp = document.getElementById(ndx).style.display;
	if(showHideTemp=="none")
	{
		document.getElementById(ndx).style.display="block";
		obj.childNodes[0].innerHTML="-";
		
		
	}
	else
	{
		document.getElementById(ndx).style.display="none";
		obj.childNodes[0].innerHTML="+";
	}
}

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
</html>
