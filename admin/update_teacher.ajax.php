<?php
	include '../include/conn.php';
        
        $teacher_id = DB::CheckInput($_POST['teacher_id']);
	$teacher_name = DB::CheckInput($_POST['teacher_name']);
	$teacher_school = DB::CheckInput($_POST['teacher_school']);
        
	$sql = 'UPDATE teacher SET teacher_school = \''.$teacher_school.'\' , teacher_name = \''.$teacher_name.'\' WHERE teacher_id = \''.$teacher_id.'\'';
	$result = $conn->query($sql);
	if($result)
	{
		$row = $conn->affected_rows;
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