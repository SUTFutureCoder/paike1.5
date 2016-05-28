<?php
	session_start();
	include "include/conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" href="include/css/global.css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>班级课程表</title>

</head>

<body class="body_pos">
<div id="contest">
	<div class="header">
		<div class="header_text">
            	<ul>
            		<li><a href="index.php" class="header_first">首页</a></li>
                    <li><a href="query.php" class="header_first">机房课程表</a></li>
                    <li><a href="class_shedule.php" class="header_first">班级课程表</a></li>
                    <?php
					if(isset($_SESSION['teacher_id']))
						echo "<li><a href=teacher/teacher_index.php class=header_first>个人中心</a> </li>
                    <li><a class=header_first onclick=zhuxiao()>注销</a></li>";
                    else
					echo "<li><a href = teacher/index.php class=header_first>教师登录</li></a>"
					?>
                     <li><a style="margin-left:120px; font-size:14px; width:90px;" href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a></li>
                    <li><a style="font-size:14px; width:90px;" href="http://www.sut.edu.cn" class="header_first" target="_blank">工大官网</a></li>
    			</ul>
        </div>
      </div>
     <div class="triangle1"></div>
    <div class="triangle2"></div>
      <center>
          <iframe src="http://jwc.sut.edu.cn/ACTIONQUERYCLASSSCHEDULE.APPPROCESS" width="90%" align="middle" height="700px">
          </iframe>
      </center>
  </div>
<script src="include/js/Jquery.js">
</script> 
<script>
if((screen.width <= 1024) && (screen.height <= 768))
{
	//alert("哈哈");
	document.getElementById("contest").style.left="0";
}
function zhuxiao()
{
	x = "000";
	$.ajax({
   		type: "POST",
  		url: "teacher/logout.ajax.php",
		data:"x="+x,
   		success: function(msg)
		{
			window.top.location.href = "index.php";
   		}
	   }); 
}
</script>
</body>
</html>