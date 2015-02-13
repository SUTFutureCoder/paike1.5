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
<title>calendar</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<script src="../include/js/Jquery.js">
</script>
</head>

<body style="margin-top:100px; margin-left:200px;">
<time>
</time>
<datalist>
</datalist>
<form name="form">
<p class="admin_tips">提示：每学期都应进行校历校准，为在排课表里显示 第几周周几 对应的日期</p>
请设置 第一周周一为:<font style="font-size:12px; color:#999;">&nbsp;&nbsp;&nbsp;&nbsp;如:2012年8月27日</font>
<p>
<input type="text" maxlength="4" name="calendar_year" class="input_text">&nbsp;&nbsp;年
<select name="calendar_month" id="calendar_month">
<?php
	for($i=1;$i<=12;$i++)
	{
		echo "<option value=\"$i\">$i</option>";
	}
?>
</select>&nbsp;&nbsp;月
<select name="calendar_day" id="calendar_day">
<?php
	for($i=1;$i<=31;$i++)
	{
		echo "<option value=\"$i\">$i</option>";
	}
?>
</select>&nbsp;&nbsp;日
<p>
<input type="button" name="sure" value="确认" onclick="rili()" class="button"/>
</form>
<script>

function select_ini(select_name,select_value)
{
	var s = document.getElementById(select_name);  
    var ops = s.options;  
    for(var i=0;i<ops.length; i++)
	{  
        var tempValue = ops[i].value;  
        if(tempValue == select_value)  
        {  
            ops[i].selected = true;  
        }  
    }  
}
//获取本地年份,设置默认值
var dateTime=new Date();
var yy = dateTime.getFullYear();
var mm = dateTime.getMonth()+1;
var dd = dateTime.getDate();

select_ini("calendar_month",mm);
select_ini("calendar_day",dd);
document.form.calendar_year.value = yy;
document.form.calendar_year.focus();
function rili()
{
	var calendar_year = document.form.calendar_year.value;
	var calendar_month = document.form.calendar_month.options[document.form.calendar_month.selectedIndex].value;
	var calendar_day = document.form.calendar_day.options[document.form.calendar_day.selectedIndex].value;
	
	if(calendar_year=="")
	{
		alert("您需要先输入年,如:2012");
		document.form.calendar_year.focus();
	}
	else if(!calendar_year.match(/^\d\d\d\d$/))
	{
		alert("输入不合法,请重新输入!");
		document.form.calendar_year.focus();
	}
	else
	{
		$.ajax({
   			type: "POST",
  			url: "calendar.ajax.php",
  	 		data: "calendar_year="+calendar_year+"&calendar_month="+calendar_month+"&calendar_day="+calendar_day,
			success: function(msg)
			{
				//alert(msg);
				if(msg=='1')
				{
					alert("设置成功");
				}
				else
					alert("设置失败");
			}
		});
	}
}
</script>
</body>
</html>