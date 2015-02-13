<?php
	session_start();
	$teacher_id = $_SESSION['teacher_id'];
	
	include '../include/conn.php';
	
	$sql = 'SELECT course_id,course_name FROM course WHERE teacher_id = \''.$teacher_id.'\'';
	
	$result = $conn->query($sql);
	
	if($result)
	{
		echo '<option value="00000000" selected>==请选择课程==</option>';
		while($info = $result->fetch_array())
		{
			if($info['course_name'] != '点此排课')
			{
				echo '<option value="'.$info['course_id'].'">'.$info['course_name'].'</option>';	
			}	
		}		
	}
	else
	{
		echo '数据库访问错误.';
	}
?>