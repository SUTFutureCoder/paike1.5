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
<title>初始化</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
</head>
<script src="../include/js/Jquery.js">
</script>
<body style="margin-top:100px; margin-left:200px;">
<form name="form">
<p class="admin_tips">提示:每学期都应进行初始化，加机房后系统自动生成所加学期和所加机房的信息，教师就可以在所加学期所加机房排课了</p>
年份:&nbsp;&nbsp;<input type="text" name="year" maxlength="4" class="input_text" />
<p>
学期:&nbsp;&nbsp;<select name="term">
<option value = "1" selected>1</option>
<option value = "2">2</option>
</select>
<p>
学院:&nbsp;&nbsp;<select name="school" id="school">
<option  value="" selected="selected">==请选择学院==</option>
</select>

<p>
机房:&nbsp;&nbsp;<input type="text" name="address" id="address" maxlength="3"  class="input_text"/>
<p>
<input type="button"  value="添加" onclick="sure()" class="button"/>
</form>
<script>
var dateTime=new Date();
var yy = dateTime.getFullYear();
document.form.year.value = yy;
document.form.year.focus();
function sure()
{
	var year = document.form.year.value;
	var term = document.form.term.options[document.form.term.selectedIndex].value;
	var school_id = document.form.school.options[document.form.school.selectedIndex].value;
	var school = document.form.school.options[document.form.school.selectedIndex].text;
	var address = document.form.address.value;
	year_term_school_address = year+''+term+''+school_id+''+address;
	
	if(year=="")
	{
		alert("您需要输入年份,如:2013");
		document.form.year.focus();
	}
	else if(address=="")
	{
		alert("您需要输入机房号,如:205");
		document.form.address.focus();
	}
	else if(!year.match(/^\d\d\d\d$/))
	{
		alert("输入不合法,请重新输入");
		document.form.year.focus();
	}
	else if(!address.match(/^\d\d\d$/))
	{
		alert("输入不合法,请重新输入");
		document.form.address.focus();
	}
	else
	{
	year_term = year+''+term;
	//alert(year_term_school_address);
	$.ajax({
   		type: "POST",
  		url: "initialize.ajax.php",
  	 	data: "year_term_school_address="+year_term_school_address+"&school="+school+"&address="+address+"&year_term="+year_term+"&school_id="+school_id,
   		success: function(msg)
		{
			//alert(msg);
			if(msg=='1')
			{
				alert("添加成功");
			}
			else
			{
				alert("添加失败,已有该信息");
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
