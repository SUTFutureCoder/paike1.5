<?php
session_start();
	include "include/conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>沈工大 - 排课系统</title>
<link type="text/css" href="include/css/index.css" rel="stylesheet" />
<script type="text/javascript" src="include/js/Jquery.js"></script>
</head>

<body>
<div id="container">
	<!--透明遮罩成-->
    <div id="mask">
	</div>
	<!--导航栏-->	
    <div id="header">
            	<li class="li_first"><a href="index.php" class="header_first">首页</a></li>
                <li><a href="query.php" class="header_first">机房课程表</a></li>
         	    <li><a href="class_shedule.php" class="header_first">班级课程表</a></li>
					<?php
					if(isset($_SESSION['teacher_id']))
					{
						$select_flag=0;
						echo "
							<li><a href=teacher/teacher_index.php class=header_first>个人中心</a> </li>
                    		<li><a class=header_first onclick=zhuxiao()>注销</a></li>";
					}
                    else
					{
						$select_flag=1;
						echo "
							 <li><a href = teacher/index.php class=header_first>教师登录</li></a>";
					}
					?>
                   <li><a style="margin-left:60px;font-size:14px; width:120px;" href="http://www.sut.edu.cn" class="header_first" target="_blank">
                        <ul class="some_select"style= left:<?php echo $select_flag==0?"665px":"545px;"; ?>>
                            <li>按课程查询</li>
                            <li>按机房查询</li>
                            <li>按学号查询</li>
                            <li>按周次查询</li>
                            <li>按教师号查询</li>
                        </ul>
                    更多查询</a>
                    </li>
                    <li><a style=" font-size:14px; width:90px;"href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a>
                    </li>
    </div>
    
    <div id="pageBody">
    	<center>
        	<form  name="form">
            	<input type="text" name="year"  id="year" style="display:none;" value="<?php echo $db_year;?>"/>
                学院：
                <select name="school" id="school" onChange="change_school(document.form.school.options[document.form.school.selectedIndex].value)">
        			<option value="" selected="selected">==请选择学院==</option>
    			</select>
   				专业:
				<select name="major"  id="major" onChange="change_major(document.form.major.options[document.form.major.selectedIndex].value)">
	  				<option value=""selected="selected">==请选择专业==</option>
   				</select>
   				年级:
    			<select name="grade"  id="grade" onchange="change_grade(document.form.grade.options[document.form.grade.selectedIndex].value)">
     				 <option value="" selected="selected">==请选择年级==</option>
   				 </select>
   				班级:
				<select name="w_class" id="w_class">
      				<option value="" selected="selected">==请选择班级==</option>
    			</select>
   				<input type="button" value="查询" onclick="Inquiry()" class="button"/>
   				<input type="button" value="按教师查询" onclick="up_Inquiry()" class="button"/>
            
            
            	<div id="up"; style="display:none; width:400px; height:150px;">
        		<br /><br />
        		请输入教师名：&nbsp;&nbsp;<input  name="teacher_name" id="teacher_name" type="text" class="input_text" onkeydown="if(event.keyCode == 13) teacher_Inquiry()"/>
        		<br />
        		<br />
        		&nbsp;&nbsp;&nbsp;&nbsp;
        		<input type="button" value="确定" onclick="teacher_Inquiry()"  class="button"/>
        		&nbsp;&nbsp;&nbsp;&nbsp;
        		<input type="button" value="返回" onclick="teacher_Cancel()"  class="button"/>
             </form>
    		</div>
            <br /><br />
            <div id="result_query">
			</div>
        </center>
    </div>
    
    <div id="footer">
	</div>
</div>
</body>
<script src="include/js/school_major_class.js"></script>
<script>
function zhuxiao()
{
	x = "000";
	$.ajax({
   		type: "POST",
  		url: "teacher/logout.ajax.php",
		data:"x="+x,
   		success: function(msg)
		{
			window.top.location.href = "index.php";
   		}
	   }); 
}
var year = document.getElementById("year").value;
function teacher_Inquiry()
{
	teacher_name = document.getElementById("teacher_name").value;
	
	$.ajax({
		type:"POST",
		url:"take_data_teacher.ajax.php",
		data:"teacher_name="+teacher_name+"&year="+year,
		success: function(msg)
		{
			document.getElementById("container").style.height="auto";
			document.getElementById("container").style.display="inline";
			document.getElementById("result_query").innerHTML = msg;
		}
		});
	teacher_Cancel();
}
function teacher_Cancel()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#up').fadeOut(200);
}
function up_Inquiry()
{
	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.5'},200);
	$('#up').fadeIn(200);
	document.getElementById("teacher_name").focus();
}
function Inquiry()
{
	var grade_id = document.form.grade.options[document.form.grade.selectedIndex].value;
	var school_id = document.form.school.options[document.form.school.selectedIndex].value;
	var major_id = document.form.major.options[document.form.major.selectedIndex].value;
	var class_id = document.form.w_class.options[document.form.w_class.selectedIndex].value;
	var course_class = grade_id+''+school_id+''+major_id+''+class_id;
	
	//alert(course_class);
	$.ajax({
		type: "POST",
  		url: "take_data.ajax.php",
  	 	data: "year="+year+"&course_class="+course_class,
   		success: function(msg)
		{
			//document.getElementById("result_query").style.height="auto";
			//document.getElementById("result_query").style.display="inline";
			document.getElementById("result_query").innerHTML = msg;
			 /*table_temp = document.getElementById("t_table");
			 var table_rows = table_temp.rows.length;
			
			 for(x = table_rows-1;x >0;x--)
			 {
				table_temp.deleteRow(x);	
			 }
			
			 if(msg == "")
			 {
				 trr = table_temp.insertRow(1);
				 trr.innerHTML = "暂无课程信息";
			 }
			 else
			 {
				cnt=0;
				x=0;
				var data = msg.split("@");
				var len = data.length-1;
				//alert(len);
				cnt = len;
				len = len-1;
				//alert(msg);
				
    		 	for(var i = 1;i<=cnt/6;i++)
    		 	{
      		 		var trr = table_temp.insertRow(1);
      		  		for(var j=0;j<6;j++)
      				{
       					var tdd = trr.insertCell();
     				 	tdd.innerHTML="";
						len--;
     				}
				}
				for(i = 1;i<=cnt/6;i++)
    		 	{
      		  		for(var j=0;j<6;j++)
      				{
						table_temp.rows[i].cells[j].innerHTML=data[x];
       					x++;
     				}
				}
			}*/
		}
		});
}
</script>
</html>