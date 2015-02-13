<?php
	include '../include/conn.php';
        $teacher_id = DB::CheckInput($_POST['teacher_id']);
	$sql = "UPDATE teacher SET teacher_psw = '".$default_password."' WHERE teacher_id = '".$teacher_id."'";
	//echo $sql;
	$result = $conn->query($sql);
	if($result)
	{
		echo '1';	//RIGHT PASSWORD & MOD
	}
	else
	{
		echo '0';	//RIGHT PASSWORD & UNMOD	
	}
?>