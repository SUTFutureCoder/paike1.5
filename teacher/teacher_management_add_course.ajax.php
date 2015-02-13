<?php
	session_start();
	
	include '../include/conn.php';
	
        $teacher_id = $_SESSION['teacher_id'];
	$course_id = DB::CheckInput($_POST['course_id']);
	$course_name = DB::CheckInput($_POST['course_name']);
	$course_hour = DB::CheckInput($_POST['course_hour']);
	
	$sql = 'INSERT INTO course VALUES (\''.$course_id.'\',\''.$teacher_id.'\',\''.$course_name.'\',\''.$course_hour.'\')';
	$result = $conn->query($sql);
	if($result)
	{
		echo '1';
	}
	else
	{
		echo '0';	
	}
?>