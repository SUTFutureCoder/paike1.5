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
<title>delete_data.php</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<script src="../include/js/Jquery.js">
</script>
</head>

<body style="margin-top:100px; margin-left:200px;">
<form name="form0">
<p class="admin_tips">提示：可删除 对应选择的 往年(当年)记录</p>
学期:&nbsp;&nbsp;<select name="year_term" id="year_term">
<?php
$sql_year_term = "SELECT * FROM `ini_year_term` WHERE 1";
$result_year_term = $conn->query($sql_year_term );
while($info_year_term = $result_year_term->fetch_array())
{
	$year_term_temp = $info_year_term['year_term'];
	echo "<option value = \"".$info_year_term['year_term']."\">".substr($year_term_temp,0,4)."年&nbsp;&nbsp;第".substr($year_term_temp,4)."学期</option>";
}
?>
</select><p>
学院:&nbsp;&nbsp;<select name="h_school" id="h_school"><p>
<?php
$sql_school = "SELECT * FROM `ini_school` WHERE 1";
$result_school = $conn->query($sql_school);
while($info_school = $result_school->fetch_array())
{
	echo "<option value = \"".$info_school['school_id']."\">".$info_school['school']."</option>";
}
?>
</select><p>
机房:&nbsp;&nbsp;<select name="address" id="address">
<?php
$sql_address = "SELECT distinct substr(time_add,8,3) address  FROM `teacher_sj_schedule`where 1";
$result_address = $conn->query($sql_address);
while($info_address = $result_address->fetch_array())
{
	echo "<option value = \"".$info_address['address']."\">".$info_address['address']."</option>";
}
?>
</select>
<p>
<input type="button" onclick="delete_data()" value="删除" class="button"/>
<script>
function delete_data()
{
	var year = document.getElementById("year_term");//获取年份
	var year_item = year.options[year.selectedIndex].text;
	year = year.options[year.selectedIndex].value;
	
	
	var h_school = document.getElementById("h_school");
	var school_name = h_school.options[h_school.selectedIndex].text;
	h_school = h_school.options[h_school.selectedIndex].value;//获取学院
	
	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	
	time_add = year+''+h_school+''+address;
	//alert(time_add);
	if(confirm("确定删除"+year_item+"  "+school_name+"  "+address+"实验室排课记录吗？"))
	{	
	$.ajax({
   		type: "POST",
  		url: "delete_data.ajax.php",
  	 	data: "time_add="+time_add,
   		success: function(msg)
		{
			//alert(msg);
			if(msg == 1)
				alert("删除成功");
			else
				alert("删除失败,没有所选信息记录");
   		}
	   });
	}
}
</script>
</body>
</html>