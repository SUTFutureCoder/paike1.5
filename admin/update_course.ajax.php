<?php
	include '../include/conn.php';
        $course_id = DB::CheckInput($_POST['course_id']);
	$course_name = DB::CheckInput($_POST['course_name']);
	$sql = 'UPDATE course SET course_name = \''.$course_name.'\' WHERE course_id = \''.$course_id.'\'';
	$result = $conn->query($sql);
	if($result)
	{
		$row = $conn->affected_rows();
//		echo $row;
		if($row)
		{
			echo '2';	//已更新
		}
		else
		{
			echo '1';	//同以前相同
		}
	}
	else
	{
		echo '0';	//出错
	}
?>