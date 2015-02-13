<?php
include "../include/conn.php";
$sql = "UPDATE `teacher_sj_schedule` SET `course_id`='00000000',`course_class`='',`lock`='1',tips='' WHERE time_add = '" . DB::CheckInput($_POST['time_add']) . "'";
$conn->query($sql);
if($conn->affected_rows())
{
	echo '1';
}
else
	echo '0';

?>