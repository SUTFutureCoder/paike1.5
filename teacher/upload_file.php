<?php
$filename=iconv("utf-8","gbk",$filename); 
if ($_FILES["file"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else
{
  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
}
?>

<?php

if ((($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/pjpeg"))
  && ($_FILES["file"]["size"] <   10000000))//10,000,000
{
	if ($_FILES["file"]["error"] > 0)
    {
    	echo "Error: " . $_FILES["file"]["error"] . "<br />";
    }
	else
    {
    	echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		echo "Stored in: " . $_FILES["file"]["tmp_name"];
	}
}
else
{
	echo "Invalid file";
}

?>

<?php
if ((($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/pjpeg"))
  && ($_FILES["file"]["size"] < 10000000))//10,000,000
{
	if ($_FILES["file"]["error"] > 0)
    {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
	else
    {
		echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    	echo "Type: " . $_FILES["file"]["type"] . "<br />";
    	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    	echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
    	if (file_exists("./upload/" . $_FILES["file"]["name"]))
      	{
      		echo $_FILES["file"]["name"] . " already exists. ";
		}
    	else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],
			"./upload/" . $_FILES["file"]["name"]);
			echo "Stored in: " . "./upload/" . $_FILES["file"]["name"];
		}
    }
}
else
{
  echo "Invalid file";
}
?>
