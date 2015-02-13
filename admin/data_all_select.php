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
<title>manage_course_schedule</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<style>
td{
	width:200px;
	height:50px;
	border:1px solid #000000;
}
table
{
	border-collapse:collapse;
}
#up{	
	position:absolute;	
	background-color:#ffffff;
/*opacity:0.5;
filter:alpha(opacity=50);IE6 */
/*-moz-opacity:0.5;  Mozilla */
/*-khtml-opacity:0.5;  Safari */
	left:400px;
	top:100px;
	z-index:20;
}
#down{
	position:absolute;
	width:500px;
	height:400px;
}
.course_text{
	margin-left:10px;
	margin-top:2px;
}
</style>
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
</head>
<body>

<br />
<center>
<form name="form0">
学期:<select name="year_term" id="year_term" onchange="change()">
<?php
$sql_year_term = "SELECT * FROM `ini_year_term` WHERE 1";
$result_year_term = $conn->query($sql_year_term );
while($info_year_term = $result_year_term->fetch_array())
{
	$year_term_temp = $info_year_term['year_term'];
	echo "<option value = \"".$info_year_term['year_term']."\">".substr($year_term_temp,0,4)."年&nbsp;&nbsp;第".substr($year_term_temp,4)."学期</option>";
}
?>
</select>
第<select id="week_select" onchange="change_week()">
    <option value="01" selected>1</option>
	<?php 
	for($i=2;$i<=9;$i++)
		echo  "<option value=\"".'0'.$i."\">$i</option>";
	for($i=10;$i<=20;$i++)
		echo  "<option value=\"$i\">$i</option>";
	?>
  
	
</select>周&nbsp;&nbsp;&nbsp;&nbsp;
学院:<select name="h_school" id="h_school" onchange="change()">
<?php
$sql_school = "SELECT * FROM `ini_school` WHERE 1";
$result_school = $conn->query($sql_school);
while($info_school = $result_school->fetch_array())
{
	echo "<option value = \"".$info_school['school_id']."\">".$info_school['school']."</option>";
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;机房：
<select id="address" onchange="change_address()">
<?php
$sql_address = "SELECT * FROM `ini_address` WHERE 1";
$result_address = $conn->query($sql_address);
while($info_address = $result_address->fetch_array())
{
	echo "<option value = \"".$info_address['address']."\">".$info_address['address']."</option>";
}
?>
</select>
<input type="button"; onclick="window_print()"; name="win_print"; id="win_print"value="打印" class="button"/>

<p>
<table width="900px;"; id="s_week"; height="550px;"; style="font-size:10px;";>
<tr align="center" height="50px;">
	<td></td>
    <td>星期一</td>
    <td>星期二</td>
    <td>星期三</td>
    <td>星期四</td>
    <td>星期五</td>
    <td>星期六</td>
    <td>星期日</td>
  </tr>
  <?php
  //生成空表格
 $i = 1;
 $j = 2;
 for($row=1;$row<=5;$row++)
 {
  		echo "<tr height=\"100px;\">";
		echo "<td align=\"center\">".$i."-".$j."节</td>";
		$i+=2;
		$j+=2;
		for($cell=1;$cell<=7;$cell++)
		{
			echo "<td></td>";		
		}
		echo "</tr>";
 }
?>
 </table>
 </form>

<!-- div层[排一个课]-->
<div id="up"; style="display:none; width:400px; height:400px;">
<form action="" name="form" style="margin-left:30px; margin-top:50px;">
	<input  type="text" style="display:none" name="time" /> <!-- 存放时间地址字段-->
    <p>
	相关说明:&nbsp;&nbsp;<p>
  	<textarea name="tips" style="height:100px; width:300px;"></textarea>
	<p>
	<input  name="add" type="button" value="添加" onclick="resure()"  class="input_text"/>&nbsp;&nbsp;&nbsp;&nbsp;
	<input  name="over" type="button" value="返回" onclick="cancel()"  class="input_text"/>
</form>


</div>
</center>
<script>
//页面加载完成后执行change()填表格操作
$(document).ready(function()
{
	var s = document.getElementById("h_school");  
    var ops = s.options;  
    for(var i=0;i<ops.length; i++)
	{  
        var tempValue = ops[i].value;  
        if(tempValue == "04")  
        {  
            ops[i].selected = true;  
        }  
    }  
	change();
   //document.form0.h_school.options[04].selected = true; 
});


//打印页面
function window_print()
{
	$("#win_print").fadeOut(0);
	var table_temp = document.getElementById("s_week");
	for(i=1;i<=5;i++)
	{
		for(j=1;j<=7;j++)
		{	if(table_temp.rows[i].cells[j].innerHTML.indexOf("无排课记录")!=-1)
			{
				table_temp.rows[i].cells[j].innerHTML="";
			}
		}
	}
	window.print();
	$("#win_print").fadeIn(0);
	change();
}
//机房下拉列表改变时调用函数
function change_address()
{
	change();
}
//第几周下拉列表改变时调用函数
function change_week()
{
	change();
}
//获取当前表单数据
function change()
{
	var year = document.getElementById("year_term");//获取年份
	year = year.options[year.selectedIndex].value;
	var h_school = document.getElementById("h_school");
	h_school = h_school.options[h_school.selectedIndex].value;//获取学院
	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	//alert(address);
	var temp = document.getElementById("week_select");//获取周次
	week= temp.options[temp.selectedIndex].value;
	time = year+''+h_school+''+address+''+week;
	//alert(time);
	
	//调用动态填写表格函数
	chuancan(time);
	$('#up').fadeOut(500);
}
</script>

<script>
//动态填写表格函数
function chuancan(selected)
{
	//selected为前12位，即没有节次和第几周
	//JQ的ajax返回id为selected的数据
	$.ajax({
   		type: "POST",
  		url: "change_table.ajax.php",
  	 	data: "time_add="+selected,
   		success: function(msg)
		{
			var temp = document.getElementById("s_week");
			var change,cnt=0;
			change=msg.split("@");//分割返回数据
			//alert(msg);
			if(msg  == '')
			{
				for(i=1;i<=5;i++)
					for(j=1;j<=7;j++)
						temp.rows[i].cells[j].innerHTML="";
			}
			else
			{
				for(i=1;i<=5;i++)
				{
					for(j=1;j<=7;j++)
					{
					
						lock = change[cnt].substr(0,1);
						change[cnt] = change[cnt].substr(1);
						tips = change[cnt].split("备注:");
						//alert(lock);
						if(lock==2)
						{
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\">"+change[cnt]+"</div>";
						}
						else if(lock==0)
						{
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\">管理员已加锁<p>备注:"+tips[1]+"</div>";
						}
						else
						{
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\">无排课记录</div>";
						}
						cnt++;
					}
				}
			}
   		}
	   }); 
}
//获取点击坐标 显示div隐藏排课层
function paike(time,row,cell)
{
var temp = document.getElementById("s_week");
time_add = time+''+row+''+cell;
document.form.time.value = time_add;//给存储时间地址ID赋值
//alert(time_add);
$('#up').fadeIn(200);
}

</script>
<script language="javascript" type="text/javascript" charset="utf-8" src="../include/js/school_major_class.js">
</script>

</body>
</html>
