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
<title>班级添加</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
</head>

<body style="margin-top:100px; margin-left:200px;">
<form name="form">

<p>
学院:&nbsp;&nbsp;<select name="school" id="school">
<option  value="" selected="selected">==请选择学院==</option>
</select>
<p>
年份:&nbsp;&nbsp;<input type="text" name="year" maxlength="4" class="input_text" />
<p>
<p>
专业:&nbsp;&nbsp;<input type="text" name="add_major" maxlength="4" class="input_text" />
<p class="admin_tips">例：计算机</p>
<p>
班数:&nbsp;&nbsp;<input type="text" name="number" id="address" maxlength="3"  class="input_text"/>
<p class="admin_tips">例：10</p>
<p>
<input type="button"  value="添加" onclick="sure()" class="button"/>
</form>
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
<script>
var dateTime=new Date();
var yy = dateTime.getFullYear();
document.form.year.value = yy;
document.form.year.focus();
function sure()
{
	var year = document.form.year.value;	
	var school_id = document.form.school.options[document.form.school.selectedIndex].value;
	var school = document.form.school.options[document.form.school.selectedIndex].text;
	var add_major = document.form.add_major.value;
	var number = document.form.number.value;
	
	
	if(year=="")
	{
		alert("您需要输入年份,如:2015");
		document.form.year.focus();
	}
	else if(add_major=="")
	{
		alert("您需要输入专业名,如:计算机");
		document.form.add_major.focus();
	}
	else if(!year.match(/^\d\d\d\d$/))
	{
		alert("输入不合法,请重新输入");
		document.form.year.focus();
	}
	else if(number == "" || number <= 0)
	{
		alert("您需要输入班数,如:3");
		document.form.address.focus();
	}
	else
	{	
	$.ajax({
   		type: "POST",
  		url: "add_class.ajax.php",
  	 	data: "year="+year+"&add_major="+add_major+"&number="+number+"&school_id="+school_id,
   		success: function(msg)
		{
			//alert(msg);
			if(msg=='1')
			{
				alert("添加成功");
			}
			else
			{
				alert("添加失败,请联系管理员");
			}
   		}
	   }); 
	}
}
</script>
<script src="../include/js/school_major_class.js">
</script>
</body>
</html>
