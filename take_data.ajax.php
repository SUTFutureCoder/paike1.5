<?php
	include 'include/conn.php';
	
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
	
	//返回节数
	function jie($j)
	{
		if($j == "1")
			return "1-2节";
		if($j == "2")
			return "3-4节";
		if($j == "3")
			return "5-6节";
		if($j == "4")
			return "7-8节";
		if($j == "5")
			return "9-10节";
	}
	//返回周
	function zhou($z)
	{
		if($z == "1")
			return "周一";
		if($z == "2")
			return "周二";
		if($z == "3")
			return "周三";
		if($z == "4")
			return "周四";
		if($z == "5")
			return "周五";
		if($z == "6")
			return "周六";
		if($z == "7")
			return "周日";
	}
	
	$year = DB::CheckInput($_POST['year']) . "_________";
	$course_class = DB::CheckInput($_POST['course_class']);
	$sql = "SELECT `time_add`,`course_id`,`course_class`,`tips` FROM `teacher_sj_schedule` WHERE time_add like '$year' AND course_class!='' AND course_class like '%$course_class%'";
	$result = $conn->query($sql);
	
	?>
    <table width="88%"; border="1"; id="t_table"; align="center">
        <tr height="30px;" align="center" style="font-size:17px; font-weight:600;">
            <td style="cursor:pointer" title="课程排序" onclick="ownSort(0)">课程</td>
            <td style="cursor:pointer" title="教师排序" onclick="ownSort(1)">教师</td>
            <td style="cursor:pointer" title="时间排序" onclick="ownSort(2)">时间</td>
            <td style="cursor:pointer" title="地点排序" onclick="ownSort(3)">地点</td>
            <td style="cursor:pointer" title="班级排序" onclick="ownSort(4)">班级</td>
            <td>备注</td>
            <td>资料</td>
      </tr>
    <?php
	//$temp 判断查询结果是否为空
	$temp=0;
	while($info = $result->fetch_array())
	{
		$temp++;
		echo "<tr height=30px; align=center>";
		
		$sql_course = "SELECT course_name,teacher_id FROM `course` WHERE course_id = '".$info['course_id']."'";
		$result_course = $conn->query($sql_course);
		$info_course = $result_course->fetch_array();
		echo "<td>";
		echo $info_course['course_name'];
		echo "</td>";
		
		$sql_teacher = "SELECT teacher_name FROM `teacher` WHERE teacher_id = '".$info_course['teacher_id']."'";
		$result_teacher = $conn->query($sql_teacher);
		$info_teacher = $result_teacher->fetch_array();
		echo "<td>";
		echo $info_teacher['teacher_name'];
		echo "</td>";

		$week  = substr($info['time_add'],10,2);
		$j_jie = substr($info['time_add'],12,1);
		$z_zhou = substr($info['time_add'],13,1);
		echo "<td>";
		echo "第".$week."周 ".zhou($z_zhou)." ".jie($j_jie);
		echo "</td>";
		
		$address = substr($info['time_add'],5,2);
		$sql_address = "SELECT * FROM school where school_id = '$address'";
		$result_address = $conn->query($sql_address);
		$info_address = $result_address->fetch_array();
		echo "<td>";
		echo $info_address['school_name'].substr($info['time_add'],7,3);
		echo "</td>";
		
		echo "<td>";
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
		echo $class;
		echo "</td>";
		
		echo "<td>";
		echo $info['tips'];
		echo "</td>";
		
		echo "<td>";
		$sql_file = "select file_name from file where course_id = '".$info['course_id']."'";
		$result_file = $conn->query($sql_file);
		while($info_file = $result_file->fetch_array())
		{
			//$filename = iconv("utf-8","gbk",$info_file['file_name']);
				echo "<a class=\"prime_a\" href=\"downloads/".$info_file['file_name']."\">".$info_file['file_name']."<br></a>";
		}
		echo "</td>";
		echo "</tr>";

	}
	if($temp==0)
	echo "
	<tr height=30px; align=center ;>
        <td colspan=7>暂无排课记录</td>
	</tr>";
?>
</table>
<br/><br/><br/><br/>