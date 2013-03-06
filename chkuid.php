<?php
$uid =$_GET['q'];
require("consql.php");
$cnt=0;
$sql = "SELECT uid FROM userinfo WHERE uid='$uid' ";
//echo $sql;
$result = mysql_query($sql);
$cnt = mysql_num_rows($result);
mysql_close($con);
if ($cnt >0)
{
	echo 1;
}
else
{
	echo 0;
}
?>