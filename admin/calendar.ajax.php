<?php
	include "../include/conn.php";
	
	$sql = "UPDATE `calendar` SET `calendar_year`=" . DB::CheckInput($_POST['calendar_year']) . ",`calendar_month`=" . DB::CheckInput($_POST['calendar_month']) . ",`calendar_day`=" . DB::CheckInput($_POST['calendar_day']) . " WHERE 1";
	//echo $sql;
	
	if($conn->query($sql))
	{
		echo '1';
	}
	else
		echo '0';
?>