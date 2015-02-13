<?php
include "../include/conn.php";

$course_id = DB::CheckInput($_POST['course_id']);
$time_add = DB::CheckInput($_POST['time_add']);
$course_class = DB::CheckInput($_POST['student_id']);
$tips = DB::CheckInput($_POST['tips']);

$sql1="UPDATE teacher_sj_schedule SET course_id = '$course_id',course_class='$course_class',`lock`='0',tips='$tips' WHERE time_add = '$time_add' AND `lock`='1'";
$conn->query($sql1);
$row = $conn->affected_rows();
		//echo $sql1."fanyiwei".$row;
if($row)
{
	echo '1';
}
else
	echo '0';
?>