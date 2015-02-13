<?php
	include '../include/conn.php';
        $course_id = DB::CheckInput($_POST['course_id']);
	$sql = 'DELETE FROM course WHERE course_id = '.$course_id;
	$result = $conn->query($sql);
	$sql_sj = "UPDATE `teacher_sj_schedule` SET `course_id`='00000000',`course_class`='',`lock`='1',`tips`='' WHERE course_id=".$course_id;
	$conn->query($sql_sj);
	if($result)
	{
		echo '1';	
	}
	else
	{
		echo '0';	
	}
?>