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
	<div><ul class='weektitle'>哈工大威海移动课表</ul></div>
<div class="getinfo">

<?php
	$bj = $_GET['bj'];
	if ($bj !="")
	{
		echo "<form action='kbcx.php' method='get'>\n";
		echo "<input type='hidden' name='bj' value=$bj />";
		echo "<input type='hidden' name='dayno' value='1' />";
		echo "<input type='hidden' name='weekno' value='12' />";
		echo "<input type='submit' value='查看今天的课表' class='rbtn' /></form>";

		echo "<p class='ctrtext'>OR</p>";

		echo "<form action='kbcx.php' method='get'>\n";
		echo "<input type='hidden' name='bj' value=$bj />";
		echo "<input type='text' name='weekno' placeholder='哪一周？' /><br>";
		echo "<input type='text' name='dayno' placeholder='星期几？' />";
		
		echo "<input type='submit' value='确定' class='bbtn' /></form>";
		



	}
	else
	{
		echo "<form action= 'kb.php' method='get'>班号:<br /><input type='text' name='bj' placeholder='班号' /><br>";
		echo "<input type='submit' value='确定' class='bbtn' /></form>";
	}

?>

</div>

</body>
</html>