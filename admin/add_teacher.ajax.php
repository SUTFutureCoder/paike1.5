<?php
	include "../include/conn.php";
	$teacher_id = DB::CheckInput($_POST['teacher_id']);
	$teacher_name = DB::CheckInput($_POST['teacher_name']);
	$teacher_school = DB::CheckInput($_POST['teacher_school']);
	$sql = "SELECT * FROM teacher WHERE teacher_id='$teacher_id'";
	$select_result = $conn->query($sql);
	if($select_result)
	{
		$info = $select_result->fetch_array();
		if($info)
		{
			echo '2';	//2表示查询结果中已存在当前教师号,产生冲突	
		}
		else
		{
			$sql = "INSERT INTO teacher VALUES ('$teacher_id','$teacher_name','$teacher_school','$default_password','1')";
//			echo $sql;
			$insert_result = $conn->query($sql);
//			echo $sql;
//			echo $insert_result;
			$row = $conn->affected_rows;
			if($insert_result)
			{
				echo '1';	
			}
			else
			{
				echo '0';	
			}
		}
	}
	else
	{
		echo '0';	
	}
?>