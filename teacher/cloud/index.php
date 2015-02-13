<?php
session_start();
include "../../include/conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传</title>
</head>
<body>

<form action="upload_file.php" method="post" enctype="multipart/form-data">
课程:&nbsp;&nbsp;<select name="course" id="course">
	<option value="" selected="selected">==请选择课程==</option>
	<?php
	//动态生成老师对应课课程
	$sql = "select * from course where teacher_id = '".$_SESSION['teacher_id']."'";
	$result1 = $conn->query($sql);
	while($info1 = $result1->fetch_array())
	{
		if($info1[2]!="点此排课")
		echo "<option value=$info1[0]>$info1[2]</option>";
	} 
	?>
	</select>
	<p>
<label for="file">文件:</label>
<input type="file" name="file" id="file" /> 
<p>
<input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>



