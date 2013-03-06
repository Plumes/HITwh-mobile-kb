<?php
session_start();

if ($_SESSION['uid'] !="")
{
	session_destroy();
	session_start();
}

if ($_POST['uid'] !="" && $_POST['pwd']!="")
{
/*	$con = mysql_connect("localhost","root","123456qwe");
	if (!$con)
	{
	    die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("mkb",$con);
	mysql_query("SET NAMES 'utf8'");*/
	require("consql.php");
	$uid = $_POST['uid'];
	
	$sql = "SELECT  `pwd` FROM userinfo WHERE uid=\"$uid\"";

	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	//echo (mysql_num_rows($result));
	if (mysql_num_rows($result)==1 && $row['pwd'] == $_POST['pwd'])
	{
		//echo $uid;
		$_SESSION['uid'] =$uid;
		$url="query.php";
		header("Location: $url");
	}
	mysql_close($con);
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
	echo "<form action= 'login.php' method='post'>班号:<br />"
		."<input type='text' name='uid' placeholder='id' /><br>"
		."<input type='password' name='pwd' placeholder='password' /><br>";
	echo "<input type='submit' value='确定' class='bbtn' /></form>";
	
?>
</div>
</body>
</html>