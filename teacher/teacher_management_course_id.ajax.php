<?php
	include '../include/conn.php';
	
	$sql = 'SELECT course_id FROM course ORDER BY course_id DESC';
	$result = $conn->query($sql);
	if($result)
	{
		$info = $result->fetch_array();
		$largest_course_id = $info['course_id'];
		$add_course_id = sprintf('%08d',$largest_course_id+1);
		echo ''.$add_course_id.'';
	}
	else
	{
		echo '数据库读取错误,请联系管理员.';
	}
?>