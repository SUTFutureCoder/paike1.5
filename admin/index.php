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
<title>管理员</title>
<style>
body
{
	font-family:微软雅黑;
	margin:0;
}
div.header
{
	width:1137px;
	line-height:40px;
	color:#000;
	border:1px solid #CCC;
	font-size:16px;
	text-align:center;
	background-color:#EBEAEB;
	border-radius:5px;
	margin-top:1px;
	margin-bottom:5px;
	text-shadow:0 0 1px #000;
	background-image:-webkit-gradient(linear,0 0,0 30,from(hsla(0,0%,100%,.9)),to(hsla(0,0%,100%,0)));
}
div.contest
{
	margin:1px auto;
	width:1200px;
}
div span.admin
{
	font-size:20px;
}
.header img
{
	margin-bottom:-6px;	
	border:1px solid transparent;
}
.header img:hover
{
	background-color:#000;
	border:1px solid #CCC;
}
.header a
{
	text-decoration:none;
	color:#000;
}
</style>
</head>
<body>
	
    <div class="contest">
    	<div class="header">
        	<a href="../index.php">
            	<img src="image/home.png" alt="首页" title="首页"/>
            </a>&nbsp;&nbsp;<a href="index.php">网站管理中心</a>
        </div>
        <iframe name="left" src="left.php" height="800px" width="170px;" style="border:1px solid #CCC; border-radius:3px;"  scrolling="no"></iframe>
        
        <iframe name="right" src="manage_course_schedule.php" height="800px;" width="80%;" border:0px; style="border:1px solid #CCC; border-radius:3px;" ></iframe>
    </div>
</body>
</html>
