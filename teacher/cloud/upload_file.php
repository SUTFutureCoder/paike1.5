<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	include '../../include/conn.php';
	$filename = $_FILES['file']['name'];
	//$filename = iconv("utf-8","gbk",$filename);
	$filename_sql =$filename;//iconv('gbk','utf-8',$filename);
	$_FILES['file']['name'] = $filename;
	if($_FILES['file']['type'] != 'application/x-msdownload')
	{
		if($_FILES['file']['error'] > 0)
		{
			echo '<script>alert(\'ERROR CODE : '.$_FILES['file']['error'].'\');</script>';	
		}
		else
		{
			if(file_exists('../../downloads/'.$filename))
			{
				echo '<script>alert(\'该文件名已存在,上传失败.\');</script>';
			}
			else
			{
				$max_size = 10*(2<<20);
				if($_FILES['file']['size'] >= $max_size)
				{
					echo '<script>alert(\'上传文件过大,上传失败.\');</script>';	
				}
				else
				{
					move_uploaded_file($_FILES['file']['tmp_name'],'../../downloads/'.$filename);
					$sql = "INSERT INTO `file`(`teacher_id`, `course_id`, `file_name`, `file_type`) VALUES ('" . $_SESSION['teacher_id'] . "','" . DB::CheckInput($_POST['course']) . "','".$filename_sql."','".$_FILES['file']['type']."')";
					$conn->query($sql);
					if($conn->affected_rows())
					{
						echo '<script>alert(\'上传成功.\');</script>';	
					}
					else
					{
						echo '<script>alert(\'上传失败.\');</script>';	
					}
				}
			}	
		}
	}
	else
	{
		echo '<script>alert(\'不允许上传该格式,上传失败.\');</script>';	
	}
	echo '<script>window.history.back();</script>';
?>