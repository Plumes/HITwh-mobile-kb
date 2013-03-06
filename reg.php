<?php

	if ($_POST['uid'] !="" && $_POST['pwd'] !="" )
	{
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		require("consql.php");
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
	echo "<form >注册:<br />"
		."<input type='text' name='uid' placeholder='帐号' onchange='chkuid(this.value)' /><br>"
		."<input type='password' name='pwd' placeholder='密码' onchange='chkpwd(this.value)' /><br>";
	echo '<p><span id="txtHint"></span></p> ';
	echo "<input type='button' value='确定' class='bbtn' onclick='sendinfo()'/></form>";
	
?>
</div>
</body>
<script>
var uidistrue = 0;
var pwdistrue = 0;
var uid="";
var pwd="";
function chkuid(str)
{
	//alert(str);
	var xmlhttp;
	if (str.length>0)
	  {   
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    	if(xmlhttp.responseText == "0")
		    	{
		    		document.getElementById("txtHint").innerHTML='<font size="3px" color="green">恭喜,该用户名可以使用！</font>';
		    		uidistrue =1;
		    		uid =str;

		    	}
		    	else
		    	{
		    		document.getElementById("txtHint").innerHTML='<font size="3px" color="red">该用户名不能使用！</font>';
		    	}
		    
		    }
		  }
		xmlhttp.open("GET","/chkuid.php?q="+str,true);
		xmlhttp.send();
	}
}
function chkpwd(str)
{
	if(str.length>=6)
    	{
    		document.getElementById("txtHint").innerHTML='';
    		pwddistrue =1;
    		pwd=str;
    	}
    	else
    	{
    		document.getElementById("txtHint").innerHTML='<font size="3px" color="red">密码至少六位！</font>';
    	}
}
function sendinfo()
{
	if (uidistrue==1 && pwddistrue==1)
	{
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.open("POST","reg.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("uid="+uid+"&pwd="+pwd);
		alert("注册成功，转入登陆页面");
		location.href = "login.php";
	}
}
</script>
</html>