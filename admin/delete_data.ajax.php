<?php
include "../include/conn.php";
$time_add = DB::CheckInput($_POST['time_add']); 
$time_add = $time_add.'____';
$sql = "DELETE FROM `teacher_sj_schedule` WHERE time_add like '$time_add'";
//echo $sql;
$conn->query($sql);
//echo mysql_affected_rows()."<br>";
if($conn->affected_rows)
{
	echo '1';
}
else
	echo '0';

?>