<?php
	session_start();
	include "../include/conn.php";
	$sql = "SELECT * FROM teacher WHERE teacher_id = '" . DB::CheckInput($_POST['teacher_id']) . "'";
	$rezult = $conn->query($sql);
	if($rezult)
	{
		$info = $rezult->fetch_array();
		if($info)
		{
			$psw=MD5(DB::CheckInput($_POST['teacher_psw']));
			if($info['teacher_psw']==$psw)
			{
				$_SESSION['teacher_id']=$info['teacher_id'];
				$_SESSION['teacher_name'] = $info['teacher_name'];
				$_SESSION['limits'] = $info['limits'];
				//mysql_free_result($rezult);
				if($info['limits']=='1')
					echo '1';
				else if($info['limits']=='0')
					echo '2';
				else
					echo '0';
			}
			else
				echo '0';
		}
		else
			echo '0';
	}
	else
		echo '0';
?>