<?php
include "../include/conn.php";
$user = DB::CheckInput($_POST['admin_user']);
$psw = DB::CheckInput($_POST['admin_psw']);

$sql="select *from admin where admin_user='$user'";

$result = $conn->query($sql);

if ($result)
{
	$info = $result->fetch_array();
	if ($info)
	{
		if($info['admin_psw']==md5($psw))
		{
			echo '1';
		}
		else
			echo '0';
	}
	else
		'0';
}
else
	echo '0';
?>