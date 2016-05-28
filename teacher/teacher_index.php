<?php
	session_start();
	if(!isset($_SESSION['teacher_id']))
		header("location:../teacher/index.php");
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
<script src="js/jquery.animate.js"></script>
<link href="css/teacher_management.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="contest">
    	<div class="header_fyw">
    		<div class="header_text">
            	<ul>
            		<li><a href="../index.php" class="header_first" style="margin-left:40px;">首页</a></li>
                    <li><a href="schedule.php" class="header_first">机房课程表</a></li>
                    <li><a href="../class_shedule.php" class="header_first">班级课程表</a></li>
                	<li><a href="teacher_index.php" class="header_first">个人中心</a></li>
                	<li><a href="../admin/data_dump.php" target="_BLANK" class="header_first">Excel课表</a></li>
                    <li><a class="header_first" onclick="log_out()">注销</a></li>
                    <li><a style="margin-left:120px; font-size:14px; width:90px;" href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a></li>
                    <li><a style="font-size:14px; width:90px;" href="http://www.sut.edu.cn" class="header_first" target="_blank">工大官网</a></li>
    			</ul>
           	 </div>
            </div>
             <div class="triangle1"></div>
    		<div class="triangle2"></div>
	<div id="header" style="width:100%; height:50px;"></div>
	<div id="info">
    	<div id="teacher_info_container">
        	<div class="sub_title" id="teacher_info">教师信息</div>
            <table id="teacher_info_table" cellspacing="12px">
            	<tr>
                    <td>教师名</td>
                    <td id="teacher_name_disp">
						<?php
							$sql_teacher_info = 'SELECT teacher_name,teacher_school FROM teacher WHERE teacher_id = \''.$teacher_id.'\'';
							$teacher_result = $conn->query($sql_teacher_info);
							$teacher_info = $teacher_result->fetch_array();
							echo $teacher_info['teacher_name'];
						?>
                    </td>
                    <td>所在学院</td>
                    <td id="teacher_school_disp">
						<?php
							echo $teacher_info['teacher_school']; 
						?>
                    </td>
                </tr>
            </table>
        </div>
        <div>
        	<div id="upload_button" onClick="open_u()"><img id="upload_img" src="img/upload.png"></div>
            <div id="schedule_button"><a href="schedule.php"><img id="schedule_img" src="img/schedule.png"></a></div>
        </div>
    </div>
	<div id="func">   	
    <!-- 	<div id="disp_course">
        	<div class="sub_title" id="disp_title">当前课程</div>
            <div class="content" id="current_course">
            	<?php
					//while($info = mysql_fetch_array($result))
					//{
					//	echo "<div><div class=\"course_name\">".$info['course_name']."</div><div class=\"img_container\" id=\"".$info['course_id']."\" onClick=\"del(this)\"><img class=\"del_img\" src=\"img/cancel.png\"></div></div>";	
					//}
				?>
            </div>
        </div>
        <div id="add_course">
        	<div class="sub_title" id="add_title">课程添加</div>
            <div class="content">
            	<table cellspacing="5px">
                	<tr>
                    	<td>课程号</td>
                        <td>
						<?php 
							/*$sql = 'SELECT course_id FROM course ORDER BY course_id DESC';
							$result = mysql_query($sql);
							if($result)
							{
								$info = mysql_fetch_array($result);
								$largest_course_id = $info['course_id'];
								$add_course_id = sprintf('%08d',$largest_course_id+1);
								echo '<span id="course_id">'.$add_course_id.'</span>';
							}
							else
							{
								echo '数据库读取错误,请联系管理员.';
							}
*/						?>
                        </td>
                    </tr>
                    <tr>
                    	<td>课程名</td>
                        <td><input type="text" class="input_text" id="course_name" name="course_name"></td>
                    </tr>
                    <tr>
                    	<td>学时</td>
                        <td><input maxlength="3" type="text" class="input_text" id="course_hour" name="course_hour"></td>
                    </tr>
                    <tr>
                    	<td colspan="2"><input type="button" id="add_submit" class="button" value="确认添加" onClick="add_course()"></td>
                    </tr>
                </table>
            </div>
        </div> -->
        <div id="modify_psw">
        	<div class="sub_title" id="mod_title">个人信息修改<br><font size="+0">(空为不进行修改)</font></div>
			<div id="base_info_div" onClick="open_b()"><img id="base_info_img" src="img/base_info.png" alt="修改教师信息"></div>
            <div id="psw_info_div" onClick="open_p()"><img id="psw_info_img" src="img/psw_info.png" alt="修改教师密码"></div>
        </div>
    </div>
    <div id="base_info" class="content">
    	<div class="sub_title" id="base_info_title">教师信息修改</div>
    	<form name="form">
        <table cellspacing="10px">
        	<tr>
            	<td>教师名</td>
                <td><input type="text" id="teacher_name" class="input_text" name="teacher_name"></td>
            </tr>
            <tr>
                <td>所在学院</td>
                <td>
                	<select id="school" name="school">
                    	
                    </select>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td>
                	<input type="button" class="button" name="cancel_base" id="cancel_base" value="关闭" onClick="cancel_b()">
                    <input type="button" class="button" name="modify_base_submit" value="确认修改" onClick="modify_base_info()">
                </td>
            </tr>
        </table>
        </form>
    </div>
    <div id="psw_info" class="content">
    	<div class="sub_title" id="psw_info_title">教师密码修改</div>
        
        <table cellspacing="7px">
            <tr>
            	<td>原密码</td>
                <td><input type="password" class="psw" name="old_password" id="old_password"></td>
            </tr>
            <tr>
            	<td>新密码</td>
                <td><input type="password" class="psw" name="new_password" id="new_password"></td>
            </tr>
            <tr>
            	<td>确认密码</td>
                <td><input type="password" class="psw" name="confirm_new_password" id="confirm_new_password"></td>
            </tr>
            <tr>
            	<td></td>
            	<td>
                	<input type="button" class="button" name="cancel_psw" id="cancel_psw" value="关闭" onClick="cancel_p()">
                	<input type="button" class="button" name="modify_psw_submit" value="确认修改" onClick="modify_psw_info()">
                </td>
            </tr>
        </table>
    </div>
        <div id="upload_info" class="content">
    	<div class="sub_title" id="upload_info_title">文件上传</div>
        <form id="file_form" action="cloud/upload_file.php" method="post" enctype="multipart/form-data">
        <table cellspacing="7px">
            <tr>
            	<td>课程</td>
                <td>
                	<select name="course" id="course" class="select">
                    </select>
                </td>
            </tr>
            <tr>
            	<td>文件</td>
                <td><input type="file" name="file" id="file"></td>
            </tr>
            <tr>
            	<td></td>
            	<td>
                	<input type="button" class="button" name="cancel_upload" id="cancel_upload" value="关闭" onClick="cancel_u()">
                	<input type="button" class="button" name="confirm_upload" value="确认上传" onClick="check_file()">
                </td>
            </tr>
        </table>
        </form>
    </div>
    <div id="mask"></div>
    <div id="alert"><img id="alert_img" src="img/appbar.check.png"><div id="alert_div"><span id="alert_content"></span></div></div>
    </div>
</body>
<script src="../include/js/school_major_class.js"></script>
<script src="js/teacher_management_layout.js"></script>
<script>
if((screen.width <= 1024) && (screen.height <= 768))
{
	//alert("哈哈");
	document.getElementById("contest").style.left="0";
}
function   isUnsignedInteger(a)
{
    var   reg =/^\d+$/
    return reg.test(a);
}
function confirm_del(element)
{
	alert_custom_ask('确认删除? <div id="yes" onClick="del('+element.id+')"> 确认 </div><div id="no"> 取消 </div>');	
}
function del(element)
{
//	document.getElementById('add_course').parentNode.removeChild(document.getElementById('add_course'));
//	alert(String(element_id));
	$.ajax(
		{
			type:'POST',
			url:'teacher_management.ajax.php',
			data:'course_id='+element.id,
			success: function(msg){
				if(msg == 1)	//删除成功
				{
					alert_custom('删除成功,与该课程相关的所有排课信息都已删除');
					
					element.parentNode.parentNode.removeChild(element.parentNode);
					$.ajax(
						{
							type:'POST',
							url:'teacher_management_course_id.ajax.php',
							success: function(msg2){
								
								$('#course_id').animate({'color':'#FFF'},300,function(){$('#course_id').animate({'color':'#000'},300);document.getElementById('course_id').innerHTML = msg2;});
							}	
						}
					);
				}
				else if(msg == 0)
				{
					alert_custom_error('数据库删除错误,请联系管理员.');
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
	if(course_name == '' || course_hour == '')
	{
		alert_custom_error('请输入完整信息.');
		return;
	}
	if(!isUnsignedInteger(course_hour))
	{
		alert_custom_error('课时输入需为整数.');
	}
	else
	{
		$.ajax(
			{
				type:'POST',
				url:'teacher_management_add_course.ajax.php',
				data:'course_id='+course_id+'&course_name='+course_name+'&course_hour='+course_hour,
				success: function(msg){
					if(msg == 1)
					{
						alert_custom('添加成功.');
						var course_div = document.createElement('div');
						course_div.innerHTML = '<div class=\"course_name\">'+course_name+'</div><div class=\"img_container\" id=\"'+course_id+'\" onClick=\"del(this)\"><img class=\"del_img\" src=\"img/cancel.png\"></div>';
						document.getElementById('current_course').appendChild(course_div);
						$.ajax(
							{
								type:'POST',
								url:'teacher_management_course_id.ajax.php',
								success: function(msg2){
									
									$('#course_id').animate({'color':'#FFF'},300,function(){$('#course_id').animate({'color':'#000'},300);document.getElementById('course_id').innerHTML = msg2;});
									
									$('.del_img').hover(
										function()
										{
											$(this).attr({'src':'img/cancel_active.png'});
										},
										function()
										{
											$(this).attr({'src':'img/cancel.png'});	
										}
									);
								}	
							}
						);
					}
					else
					{
						alert_custom_error('数据库写入错误,请联系管理员.');	
					}
				}	
			}
		);
	}
//	alert(course_id+' '+course_name+' '+course_hour);	
}
function modify_base_info()
{
	var teacher_name = document.getElementById('teacher_name').value;
	var teacher_school_num = document.getElementById('school').selectedIndex;
	var teacher_school = document.getElementById('school').options[teacher_school_num].text;
//	alert(teacher_school);
	if(teacher_name == '' && teacher_school_num == 0)
	{
		alert_custom('您未修改任何信息.');
	}
	else if(teacher_name != '' && teacher_school_num == 0)
	{
		$.ajax(
			{
				type:'POST',
				url:'teacher_management_mod_tea_info.ajax.php',
				data:'teacher_name='+teacher_name+'&teacher_school='+teacher_school+'&teacher_school_num='+teacher_school_num,
				success: function(msg){
//					alert(msg);
					document.getElementById('teacher_name').value = '';
					document.getElementById('school').options[0].selected = true;
					if(msg == 2)
					{
						alert_custom('教师名已更新.');
						cancel_b();
						$.ajax(
							{
								type:'POST',
								url:'teacher_management_query_tea_info.ajax.php',
								success: function(msg)
								{
									var teacher_info = msg.split('@');
									$('#teacher_name_disp').animate({'color':'#FFF'},500,function(){$('#teacher_name_disp').animate({'color':'#606060'},500);document.getElementById('teacher_name_disp').innerHTML = teacher_info[0];});								
								}	
							}
						);
					}
					else if(msg == 1)
					{
						alert_custom('输入同以前相同');
						cancel_b();	
					}
					else
					{
						alert_custom_error('数据库写入出错,请联系管理员.');
						cancel_b();	
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
//					alert(msg);
					document.getElementById('teacher_name').value = '';
					document.getElementById('school').options[0].selected = true;
					if(msg == 2)
					{
						alert_custom('所在学院已更新.');
						cancel_b();
						$.ajax(
							{
								type:'POST',
								url:'teacher_management_query_tea_info.ajax.php',
								success: function(msg)
								{
									var teacher_info = msg.split('@');
									
									$('#teacher_school_disp').animate({'color':'#FFF'},500,function(){$('#teacher_school_disp').animate({'color':'#606060'},500);document.getElementById('teacher_school_disp').innerHTML = teacher_info[1];});	
								}	
							}
						);
					}
					else if(msg == 1)
					{
						alert_custom('输入同以前相同');
						cancel_b();	
					}
					else
					{
						alert_custom_error('数据库写入出错,请联系管理员.');
						cancel_b();	
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
//					alert(msg);
					document.getElementById('teacher_name').value = '';
					document.getElementById('school').options[0].selected = true;
					if(msg == 2)
					{
						alert_custom('教师名和学院已更新.');
						cancel_b();
						$.ajax(
							{
								type:'POST',
								url:'teacher_management_query_tea_info.ajax.php',
								success: function(msg)
								{
									var teacher_info = msg.split('@');
									
									
									$('#teacher_name_disp').animate({'color':'#FFF'},500,function(){$('#teacher_name_disp').animate({'color':'#606060'},500);document.getElementById('teacher_name_disp').innerHTML = teacher_info[0];});
									$('#teacher_school_disp').animate({'color':'#FFF'},500,function(){$('#teacher_school_disp').animate({'color':'#606060'},500);document.getElementById('teacher_school_disp').innerHTML = teacher_info[1];});
								}	
							}
						);
					}
					else if(msg == 1)
					{
						alert_custom('输入同以前相同');
						cancel_b();	
					}
					else
					{
						alert_custom_error('数据库写入出错,请联系管理员.');
						cancel_b();	
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
		alert_custom_error('所填信息不完全,请补全空缺信息.');	
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
						alert_custom_error('数据库写入错误,请联系管理员.');	//查询出错
						cancel_p();
					}
					else if(msg == 1)
					{
						alert_custom_error('原密码错误,请确认填写信息.');	
					}
					else if(msg == 2)
					{
						alert_custom('密码修改成功,请牢记新密码.');	
						cancel_p();
					}
					else if(msg == 3)
					{
						alert_custom_error('数据库写入错误,请联系管理员.');	//密码正确,修改出错
						cancel_p();
					}
				}	
			}
		);
	}
	else
	{
		alert_custom_error('新密码同确认密码不符,请确认所填信息.');	
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