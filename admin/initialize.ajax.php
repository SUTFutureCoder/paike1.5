<?php
set_time_limit(0);
include "../include/conn.php";
$id = DB::CheckInput($_POST['year_term_school_address']);

$year_term = DB::CheckInput($_POST['year_term']);
$address = DB::CheckInput($_POST['address']);
$school = DB::CheckInput($_POST['school']);
$school_id = DB::CheckInput($_POST['school_id']);
$sql1 = "INSERT INTO `ini_year_term` (`year_term`) VALUES('$year_term')";
$conn->query($sql1);
$sql2 = "INSERT INTO `ini_school`(`school`,school_id) VALUES ('$school','$school_id')";
$conn->query($sql2);
$sql3 = "INSERT INTO `ini_address`(`address`) VALUES ('$address')";
$conn->query($sql3);
$sql = "";
for($i = 1;$i<=20;$i++)
{
	for($j = 1;$j<=5;$j++)
	{
		for($k = 1;$k<=7;$k++)
		{
			if($i<=9)
				$add_time = $id.'0'.$i.$j.$k;
			else
				$add_time = $id.$i.$j.$k;
			$sql=$sql."(".$add_time."),";
		}
	}
}

$sql = substr($sql,0,-1);
$sql = "INSERT INTO `teacher_sj_schedule`(`time_add`) VALUES".$sql;
$conn->query($sql);
if($conn->affected_rows == -1)
{
	echo '0';
}
else 
	echo '1';
?>