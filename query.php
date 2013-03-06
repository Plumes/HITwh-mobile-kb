<?php
session_start();
$dayno = date("w");
$weekno = date("W")-8;
if ($_SESSION['uid'] =="")
{
	$url="login.php";
	//echo "*".$_SESSION['uid'];
	header("Location: $url");
}
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
	<style type="text/css">
      			body {background-color: #acdae5;}
	</style>
	<meta http-equiv="content-type" />
	<meta content="text/html" charset="utf-8" />
	 <title>哈工大威海课表查询</title>
	 <link rel="stylesheet" href="style.css" type="text/css"/>
	 
</head>
<body>
	<?php
		echo "<ul class='weektitle'>\n";
		echo "<li>第 $weekno 周</li>";
		echo "<li><a class='dtright' href='addlist.php'>增删课程</a></li>";
		echo "\n</ul>";
	?>
<div class="getinfo"><form action='result.php' method='get'>
	<input type='hidden' name='dayno' value="<?php echo $dayno; ?>"/>
	<input type='hidden' name='weekno' value="<?php echo $weekno; ?>" />
	<input type='submit' value='查看今天的课表' class='rbtn' /></form>

	<p class='ctrtext'>OR</p>

	<form action='result.php' method='get'>
	<input type='text' name='weekno' placeholder='哪一周？' /><br>
	<input type='text' name='dayno' placeholder='星期几？' />
		
	<input type='submit' value='确定' class='bbtn' /></form>
</div>

</body>
</html>
