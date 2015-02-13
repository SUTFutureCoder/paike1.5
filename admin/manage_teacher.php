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
<title>教师管理</title>
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
        	<td></td>
            <td></td>
        	<td>教师号</td>
            <td>教师名</td>
            <td>所在院</td>
            <td></td>
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
					 echo "<td><a onclick=update_teacher('".$info['teacher_id']."','".$info['teacher_name']."','".$info['teacher_school']."')><img src='image/update.png' alt='.'/>修改</a></td>";
					 echo "<td><a onclick=delete_teacher('".$info['teacher_id']."')><img src='image/delete.png' alt='.'/>删除</a></td>";
					 echo "<td>".$info['teacher_id']."</td><td>".$info['teacher_name']."</td><td>".$info['teacher_school']."</td>";
					 
					 echo "<td><a onclick=update_psw('".$info['teacher_id']."')><img src='image/lock.jpg' alt='.' width='16px'/>重置密码</a></td>";
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
 <div id="up"; style="display:none; width:400px; height:250px;">
 	<div style=" margin-left:40px;">
 		<br />
        <br />
        请输入教师名：&nbsp;&nbsp;
        <input type="text" name="teacher_name" class="input_text"/>
        <br />
        <br />
        请选择所在院：&nbsp;&nbsp;
        <select id="school" name="school">
        </select>
        <input type="text" name="teacher_id" style="display:none"/>
        <br />
        <br />
 		&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="确定" onclick="update_teacher_ajax()"  class="button"/>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="返回" onclick="click_Cancel()"  class="button"/>
    </div>
 </div>
 <div id="mask">
 </div>
 </form>
</body>
<script src="../include/js/school_major_class.js"></script>
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
function select_ini_byText(select_name,select_text)
{
	var s = document.getElementById(select_name);  
    var ops = s.options;  
    for(var i=0;i<ops.length; i++)
	{  
        var tempText = ops[i].text;  
        if(tempText == select_text)  
        {  
            ops[i].selected = true;  
        }  
    }  
}
select_ini_byValue("page",document.form.page_hide.value);
//document.form.select_teacher_name.value="请输入教师名";
//document.form.select_teacher_name.focus();
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
function update_teacher(teacher_id,teacher_name,teacher_school)
{
	click_up();
	document.form.teacher_name.focus();
	document.form.teacher_name.value=teacher_name;
	document.form.teacher_id.value=teacher_id;
	select_ini_byText("school",teacher_school);//设置原来的学院
	
}
function update_teacher_ajax()
{
	var teacher_id = document.form.teacher_id.value;
	var teacher_name = document.form.teacher_name.value;
	var teacher_school = document.form.school.options[document.form.school.selectedIndex].text;
	//alert(teacher_id + teacher_name + teacher_school);
	
	$.ajax({
		type:'POST',
		url:'update_teacher.ajax.php',
		data:'teacher_name='+teacher_name+'&teacher_school='+teacher_school+'&teacher_id='+teacher_id,
		success: function(msg)
		{
			if(msg==1)
			{
				alert("您未修改任何信息");
				click_Cancel();
			}
			else if(msg==2)
			{
				alert("修改成功");
				click_Cancel();
				location.reload();
			}
			else
			{
				alert("修改失败");
				click_Cancel();
				location.reload();
			}
		}
	});
	//alert(document.form.teacher_id.value)	
}
function delete_teacher(teacher_id)
{
	var temp = confirm("确定删除吗？该操作将会删除教师所有排课信息");
	if(temp)
	{
		$.ajax({
			type:'POST',
			url:"delete_teacher.ajax.php",
			data:"teacher_id="+teacher_id,
			success: function(msg)
			{
				//alert(msg);
				if(msg==1)
				{
					alert("删除成功");
					location.reload();
				}
				else
					alert("删除失败");
			}
			});
		
	}
	//alert(teacher_id);
}

function update_psw(teacher_id)
{
	if(confirm("确定重置密码为：000000吗？"))
	{
		$.ajax({
			type:"POST",
			url:"update_teacher_psw.ajax.php",
			data:"teacher_id="+teacher_id,
			success:function(msg)
			{
				//alert(msg);
				if(msg==1)
				{
					alert("重置成功");
				}
				else
				{
					alert("重置失败");
				}
			}
			});
	}
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