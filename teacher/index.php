<?php 
session_start();
	if(isset($_SESSION['teacher_id']))
	{
		if($_SESSION['limits'] ==0)
			header("location:../admin/index.php");
		if($_SESSION['limits']==1)
			header("location:../teacher/schedule.php");
				
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教师登录</title>
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<link href="css/teacher_index.css" rel="stylesheet" type="text/css" />
<link href="../include/css/global.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js"></script>
<script src="js/jquery.animate.js"></script>
</head>

<body class="body_pos">
<?php
if(!isset($_GET['time']))
	$time = "";
else{
    if (get_magic_quotes_gpc()){
        $time = stripslashes($_GET['time']);
    } else {
        $time = $_GET['time'];
    }
}

?>

<div id="contest">
    	<div class="header">
    		<div class="header_text">
            	<ul>
            		<li><a href="../index.php" class="header_first">首页</a></li>
                    <li><a href="../query.php" class="header_first">机房课程表</a></li>
                    <li><a href="../class_shedule.php" class="header_first">班级课程表</a></li>
               		<li><a href = index.php class=header_first>教师登录</li></a>
                     <li><a style="margin-left:120px; font-size:14px; width:90px;" href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a></li>
                    <li><a style="font-size:14px; width:90px;" href="http://www.sut.edu.cn" class="header_first" target="_blank">工大官网</a></li>
    			</ul>
           	 </div>
            </div>
            <div class="triangle1"></div>
   			 <div class="triangle2"></div>
            <div id="login_form">
                <div id="sub_title"><img src="img/teacher_login.png" /></div>
                <form name="form">
                <input type="text" name="time" style="display:none" value="<?php echo $time ?>"/>
                <table id="login_table">
                    <tr>
                        <td><img src="img/id.png" /></td>
                        <td><input type="text"  name="teacher_id" class="teacher_text" maxlength="5" onkeydown="if(event.keyCode == 13)Submit()"/></td>
                    </tr>
                    <tr>
                        <td><img src="img/psw.png" /></td>
                        <td><input type="password" name="teacher_psw" class="teacher_text"  onkeydown="if(event.keyCode == 13)Submit()"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div id="login_button_div"><img src="img/login_button.png" onclick="Submit()" id="teacher_button" /></div></td>
                    </tr>
                </table>
                </form>
            </div>
</div>
</body>

<script>
if((screen.width <= 1024) && (screen.height <= 768))
{
	//alert("哈哈");
	document.getElementById("contest").style.left="0";
}
document.form.teacher_id.focus();
$('#teacher_button').hover(
	function()
	{
		$('#teacher_button').attr({'src':'img/login_button_active.png'});
		$('#login_button_div').animate({'backgroundColor':'#FFF'},200);	
	},
	function()
	{
		$('#teacher_button').attr({'src':'img/login_button.png'});
		$('#login_button_div').animate({'backgroundColor':'#2c2c2c'},200);				
	}
);
function Submit()
{
	var teacher_id = document.form.teacher_id.value;
	var teacher_psw = document.form.teacher_psw.value;
	var time = document.form.time.value;
	if(teacher_id=="")
	{
		alert("您需要输入教师号");
		document.form.teacher_id.focus();
	}
	else if(teacher_psw=="")
	{
		alert("您需要输入密码");
		document.form.teacher_psw.focus();
	}
	else
	{
	$.ajax({
   		type: "POST",
  		url: "login.ajax.php",
  	 	data: "teacher_id="+teacher_id+"&teacher_psw="+teacher_psw,
   		success: function(msg)
		{
			if(msg=='1')
				window.location.href = "schedule.php?time="+time;
			else if(msg=='2')
				window.location.href = "../admin/index.php?time="+time;
			else
			{
				alert("帐号或密码错误");
				document.form.teacher_id.focus();
			}
   		}
	   }); 
	}
}
</script>
</html>
