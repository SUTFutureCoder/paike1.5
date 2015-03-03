<?php
	include '../include/conn.php';
	$teacher_id = DB::CheckInput($_POST['teacher_id']);
	$course_id = DB::CheckInput($_POST['course_id']);
	$course_name = DB::CheckInput($_POST['course_name']);
	$course_hour = DB::CheckInput($_POST['course_hour']);

	$sql = 'INSERT INTO course VALUES (\''.$course_id.'\',\''.$teacher_id.'\',\''.$course_name.'\',\''.$course_hour.'\')';
	$conn->query($sql);
	if($conn->affected_rows)
	{
		echo '1';
	}
	else
	{
		echo '0';	
	}
?>