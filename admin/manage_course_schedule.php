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
</style>
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
</head>
<body>
<div id="mask"></div>
<center>
<form name="form0">
<input type="text" name="year"  style="display:none;" value="<?php echo $db_year;?>"/>

<!-- 存储日历 -->
<?php
	$sql_calendar = "select * from calendar where 1";
	$result_calendar = $conn->query($sql_calendar);
	$info_calendar = $result_calendar->fetch_array();
?>
<input type="text" name="year_rili"  id="year_rili" style="display:none;" value="<?php echo $info_calendar['calendar_year'];?>"/>
<input type="text" name="month_rili"  id="month_rili" style="display:none;" value="<?php echo $info_calendar['calendar_month'];?>"/>
<input type="text" name="day_rili"  id="day_rili" style="display:none;" value="<?php echo $info_calendar['calendar_day'];?>"/>

<div id="top">
第&nbsp;<select id="week_select" onchange="change_week()">
    <option value="01" selected>1</option>
	<?php 
	for($i=2;$i<=9;$i++)
		echo  "<option value=\"".'0'.$i."\">$i</option>";
	for($i=10;$i<=20;$i++)
		echo  "<option value=\"$i\">$i</option>";
	?>
  
	
</select>&nbsp;周
&nbsp;&nbsp;&nbsp;&nbsp;
学院:&nbsp;&nbsp;<select name="h_school" id="h_school" onchange="change()">
<?php
$sql_school = "SELECT * FROM `ini_school` WHERE 1";
$result_school = $conn->query($sql_school);
while($info_school = $conn->fetch_array($result_school))
{
	echo "<option value = \"".$info_school['school_id']."\">".$info_school['school']."</option>";
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;机房:&nbsp;&nbsp;
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button"; onclick="window_print()"; name="win_print"; id="win_print" value="打印" class="button"/>
</div>
<p>
<table width="900px;"; id="s_week"; height="550px;"; style="font-size:10px;";>
<tr align="center" height="10px;">
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
	<input  name="add" type="button" value="添加" onclick="resure()" class="button" />&nbsp;&nbsp;&nbsp;&nbsp;
	<input  name="over" type="button" value="返回" onclick="cancel()" class="button"/>
</form>


</div>
</center>
<script>
var time_array = new Array();//日历数组
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
function rili(year,month,day)
{
	flag = 0;
	flag_year = 0;
	if((year%4==0 && year%100!=0) || year%400==0)
	{
		flag = 1;
	}
	else
		flag = 0;
	for(i=1;i<=20;i++)
	{
		time_array[i] = new Array();
		for(j = 1;j<=7;j++)
		{	
			if(month==13)
			{
				month=1;
				flag_year = 1;
			}
			time_array[i][j] = month+"月"+day+"日";
			if((month==1 || month==3 ||month==5 ||month==7 ||month==8 ||month==10 ||month==12) && day==31)
			{
				day=1;
				month++;
			}
			else if(day==28 && month==2 && flag == 0)
			{
				day=1;
				month++;
			}
			else if(day==29 && month==2 && flag == 1)
			{
				day=1;
				month++;
			}
			else if((month==4 ||month==6 ||month==9 ||month==11) &&day==30)
			{
				day=1;
				month++;
			}
			else
				day++;
		}
	}
	return flag_year;
}
//打印页面
function window_print()
{
	 $("#win_print").fadeOut(0);
	var table_temp = document.getElementById("s_week");
	for(i=1;i<=5;i++)
	{
		for(j=1;j<=7;j++)
		{	if(table_temp.rows[i].cells[j].innerHTML.indexOf("点此加锁")!=-1)
			{
				table_temp.rows[i].cells[j].innerHTML="";
			}
			if(table_temp.rows[i].cells[j].innerHTML.indexOf("删除")!=-1)
			{
				table_temp.rows[i].cells[j].innerHTML=table_temp.rows[i].cells[j].innerHTML.replace("删除","");
			}
		}
	}
	window.print();
	change();
	$("#win_print").fadeIn(0);
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

	var table_temp = document.getElementById("s_week");//表格 
	var year = document.form0.year.value;//获取年份
	var h_school = document.getElementById("h_school");
	h_school = h_school.options[h_school.selectedIndex].value;//获取学院
	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	//alert(address);
	var temp = document.getElementById("week_select");//获取周次
	week= temp.options[temp.selectedIndex].value;
	time = year+''+h_school+''+address+''+week;
	//alert(time);
	//日历相关
	var week_rili = temp.options[temp.selectedIndex].text;
	//alert(time);
	var year_rili = document.form0.year_rili.value;
	var month_rili = document.form0.month_rili.value;
	var day_rili  = document.form0.day_rili.value;
	var flag_year = rili(year_rili,month_rili,day_rili);

	table_temp.rows[0].cells[1].innerHTML = "星期一 ["+time_array[week_rili][1]+"]";
	table_temp.rows[0].cells[2].innerHTML = "星期二 ["+time_array[week_rili][2]+"]";
	table_temp.rows[0].cells[3].innerHTML = "星期三 ["+time_array[week_rili][3]+"]";
	table_temp.rows[0].cells[4].innerHTML = "星期四 ["+time_array[week_rili][4]+"]";
	table_temp.rows[0].cells[5].innerHTML = "星期五 ["+time_array[week_rili][5]+"]";
	table_temp.rows[0].cells[6].innerHTML = "星期六 ["+time_array[week_rili][6]+"]";
	table_temp.rows[0].cells[7].innerHTML = "星期日 ["+time_array[week_rili][7]+"]";
	//调用动态填写表格函数
	chuancan(time);
//	$('#up').fadeOut(500);
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
						if(lock=='2')
						{
							temp.rows[i].cells[j].innerHTML=change[cnt]+"<div class=\"course_text\"><a style = \"color:red;\" class=\"prime_a\" onclick=\"deleted("+selected+","+i+","+j+")\">删除</a></div>";
						}
						else if(lock=='0')
						{
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\">管理员已加锁<p>备注:"+tips[1]+"<p><a style = \"color:red;\" class=\"prime_a\"onclick=\"deleted("+selected+","+i+","+j+")\">&nbsp;&nbsp;删除</a></div>"
						}
						else
						{
							var temp = document.getElementById("s_week");
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\"><a onclick=\"paike("+selected+","+i+","+j+")\"  class=\"prime_a\">点此加锁</a><div>";
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
time_add = time+''+row+''+cell;
document.form.time.value = time_add;//给存储时间地址ID赋值
//alert(time_add);

	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.8'},200);

$('#up').fadeIn(200);
}

//删除排课
function deleted(time,row,cell)
{
	time_add = time+''+row+''+cell;
	var conf = confirm("是否删除此排课");
	if(conf)
	{
		$.ajax({
   		type: "POST",
  		url: "../teacher/delete_course_schedule.ajax.php",
  	 	data: "time_add="+time_add,
   		success: function(msg)
		{
			//alert(msg);
			if(msg=='1')
			{
				//$('#up').fadeOut(100);
				chuancan(time_add.substr(0,12));
				
			}
			else
			{
				alert("删除失败");
				//$('#up').fadeOut(100);
				chuancan(time_add.substr(0,12));
			}
   		}
	   }); 
	}
}
//确定按钮 用来加一门课
function resure()
{
	if(document.form.tips.value=="")
	{
		alert("您需要输入说明!");
		document.form.tips.focus();
	}
	else
	{
		var student_id = "";
		var course_id = "00000000";
		time_add = document.form.time.value;
		tips = document.form.tips.value;
		//alert(time_add);
		//通过ajax给数据库添加一个课程安排
		$.ajax({
   		type: "POST",
  		url: "add_lock.ajax.php",
  	 	data: "time_add="+time_add+"&course_id="+course_id+"&student_id="+student_id+"&tips="+tips,
   		success: function(msg)
		{
			//alert(msg);
			if(msg=='1')
			{
				alert("加锁成功");
				chuancan(time_add.substr(0,12));
				$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
				$("#up").fadeOut(100);
				
			}
			else
			{
				alert("加锁失败");
				$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
				$('#up').fadeOut(100);
				chuancan(time_add.substr(0,12));
			}
   		}
	   });
	} 
	//alert(student_id+''+time_add+course_id);
}
//取消按钮，返回并更新页面
function cancel()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#up').fadeOut(500);
	time_add = document.form.time.value;
	chuancan(time_add.substr(0,12));
	
}
</script>
<script language="javascript" type="text/javascript" charset="utf-8" src="../include/js/school_major_class.js">
</script>
</body>
</html>
