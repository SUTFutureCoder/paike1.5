<?php

/**
 * 数据导出
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      
*/

session_start();
if(!isset($_SESSION['teacher_id']))
	echo "<script>window.top.location.href=\"../teacher/index.php\";</script>";
//else
//	if($_SESSION['limits'] !=0)
//		echo "<script>window.top.location.href=\"../teacher/index.php\";</script>";
include "../include/conn.php"; 

$sql_teacher_list = 'SELECT teacher_name FROM teacher WHERE teacher_id >= 10000';
$result_teacher = $conn->query($sql_teacher_list);
$teacher_list = array();
if ($result_teacher){
    while ($row = $result_teacher->fetch_assoc()){
        $teacher_list[] = $row;
    }
}

$sql_address_list = 'SELECT * FROM ini_address';
$result_address = $conn->query($sql_address_list);
$address_list = array();
if ($result_address){
    while ($row = $result_address->fetch_assoc()){
        $address_list[] = $row;
    }
}
        
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>班级添加</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
</head>

<body style="margin-top:100px; margin-left:200px;">
<form name="form">
<p class="admin_tips">提示：输入框优先于选择框</p>
<p>
教师:&nbsp;&nbsp;<select name="teacher_select" id="teacher_select">
<option  value="" selected="selected"></option>
<?php foreach ($teacher_list as $teacher_list_item): ?>
<option  value="<?php echo $teacher_list_item['teacher_name']?>"><?php echo $teacher_list_item['teacher_name']?></option>
<?php endforeach; ?>
</select>

&nbsp;&nbsp;<input type="text" name="teacher_input" class="input_text" />
<p>
<p>
<input type="button"  value="导出此教师数据" onclick="dump_teacher(0)" class="button"/>
<p>
<p>
<input type="button"  value="导出全部教师数据" onclick="dump_teacher(1)" class="button"/>
<hr/>
实验室:&nbsp;&nbsp;<select name="address_select" id="address_select">
<option  value="" selected="selected"></option>
<?php foreach ($address_list as $address_list_item): ?>
<option  value="<?php echo $address_list_item['address']?>" ><?php echo $address_list_item['address']?></option>
<?php endforeach; ?>
</select>

&nbsp;&nbsp;<input type="text" name="address_input" class="input_text" />
<p>
<p>
<input type="button"  value="导出此实验室数据" onclick="dump_address(0)" class="button"/>
<p>
<p>
<input type="button"  value="导出全部实验室数据" onclick="dump_address(1)" class="button"/>
</form>
    
<div style="display: none" id="download"></div>

<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
<script>
function dump_teacher(global){
    if (global){
        $("#download").html('<iframe src="dump_teacher_data.ajax.php?global=1" style="display:none"></iframe>');
    } else {
        //优先输入框
        if ("" != document.form.teacher_input.value){
            $("#download").html('<iframe src="dump_teacher_data.ajax.php?global=0&teacher=' + document.form.teacher_input.value + '" style="display:none"></iframe>');
        } else { 
            if ("" != document.form.teacher_select.options[document.form.teacher_select.selectedIndex].value){
               $("#download").html('<iframe src="dump_teacher_data.ajax.php?global=0&teacher=' + document.form.teacher_select.options[document.form.teacher_select.selectedIndex].value + '" style="display:none"></iframe>');
            } else {
                alert('请输入或选择教师姓名');
            }
        }
    }
}

function dump_address(global){
    if (global){
        $("#download").html('<iframe src="dump_address_data.ajax.php?global=1" style="display:none"></iframe>');
    } else {
        //优先输入框
        if ("" != document.form.address_input.value){
            $("#download").html('<iframe src="dump_address_data.ajax.php?global=0&address=' + document.form.address_input.value + '" style="display:none"></iframe>');
        } else { 
            if ("" != document.form.address_select.options[document.form.address_select.selectedIndex].value){
               $("#download").html('<iframe src="dump_address_data.ajax.php?global=0&address=' + document.form.address_select.options[document.form.address_select.selectedIndex].value + '" style="display:none"></iframe>');
            } else {
                alert('请输入或选择实验室');
            }
        }
    }
}
    
//    
//var dateTime=new Date();
//var yy = dateTime.getFullYear();
//document.form.year.value = yy;
//document.form.year.focus();
//function sure()
//{
//	var year = document.form.year.value;	
//	var school_id = document.form.school.options[document.form.school.selectedIndex].value;
//	var school = document.form.school.options[document.form.school.selectedIndex].text;
//	var add_major = document.form.add_major.value;
//	var number = document.form.number.value;
//	
//	
//	if(year=="")
//	{
//		alert("您需要输入年份,如:2015");
//		document.form.year.focus();
//	}
//	else if(add_major=="")
//	{
//		alert("您需要输入专业名,如:计算机");
//		document.form.add_major.focus();
//	}
//	else if(!year.match(/^\d\d\d\d$/))
//	{
//		alert("输入不合法,请重新输入");
//		document.form.year.focus();
//	}
//	else if(number == "" || number <= 0)
//	{
//		alert("您需要输入班数,如:3");
//		document.form.address.focus();
//	}
//	else
//	{	
//	$.ajax({
//   		type: "POST",
//  		url: "add_class.ajax.php",
//  	 	data: "year="+year+"&add_major="+add_major+"&number="+number+"&school_id="+school_id,
//   		success: function(msg)
//		{
//			//alert(msg);
//			if(msg=='1')
//			{
//				alert("添加成功");
//			}
//			else
//			{
//				alert("添加失败,请联系管理员");
//			}
//   		}
//	   }); 
//	}
//}
</script>
</body>
</html>
