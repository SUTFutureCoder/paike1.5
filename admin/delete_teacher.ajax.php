<?php
include "../include/conn.php";
$teacher_id = DB::CheckInput($_POST['teacher_id']); 
$sql = "DELETE FROM `teacher` WHERE teacher_id = '$teacher_id'";
$sql_sj = "UPDATE `teacher_sj_schedule` SET `course_id`='00000000',`course_class`='',`lock`='1',`tips`='' WHERE course_id in (select course_id from course where teacher_id = ".$teacher_id.")";
//echo $sql;
$conn->query($sql);
if($conn->affected_rows)
{
	$conn->query($sql_sj);
	//echo mysql_affected_rows()."<br>";
	echo '1';
}
else
	echo '0';

?>