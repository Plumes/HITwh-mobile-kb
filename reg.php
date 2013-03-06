<?php

	if ($_POST['uid'] !="" && $_POST['pwd'] !="" )
	{
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		$con = mysql_connect("localhost","root","123456qwe");
		if (!$con)
		{
		    die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("mkb",$con);
		mysql_query("SET NAMES 'utf8'");
		$sql ="INSERT INTO `userinfo`(`uid`, `pwd`) VALUES (\"$uid\",\"$pwd\")";
		//echo $sql;
		$result = mysql_query($sql);
		mysql_close($con);
		session_start();
		$_SESSION['uid']=$_POST['uid'];
		$url="addlist.php";
		header("Location: $url");
	}
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
    <title>哈工大威海课表查询</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <meta  content='text/html' charset="utf-8" />
    <style type="text/css">
      			body {background-color: #acdae5;}
	</style>
</head>
<body>
	<div><ul class='weektitle'>哈工大威海移动课表</ul></div>
<div class="getinfo">
<?php
	//date_default_timezone_set('Asia/Shanghai');
	echo "<form action= 'reg.php' method='post'>班号:<br />"
		."<input type='text' name='uid' placeholder='id' /><br>"
		."<input type='password' name='pwd' placeholder='password' /><br>";
	echo "<input type='submit' value='确定' class='bbtn' /></form>";
	
?>
</div>
</body>
</html>