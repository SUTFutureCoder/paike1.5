<?php
	include "../include/conn.php";
	$course_id = DB::CheckInput($_POST['course_id']);
	$time_add = DB::CheckInput($_POST['time_add']);
	$course_class = DB::CheckInput($_POST['student_id']);
	$tips = DB::CheckInput($_POST['tips']);
	//处理任选课情况
	if($course_class!="")
	{
		//截取字符串，处理不同地点同一班级有课情况
		$year = substr($time_add,0,5);
		$week_time = substr($time_add,10,4);
		$time_add2 = $year.'_____'.$week_time;
	
		//$sql = "SELECT * FROM `teacher_sj_schedule` WHERE time_add like '20131_____0111' AND course_class like '%".$course_class."%'";
		$sql = "SELECT * FROM `teacher_sj_schedule` WHERE time_add like '$time_add2' AND course_class like '%".$course_class."%'";
		$result = $conn->query($sql);
		if($result)
		{
			$info = $result->fetch_array();
			if($info)
			{
				echo  '2';
			}
			else	
			{
				$sql1="UPDATE teacher_sj_schedule SET `course_id` = '$course_id',`course_class`=concat(`course_class`,'$course_class@'),`lock`='2',tips='$tips' WHERE `time_add` = '$time_add' AND (`lock`=1 or `course_id`='$course_id')";
				$conn->query($sql1);
				$row = $conn->affected_rows();
				//echo $sql1."fanyiwei".$row;
				if($row)
				{
					echo '1';
				}
				else
					echo '0';
			}
		}
		else
			echo 0;
			
	}
	//如果是任选课
	else
	{
		$sql1="UPDATE teacher_sj_schedule SET course_id = '$course_id',`lock`='2',tips='$tips' WHERE time_add = '$time_add' AND (`lock`=1 or `course_id`='$course_id')";
		$conn->query($sql1);
		$row = $conn->affected_rows();
				//echo $sql1."fanyiwei".$row;
		if($row)
		{
			echo '1';
		}
		else
			echo '0';
	}
?>