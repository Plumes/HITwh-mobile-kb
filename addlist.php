<?php
session_start();
if ($_SESSION['uid'] =="") {
	# code...
	$url="login.php";
	header("Location: $url");
}

$uid = $_SESSION['uid'];
//echo $uid;
$con = mysql_connect("localhost","root","123456qwe");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("mkb",$con);
mysql_query("SET NAMES 'utf8'");

$cnt=0;
//echo 'kch'.$cnt ;
$skch = 'kch'.$cnt ;
$skxh = 'kxh'.$cnt;
//echo $_POST[$skch];
while ($_POST[$skch] !="" && $_POST[$skxh] !="")
{
	$kch = $_POST[$skch];
	$kxh = $_POST[$skxh];

	$sql = "INSERT INTO `stuinfo`(`uid`, `kch`, `kxh`) VALUES (\"$uid\",\"$kch\",\"$kxh\")";
	//echo $sql;
	mysql_query($sql);
	$cnt=$cnt+1;
	$skch = 'kch'.$cnt ;
	$skxh = 'kxh'.$cnt;
	$url="login.php";
	header("Location: $url");

}
$sql = "SELECT COUNT(*) as `cnt` FROM stuinfo WHERE uid=\"$uid\"";

$result = mysql_query($sql);
$row=mysql_fetch_assoc($result);
mysql_close($con);


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
echo "<form action='addlist.php' method='post'><a class='ctrtext'>";
echo "共<t> ".$row['cnt']." </t>men课</a>";
echo "<div id='field'><br /><input type='text' class='cinfo' name='kch0' placeholder='kch？' />";
echo "<input type='text' class='cinfo' name='kxh0' placeholder='kxh？' /></div>";
//echo '<form><input type="button" value="continue" class="rbtn" onClick="AddElement(\'text\')'' />';
//echo "<input type='button' value='确定' class='bbtn' /></form>";
?>
<input type="button" value="continue" class="rbtn" onClick="AddElement( 'text' )" />
<input type="submit"  value="确定" class="bbtn" /></form>
</div>
 <script>
 var index = 1;
function AddElement(mytype){ 
var mytype,TemO=document.getElementById("field"); 
var newkch= document.createElement("input");
var newkxh= document.createElement("input");

newkch.type=mytype;
newkxh.type=mytype;  
newkch.name="kch".concat(index); 
newkxh.name="kxh".concat(index);

newkxh.setAttribute("class","cinfo");
newkch.setAttribute("class","cinfo");
TemO.appendChild(newkch); 
TemO.appendChild(newkxh); 
var newline= document.createElement("br"); 
TemO.appendChild(newline); 
index++;
}
</script>
</body>
</html>