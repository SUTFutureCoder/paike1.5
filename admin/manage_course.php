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
<title>课程管理</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<link href="include/css/admin.css" type="text/css" rel="stylesheet" />
<script src="../include/js/Jquery.js"></script>
</head>

<body>

<div class="teacher_info">
	<form name="form">
    <div class="admin_so_teacher_name" >
    	<input type="text" name="select_teacher_name" onkeydown="if(event.keyCode==13) so_teacher_name();" onfocus="xxx()";  onblur="yyy()"/><span onclick="xxx()" id="tips_input_tName">请输入教师名</span>&nbsp;&nbsp;&nbsp;&nbsp;
    	<a onclick="so_teacher_name()"><img src="image/select.jpg" /></a>
    </div>
	<table>
    	<tr style="font-size:16px; height:35px; font-weight:bold;">
        	<td width="10px;"></td>
        	<td>教师号</td>
            <td>教师名</td>
            <td>课程信息</td>
        </tr>
        <?php
		
			if( isset($_GET['page']) )
			{
  				 $page = intval( DB::CheckInput($_GET['page']) );
			}
			else
			{
   				$page = 1;
			} 
			$page_size=15;
			
			if(isset($_GET['teacher_name']))
			{
				$sql = "select count(*) amount from teacher where teacher_name like '%" . DB::CheckInput($_GET['teacher_name']) . "%'";
				//echo $sql;
			}
			else
			{
				$sql = "select count(*) amount from teacher";
			}
			$result = $conn->query($sql);
			$row = $result->fetch_array();
			$amount = $row['amount'];
			
			if( $amount )
			{
   				if( $amount < $page_size )
				{
					 $page_count = 1; //如果总数据量小于$PageSize，那么只有一页
				}               
   				if( $amount % $page_size ) //取总数据量除以每页数的余数
				{                                 
      				 $page_count = (int)($amount / $page_size) + 1;           //如果有余数，则页数等于总数据量除以每页数的结果取整再加一
   				}
				else
				{
       				$page_count = $amount / $page_size;                      //如果没有余数，则页数等于总数据量除以每页数的结果
   				}
			}
			else
			{
				$page_count=0;
			}
			
			
			if( $amount )
			{
				//where teacher_id not like '0000_'
   				if(isset($_GET['teacher_name']))
				{
					$sql = "select * from teacher  where teacher_id not like '0000_' and teacher_name like '%" . DB::CheckInput($_GET['teacher_name']) . "%' order by teacher_id asc limit ". ($page-1)*$page_size .", ".$page_size;
				}
				else
				{
					$sql = "select * from teacher  where teacher_id not like '0000_' order by teacher_id asc limit ". ($page-1)*$page_size .", ".$page_size;
				}
   				$result = $conn->query($sql);
  				 while ( $info = $result->fetch_array() )
				 {
					 echo "<tr>";
					 echo "<td></td>";
					 echo "<td>".$info['teacher_id']."</td><td>".$info['teacher_name']."</td>";
					 echo "<td><a onclick=\"manage_course('".$info['teacher_id']."','".$info['teacher_name']."')\"><img src=\"image/setting.png\"/>点击管理</a></td>";
					 echo "</tr>";
       			 }
			}
			else
			{
				echo "<tr align=center ;>
			<td colspan=7 height=50px;>无相关数据，请重新输入</td>";
			}
		?> 
        </table> 
        <br />
      	<?php
			if($page>1)
			{
				echo "<a href=?page=".($page-1) .">上一页</a>";
			}
		?>
       
        第
		<select name="page" id="page" onchange="change_page(this)">
        	<?php
			for($i=1;$i<=$page_count;$i++)
			{
				echo "<option value = ".$i.">".$i."</option>";
			}
			?>
        </select>
        <input name="page_hide" type="text" style="display:none" value="<?php echo $page;?>"  />
        页
        <?php
			if($page!=$page_count)
			{
				echo "<a href=?page=".($page+1) .">下一页</a>";
			}
		?>
        
 </div>
 <div id="up" style="display:none; width:410px; height:300px;">
 		<div style="margin-top:30px;" id="_up">
        </div>
        <div id="course">
        </div>
         <div id="update_course";>
         	请修改课程名：<input type="text" name="update_course_name" class="input_text"/>
            <br />
            <br />
            <input type="button" value="修改" onclick="update_course_ture()"  class="button"/>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="返回" onclick="update_course_cancel()"  class="button"/>
        </div>
        <div id="add_course">
            请输入课程名：<input type="text" name="course_name" class="input_text"/><br />
            请输入学时数：<input type="text" name="course_hour" class="input_text" />
            <input type="button" value="添加" onclick="add_course()"  class="button"/>
            <input type="text" style="display:none" name="teacher_id" />
            <input type="text" style="display:none" name="course_id" />
        </div>
        <div>
        <br />
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="确定" onclick="click_Cancel()"  class="button"/>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="返回" onclick="click_Cancel()"  class="button"/>
   		</div>
 </div>
 <div id="mask">
 </div>
 </form>
</body>
<script>
function select_ini_byValue(select_name,select_value)
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
select_ini_byValue("page",document.form.page_hide.value);
function change_page(obj)
{
	var page = document.form.page.options[document.form.page.selectedIndex].value;
	window.location.href="?page="+page;
}
function click_up()
{
	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.8'},200);
	$('#up').fadeIn(200);
}
function click_Cancel()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#up').fadeOut(200);
}
function add_course()
{
	course_name = document.form.course_name.value;
	course_hour = document.form.course_hour.value;
	if(course_name=="")
	{
		alert("请输入课程名");
		document.form.course_name.focus();
	}
	else if(course_hour=="")
	{
		alert("请输入学时");
		document.form.course_hour.focus();
	}
	else
	{
	$.ajax({
		type:'POST',
		url:'../teacher/teacher_management_course_id.ajax.php',
		success: function(msg2)
		{
			document.form.course_id.value=msg2;			
			teacher_id = document.form.teacher_id.value;
			course_id = document.form.course_id.value;
			//alert(course_id);
			$.ajax({
				type:"POST",
				url:"add_course.ajax.php",
				data:"teacher_id="+teacher_id+"&course_name="+course_name+"&course_hour="+course_hour+"&course_id="+course_id,
				success: function(msg)
				{
					if(msg==1)
					{
						update_courseInfo_innerHTML(teacher_id);
						
					}
					else
					{
						alert("添加失败");
					}
				}
				});
	}
	});
  }
}
function delete_course(course_id,obj)
{
	var temp = confirm("确定删除吗？该操作将会删除与该课程相关的所有排课信息");
	if(temp)
	{
		$.ajax({
			type:"POST",
			url:"delete_course.ajax.php",
			data:"course_id="+course_id,
			success: function(msg)
			{
				//alert(msg);
				if(msg==1)
				{
					//alert(course_id+course_name);
					update_courseInfo_innerHTML(document.form.teacher_id.value);
				}
				else
				{
					alert("删除失败");
				}
			}
			
			});
		
		//obj.style.display="none";
	}
}
//更新课程信息的脚本函数
function update_courseInfo_innerHTML(teacher_id)
{
	$.ajax({
		type:"POST",
		url:"select_course.ajax.php",
		data:"teacher_id="+teacher_id,
		success: function(msg)
		{
			//var msg = { "course": [{"course_id": "00000001","course_name":"数据库"},{"course_id": "00000014","course_name":"数据结构"},]};
			eval("data="+msg);
			var len = data.course.length;
			var course_str="";
				for(var i=0;i<len;i++)
				{
					course_str+="<span>&nbsp;&nbsp;"+data.course[i].course_name+"&nbsp;<img title='修改' src='image/update.png' onclick=\"update_course('"+data.course[i].course_id+"','"+data.course[i].course_name+"',this)\"/>&nbsp;<img title='删除'  alt=\"删除\" src=image/cancel.png width=\"16px\"; onclick=\"delete_course('"+data.course[i].course_id+"',this)\" />&nbsp;&nbsp;</span>"; 
				}
				document.getElementById("course").innerHTML ="课程名："+course_str;
			//	alert(data.course[0].course_id);
		}
		
		});
}
function manage_course(teacher_id,teacher_name)
{
	click_up();
	document.form.teacher_id.value=teacher_id;
	document.getElementById("_up").innerHTML="教师号："+teacher_id+"<br/>教师名："+teacher_name;
	update_courseInfo_innerHTML(teacher_id);
}
function update_course(course_id,course_name,obj)
{
	//alert(course_id+obj.src);
	document.getElementById("update_course").style.display="block";
	document.form.course_id.value=course_id;
	document.form.update_course_name.value=course_name;
	document.form.update_course_name.focus();
}
function update_course_cancel()
{
	document.getElementById("update_course").style.display="none";
}
function update_course_ture()
{
	var course_id = document.form.course_id.value;
	var course_name=document.form.update_course_name.value;
	//alert(course_id+course_name);
	$.ajax({
		type:"POST",
		url:"update_course.ajax.php",
		data:"course_name="+course_name+"&course_id="+course_id,
		success:function(msg)
		{
			//alert(msg);
			if(msg==1)
			{
				alert("您未修改任何信息");
			}
			else if(msg==2)
			{
				update_courseInfo_innerHTML(document.form.teacher_id.value);
				document.getElementById("update_course").style.display="none";
				//脚本更新课程信息
				
				
			}
			else
			{
				alert("修改失败");
				document.getElementById("update_course").style.display="none";
			}
		}
		
		});
}
function so_teacher_name()
{
	//if(!(document.form.select_teacher_name.value=="请输入教师名"))
		window.location.href="?teacher_name="+document.form.select_teacher_name.value;
}
function xxx()
{
	//document.form.select_teacher_name.style.border="1px solid #F48C12";
	document.getElementById("tips_input_tName").style.display="none";
	document.form.select_teacher_name.focus();
}
function yyy()
{
	//document.form.select_teacher_name.style.color="#999";
	//document.form.select_teacher_name.style.border="1px solid #CCC"
	document.getElementById("tips_input_tName").style.display="inline";
}
</script>
</html>