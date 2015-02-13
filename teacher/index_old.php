<?php 
session_start();
if(!isset($_SESSION['teacher_id']))
	header("location:../teacher/index.html");
else
	if($_SESSION['limits'] ==0)
		header("location:../admin/index.php");
include "../include/conn.php"; 
$teacher_id = $_SESSION['teacher_id'];
//	echo $teacher_id;

$sql = "SELECT course_id,course_name FROM course WHERE teacher_id = '$teacher_id'";
$result = $conn->query($sql);
if($result)
{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>教师个人信息管理</title>
<script src="../include/js/Jquery.js"></script>

</head>

<body>
	<a href="schedule.php">课程表</a>
	<div id="info"></div>
	<div id="func">
    	<div id="disp_course">
        	<div class="sub_title">当前课程</div>
            <div class="content" id="current_course">
            	<?php
					while($info = $result->fetch_array())
					{
						echo "<div><div>".$info['course_name']."</div><div style=\"background-color:#f00;\" id=\"".$info['course_id']."\" onClick=\"del(this)\">删除</div></div>";	
					}
				?>
            </div>
        </div>
        <div id="add_course">
        	<div class="sub_title">课程添加</div>
            <div class="content">
            	<table>
                	<tr>
                    	<td>课程号</td>
                        <td>
						<?php 
							$sql = 'SELECT course_id FROM course ORDER BY course_id DESC';
							$result = $conn->query($sql);
							if($result)
							{
								$info = $result->fetch_array();
								$largest_course_id = $info['course_id'];
								$add_course_id = sprintf('%08d',$largest_course_id+1);
								echo '<span id="course_id">'.$add_course_id.'</span>';
							}
							else
							{
								echo '数据库读取错误,请联系管理员.';
							}
						?>
                        </td>
                    </tr>
                    <tr>
                    	<td>课程名</td>
                        <td><input type="text" id="course_name" name="course_name"></td>
                    </tr>
                    <tr>
                    	<td>学时</td>
                        <td><input type="text" id="course_hour" name="course_hour"></td>
                    </tr>
                    <tr>
                    	<td colspan="2"><input type="button" id="add_submit" value="确认添加" onClick="add_course()"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="modify_psw">
        	<div class="sub_title">个人信息修改(空为不修改)</div>
			<div><img src="#" alt="修改教师信息"></div>
            <div><img src="#" alt="修改教师密码"></div>
        </div>
    </div>
    <div id="base_info" class="content">
    	<form name="form">
        <table>
        	<tr>
            	<td>教师名</td>
                <td><input type="text" id="teacher_name" name="teacher_name"></td>
            </tr>
            <tr>
                <td>所在学院</td>
                <td>
                	<select id="school" name="school">
                    	
                    </select>
                </td>
            </tr>
            <tr>
            	<td colspan="2"><input type="button" name="modify_base_submit" value="确认修改" onClick="modify_base_info()"></td>
            </tr>
        </table>
        </form>
    </div>
    <div id="psw_info" class="content">
        <table>
            <tr>
            	<td>原密码</td>
                <td><input type="password" name="old_password" id="old_password"></td>
            </tr>
            <tr>
            	<td>新密码</td>
                <td><input type="password" name="new_password" id="new_password"></td>
            </tr>
            <tr>
            	<td>确认新密码</td>
                <td><input type="password" name="confirm_new_password" id="confirm_new_password"></td>
            </tr>
            <tr>
            	<td colspan="2"><input type="button" name="modify_psw_submit" value="确认修改" onClick="modify_psw_info()"></td>
            </tr>
        </table>
    </div>
</body>
<script src="../include/js/school_major_class.js"></script>
<script>
function del(element)
{
//	alert('- -!');
//	document.getElementById('add_course').parentNode.removeChild(document.getElementById('add_course'));
	$.ajax(
		{
			type:'POST',
			url:'teacher_management.ajax.php',
			data:'course_id='+element.id,
			success: function(msg){
				if(msg == 1)	//删除成功
				{
					alert('删除成功');
					element.parentNode.parentNode.removeChild(element.parentNode);
					$.ajax(
						{
							type:'POST',
							url:'teacher_management_course_id.ajax.php',
							success: function(msg2){
								document.getElementById('course_id').innerHTML = msg2;
							}	
						}
					);
				}
				else if(msg == 0)
				{
					alert('数据库删除错误,请联系管理员.');
				}	
			}
		}
	);
}
function add_course()
{
	var course_id = document.getElementById('course_id').innerHTML;
	var course_name = document.getElementById('course_name').value;
	var course_hour = document.getElementById('course_hour').value;
//	alert(course_id+' '+course_name+' '+course_hour);
	$.ajax(
		{
			type:'POST',
			url:'teacher_management_add_course.ajax.php',
			data:'course_id='+course_id+'&course_name='+course_name+'&course_hour='+course_hour,
			success: function(msg){
				if(msg == 1)
				{
					alert('添加成功.');
					var course_div = document.createElement('div');
					course_div.innerHTML = '<div>'+course_name+'</div><div style=\"background-color:#f00;\" id=\"'+course_id+'\" onClick=\"del(this)\">删除</div>';
					document.getElementById('current_course').appendChild(course_div);
					$.ajax(
						{
							type:'POST',
							url:'teacher_management_course_id.ajax.php',
							success: function(msg2){
								document.getElementById('course_id').innerHTML = msg2;
							}	
						}
					);
				}
				else
				{
					alert('数据库写入错误,请联系管理员.');	
				}
			}	
		}
	);	
}
function modify_base_info()
{
	var teacher_name = document.getElementById('teacher_name').value;
	var teacher_school_num = document.getElementById('school').selectedIndex;
	var teacher_school = document.getElementById('school').options[teacher_school_num].text;
//	alert(teacher_school);
	if(teacher_name == '' && teacher_school_num == 0)
	{
		alert('您未修改任何信息.');
	}
	else if(teacher_name != '' && teacher_school_num == 0)
	{
		$.ajax(
			{
				type:'POST',
				url:'teacher_management_mod_tea_info.ajax.php',
				data:'teacher_name='+teacher_name+'&teacher_school='+teacher_school+'&teacher_school_num='+teacher_school_num,
				success: function(msg){
					alert(msg);
					document.getElementById('teacher_name').value = '';
					document.getElementById('school').options[0].selected = true;
					if(msg == 2)
					{
						alert('教师名已更新.');
					}
					else if(msg == 1)
					{
						alert('输入同以前相同');	
					}
					else
					{
						alert('数据库写入出错,请联系管理员.');	
					}
				}	
			}
		);
	}
	else if(teacher_name == '' && teacher_school_num != 0)
	{
		$.ajax(
			{
				type:'POST',
				url:'teacher_management_mod_tea_info.ajax.php',
				data:'teacher_name='+teacher_name+'&teacher_school='+teacher_school+'&teacher_school_num='+teacher_school_num,
				success: function(msg){
					alert(msg);
					document.getElementById('teacher_name').value = '';
					document.getElementById('school').options[0].selected = true;
					if(msg == 2)
					{
						alert('所在学院已更新.');
					}
					else if(msg == 1)
					{
						alert('输入同以前相同');	
					}
					else
					{
						alert('数据库写入出错,请联系管理员.');	
					}
				}	
			}
		);		
	}
	else if(teacher_name != '' && teacher_school_num != 0)
	{
		$.ajax(
			{
				type:'POST',
				url:'teacher_management_mod_tea_info.ajax.php',
				data:'teacher_name='+teacher_name+'&teacher_school='+teacher_school+'&teacher_school_num='+teacher_school_num,
				success: function(msg){
					alert(msg);
					document.getElementById('teacher_name').value = '';
					document.getElementById('school').options[0].selected = true;
					if(msg == 2)
					{
						alert('教师名和学院已更新.');
					}
					else if(msg == 1)
					{
						alert('输入同以前相同');	
					}
					else
					{
						alert('数据库写入出错,请联系管理员.');	
					}				
				}	
			}
		);
	}
}
function modify_psw_info()
{
	var old_password = document.getElementById('old_password').value;
	var new_password = document.getElementById('new_password').value;
	var confirm_new_password = document.getElementById('confirm_new_password').value;
	
	if(old_password == '' || new_password == '' || confirm_new_password == '')
	{
		alert('所填信息不完全,请补全空缺信息.');	
	}
	if(new_password == confirm_new_password)
	{
		$.ajax(
			{
				type:'POST',
				url:'teacher_management_mod_tea_psw.ajax.php',
				data:'old_password='+old_password+'&new_password='+new_password,
				success: function(msg){
					if(msg == 0)
					{
						alert('数据库写入错误,请联系管理员.');	//查询出错
					}
					else if(msg == 1)
					{
						alert('原密码错误,请确认填写信息.');	
					}
					else if(msg == 2)
					{
						alert('密码修改成功,请牢记新密码.');	
					}
					else if(msg == 3)
					{
						alert('数据库写入错误,请联系管理员.');	//密码正确,修改出错
					}
				}	
			}
		);
	}
	else
	{
		alert('新密码同确认密码不符,请确认所填信息.');	
	}
}
</script>
</html>
<?php
	}
	else
	{
		echo '0';	
	}
?>