<?php
session_start();
if(isset($_SESSION['teacher_id']))
{
	if($_SESSION['limits'] ==0)
		header("location:admin/index.php");
	else
		header("location:teacher/index.php");
}
include "include/conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>机房课程表</title>
<link href="include/css/global.css" type="text/css" rel="stylesheet"/>
<style>
td{
	width:200px;
	height:50px;
	border:1px solid #000000;
}
table
{
	border-collapse:collapse;
	font-size:15px;
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
.header{
	background-color:#333;
	height:45px;
	margin-top:-20px;
	margin-left:-15px;
	margin-right:-15px;
	box-shadow:0px 0px 50px #FFF;
}

.header_text{
	color:#FFF;
	}
.header_first
{
	 line-height:45px;
	 display:block;
	 width:120px;
}
li
{
	text-align:center;
	display:inline;
	float:left;
	list-style:none;
}
.header_first
{
	text-decoration:none;
	color:#FFF;
	font-size:16px;
	cursor:pointer;
}
.header_first:hover{
	background-color:#000;
	cursor:pointer;
}
</style>
<script language="javascript" type="text/javascript" src="include/js/Jquery.js">
</script>
</head>
<body class="body_pos">
<div id="contest">
	<div class="header">
		<div class="header_text">
            	<ul>
            		<li><a href="index.php" class="header_first">首页</a></li>
                    <li><a href="query.php" class="header_first">机房课程表</a></li>
                    <li><a href="class_shedule.php" class="header_first">班级课程表</a></li>
                    <li><a onclick="denglu()" class="header_first">教师登录</a></li>
                     <li><a style="margin-left:120px; font-size:14px; width:90px;" href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a></li>
                    <li><a style="font-size:14px; width:90px;" href="http://www.sut.edu.cn" class="header_first" target="_blank">工大官网</a></li>
    			</ul>
        </div>
      </div>
<br />
<form name="form0">
<center>
<input type="text" name="year"  id="year" style="display:none;" value="<?php echo $db_year;?>"/>
<?php
	$sql_calendar = "select * from calendar where 1";
	$result_calendar = $conn->query($sql_calendar);
	$info_calendar = $result_calendar->fetch_array();
?>
<input type="text" name="year_rili"  id="year_rili" style="display:none;" value="<?php echo $info_calendar['calendar_year'];?>"/>
<input type="text" name="month_rili"  id="month_rili" style="display:none;" value="<?php echo $info_calendar['calendar_month'];?>"/>
<input type="text" name="day_rili"  id="day_rili" style="display:none;" value="<?php echo $info_calendar['calendar_day'];?>"/>

&nbsp;&nbsp;&nbsp;
第&nbsp;<select id="week_select" onchange="change_week()">
    <option value="01" selected>1</option>
	<?php 
		for($i=2;$i<=9;$i++)
			echo  "<option value=\"".'0'.$i."\">$i</option>";
		for($i=10;$i<=20;$i++)
			echo  "<option value=\"$i\">$i</option>";
	?>
  
	
</select>&nbsp;周&nbsp;&nbsp;&nbsp;&nbsp;
学院:&nbsp;&nbsp;<select name="h_school" id="h_school" onchange="change()">
<?php
	$sql_school = "SELECT * FROM `ini_school` WHERE 1";
	$result_school = $conn->query($sql_school);
	while($info_school = $result_school->fetch_array())
	{
		echo "<option value = \"".$info_school['school_id']."\">".$info_school['school']."</option>";
	}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;机房:&nbsp;&nbsp;
<select id="address" onchange="change_address()">
<?php
	$sql_address = "SELECT distinct substr(time_add,8,3) address  FROM `teacher_sj_schedule`where 1";
	$result_address = $conn->query($sql_address);
	while($info_address = $result_address->fetch_array())
	{
		echo "<option value = \"".$info_address['address']."\">".$info_address['address']."</option>";
	}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button"; onclick="window_print()"; name="win_print"; id="win_print" value="打印" class="input_text"/>


<p>
<table width="87%;"; id="s_week"; height="550px;"; style="font-size:10px;";>
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
	<input  name="add" type="button" value="添加" onclick="resure()" />&nbsp;&nbsp;&nbsp;&nbsp;
	<input  name="over" type="button" value="返回" onclick="cancel()" />
</form>

</div>
</center>
<script>
var time_array = new Array();
//页面加载完成后执行change()填表格操作
$(document).ready(function()
{
	select_ini("h_school","04");
	change();
	var have = my_week_time();
	if(have!=-1)
	{
		select_ini("week_select",have<=9?"0"+have:have);	
	}
	change();
	
	
   //document.form0.h_school.options[04].selected = true; 
});
//设置下拉列表默认值函数
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
//调到当前周函数
function my_week_time()
{
	var have=-1;
	var myDate = new Date();
	my_month = myDate.getMonth()+1;
	my_date = myDate.getDate();
	my_date = my_month+"月"+my_date+"日";
	//alert(my_date);
	//alert(time_array[2][7]);
	for(var k = 1;k<=20;k++)
	{
		for(var h = 1;h<=7;h++)
		{
			if(time_array[k][h] == my_date)
			{
				have = 1;
				return k;
			}
		}
	}
	return have;

}
//生成日历数组
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
	//document.form0.win_print.style.display = "none";
	//document.getElementById("p_title").style.display="none";
	$("#win_print").fadeOut(0);
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
	var year = document.getElementById("year").value;//获取年份
	var h_school = document.getElementById("h_school");
	h_school = h_school.options[h_school.selectedIndex].value;//获取学院
	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	//alert(address);
	var temp = document.getElementById("week_select");//获取周次
	week= temp.options[temp.selectedIndex].value;
	time = year+''+h_school+''+address+''+week;
	
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
  		url: "admin/change_table.ajax.php",
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
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\"></div>";
						}
						cnt++;
					}
				}
			}
   		}
	   }); 
}
function denglu()
{
	var year = document.getElementById("year").value;//获取年份
	var h_school = document.getElementById("h_school");
	h_school = h_school.options[h_school.selectedIndex].value;//获取学院
	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	//alert(address);
	var temp = document.getElementById("week_select");//获取周次
	week= temp.options[temp.selectedIndex].value;
	time = year+''+h_school+''+address+''+week;
	
	window.location.href="teacher/index.php?time="+time;
}

</script>
<script language="javascript" type="text/javascript" charset="utf-8" src="include/js/school_major_class.js">
</script>
</div>
</body>
</html>
