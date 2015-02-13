<?php
session_start();
	include "../include/conn.php";
	$id = DB::CheckInput($_POST['time_add']);
	$sql = "select * from teacher_sj_schedule where substr(time_add,1,12) = '$id'";
	$result = $conn->query($sql);
	//编辑专业班级字符串，若已在字符串里存在则直接加班级，不加专业，若不存在，则加专业班级；参数1代表专业，参数2代表班级，参数3代表要处理的字符串
	function major_class($major,$class,$return)
	{
		$len = strpos($return,$major);
		//echo "len = ".$len;
		if(!$len)
		{
			$return = $return.' '.$major.'['.$class.']';
		}
		else
		{
			$cnt = strlen($major);
			$left = substr($return,0,$len+$cnt+6);
			$right = substr($return,$len+$cnt+6);
			//echo "left = ".$left."<br>right = ".$right;
			$return = $left.'['.$class.']'.$right;
		}
		//echo "<br>".$return;
		return $return ;
	}
	if ($result)
	{
		while($info = $result->fetch_array ())
		{
			$sql1 = "select * from course where course_id = '$info[1]'";//获取课程名及教师号
			$result1 = $conn->query($sql1);
			if($result1 && $info1 = $result1->fetch_array())
			{
				
				$sql2 = "select * from teacher where teacher_id = '$info1[1]'";//获取教师名
				$result2 = $conn->query($sql2);
				if($result2 && $info2 = $result2->fetch_array())
				{
					$class_array = explode('@',$info['course_class']);//班级信息分割成数组
					//编辑专业班级字符串
					$class = "";
					for($i= 0;$i<count($class_array);$i++)
					{
						$sql3 = "select student_major from student_information where student_number = substr($class_array[$i],1,6)";//获取专业班级
						$result3 = $conn->query($sql3);
						if($result3)
						{
							$info3 = $result3->fetch_array();
							$class = major_class($info3['student_major'],substr($class_array[$i],0,2).'0'.substr($class_array[$i],6,1),$class);
							//$class = $info3['student_major'].substr($class_array[0],0,2).'0'.substr($class_array[0],6,1);
						}	
					}
					echo $info['lock'];
					echo "<div class=\"course_text\">教师:".$info2['teacher_name']."</div>";
					echo "<div class=\"course_text\">课程:".$info1['course_name']."</div>";
					echo "<div class=\"course_text\">".$class."</div>";
					echo "<div class=\"course_text\">备注:".$info['tips']."</div>";
					echo "@";
				}
				else
				{
					echo 'error';
				}
			}
			else
			{
					echo 'error';
			}
		}
	}
	else
		echo 'error';
?>