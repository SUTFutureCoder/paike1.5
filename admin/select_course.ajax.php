<?php
include "../include/conn.php";
$teacher_id = DB::CheckInput($_POST['teacher_id']); 
$sql = "select course_name,course_id FROM `course` WHERE teacher_id = '$teacher_id'";
$result = $conn->query($sql);
/*{ "people": [

{ "firstName": "Brett", "lastName":"McLaughlin", "email": "aaaa" },

{ "firstName": "Jason", "lastName":"Hunter", "email": "bbbb"},

{ "firstName": "Elliotte", "lastName":"Harold", "email": "cccc" }

]}*/
echo "{ \"course\": [";
$len = $result->num_rows();
$i=0;
while($info = $result->fetch_array())
{
	$i++;
	echo "{\"course_id\": \"".$info['course_id']."\",\"course_name\":\"".$info['course_name']."\"}";
	if($i!=$len)
		echo ",";
}
echo "]}";
?>