<?php
	session_start();
	$teacher_id = $_SESSION['teacher_id'];
	
	include '../include/conn.php';
        $old_password = md5(DB::CheckInput($_POST['old_password']));
	$new_password = md5(DB::CheckInput($_POST['new_password']));
	
	
	$sql = 'SELECT * FROM teacher WHERE teacher_id = \''.$teacher_id.'\' AND teacher_psw = \''.$old_password.'\'';
	
	$result = $conn->query($sql);
	if($result)
	{
		$info = $result->fetch_array();
		if($info)
		{
			$sql = 'UPDATE teacher SET teacher_psw = \''.$new_password.'\' WHERE teacher_id = \''.$teacher_id.'\'';
			$update_result = $conn->query($sql);
			if($update_result)
			{
				echo '2';	//RIGHT PASSWORD & MOD
			}
			else
			{
				echo '3';	//RIGHT PASSWORD & UNMOD	
			}
		}
		else
		{
			echo '1';	//WRONG PASSWORD
		}
	}
	else
	{
		echo '0';	//数据库访问出错	
	}
?>