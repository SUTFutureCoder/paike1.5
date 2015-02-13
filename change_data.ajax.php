<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
td{
	width:200px;
	height:50px;
	border:1px solid #000000;
}
table
{
	border-collapse:collapse;
	font-size:15px;
}
.course_text{
	margin-left:10px;
	margin-top:2px;
	cursor:pointer;
}
</style>
<?php
session_start();
	include "include/conn.php";
?>

<?php
	//一些变量
	 $id="201320420520";
	 $week = substr($id,10,2);
	 $week = $week>9?$week:substr($week,1,1);
?>
<?php
	//一些函数
	
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
	$time_array = array();	
	function rili($year,$month,$day)
	{
		$flag = 0;
		if(($year%4==0 && $year%100!=0) || $year%400==0)
		{
			$flag = 1;
		}
		else
			$flag = 0;
		for($i=1;$i<=20;$i++)
		{
			for($j = 1;$j<=7;$j++)
			{	
				if($month==13)
				{
					$month=1;
				}
				$time_array[$i][$j] = $month."月".$day."日";
				if(($month==1 || $month==3 ||$month==5 ||$month==7 ||$month==8 ||$month==10 ||$month==12) && $day==31)
				{
					$day=1;
					$month++;
				}
				else if($day==28 && $month==2 && $flag == 0)
				{
					$day=1;
					$month++;
				}
				else if($day==29 && $month==2 && $flag == 1)
				{
					$day=1;
					$month++;
				}
				else if(($month==4 ||$month==6 ||$month==9 ||$month==11) &&$day==30)
				{
					$day=1;
					$month++;
				}
				else
					$day++;
			}
		}
		return $time_array;
	}	
?>
<table width="87%;"; id="s_week"; height="550px;"; style="font-size:10px;";>
    <?php
	$time_rili = rili('2013','2','25');
    echo"
	<tr align=center height=50px;>
        <td></td>
        <td>星期一[".$time_rili[$week][1]."]</td>
        <td>星期二[".$time_rili[$week][2]."]</td>
        <td>星期三[".$time_rili[$week][3]."]</td>
        <td>星期四[".$time_rili[$week][4]."]</td>
        <td>星期五[".$time_rili[$week][5]."]</td>
        <td>星期六[".$time_rili[$week][6]."]</td>
        <td>星期日[".$time_rili[$week][7]."]</td>
      </tr>";
	//查询当前周排课信息  
	$sql = "select * from teacher_sj_schedule where substr(time_add,1,12) = '$id'";
	$result = $conn->query($sql);
	$cnt = 0;
	if($result)
	{
		
		while($info = $result->fetch_array ())
		{
			$cnt++;
			$sql1 = "select * from course where course_id = '".$info['course_id']."'";//获取课程名及教师号
			$result1 = $conn->query($sql1);
			if($result1 && $info1 = $result1->fetch_array())
			{
				
				$sql2 = "select * from teacher where teacher_id = '".$info1['teacher_id']."'";//获取教师名
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
					if($cnt==1 || $cnt==8 || $cnt==15 || $cnt==22 || $cnt==29)
					{	
						echo "<tr>";
						$j=$cnt+1;
						echo "<td>".$cnt."-".$j."节</td>";
					}
					echo "<td>";
					if($info['lock']==1)
						echo "";
					else if($info['lock']==2)
					{	
						echo strlen($info1['course_name']);
						//echo $info['lock'];
						echo "<div class=\"course_text\">教师:".$info2['teacher_name']."</div>";
						echo "<div class=\"course_text\" title=".$info1['course_name'].">课程:".$info1['course_name']."</div>";
						echo "<div class=\"course_text\">".$class."</div>";
						echo "<div class=\"course_text\">备注:".$info['tips']."</div>";
					}
					else
					{
						echo "管理员已加锁<br /><br />备注:".$info['tips'];
					}
					echo "</td>";
					if($cnt==7 || $cnt==14 || $cnt==21 || $cnt==28 || $cnt==35)
					{
						echo "</tr>";
					}
					
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