<?php
session_start();

if ($_SESSION['uid'] =="")
{
	$url="login.php";
	//echo "*".$_SESSION['uid'];
	header("Location: $url");
}
$dayno =0;
$weekno =0;
$dayno= (int)$_GET['dayno'];
$weekno= (int)$_GET['weekno'];

if($dayno=="" || $weekno=="")
{
	$url="query.php";
	//echo "*".$_SESSION['uid'];
	header("Location: $url");
}
$uid = $_SESSION['uid'];
$dayname = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$ctime = array("08:00~09:45","10:05~11:50","14:00~15:45","16:05~17:50","18:20~19:30");


//echo $uid." ".$dayno." ".$weekno;
require("consql.php");
$sql ="SELECT cname,teacher,room,corder,sweek,eweek FROM `stuinfo`, `cinfo` 
	WHERE stuinfo.kch=cinfo.kch and stuinfo.kxh=cinfo.kxh 
	AND uid = '$uid' AND xq = $dayno 
	and sweek<=$weekno and eweek>=$weekno";
//echo $sql;
$result = mysql_query($sql);
$cnt=0;
$cnt = mysql_num_rows($result);
mysql_close($con);

for ($i=0; $i<$cnt;$i++)
{
	$row = mysql_fetch_array($result);
	$arr[ $i ] =  array('cname' => $row['cname'] , 
			'teacher' => $row['teacher'],
			'room' => $row['room'],
			'corder' => $row['corder'],
			'sweek' => $row['sweek'],
			'eweek' => $row['eweek']);

}
function mycmp($a , $b)
{
	return ($a['corder'] >= $b['corder']);
}
usort($arr,"mycmp");
//echo $arr[0]['cname'];
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
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
	echo "<div class='daytitle'>\n";
	echo "<a class='dtleft'>";
	echo $dayname[$dayno-1]."</a>";
	echo "<a class='dtright'>";
	echo "共<t> ".$cnt." </t>节课</a>";
	echo "\n</div>";
	echo "<ul class='classlist'>\n";
$index=1;
$len = count($arr);
for ($i=0;$i<$len;$i++)
{
   // if($flag == 1)
    {
        for (;$index <$arr[$i]['corder']; $index++)
        {
            echo "\t<li>\n\t\t";
            echo "NULL"."&nbsp (".$ctime[$index-1].")</a><br />";
            echo "<a class = 'corder'>".$index."</a>";
            echo "\n\t</li>\n";
        }
    }
    echo "\t<li>\n\t\t";
    $flag=1;
    while($arr[$i]['corder'] == $index)
    {
        if($flag>1)
        {
        	echo '<div class="demo_line"> <span>分隔线 </span></div>';

        }
        echo "<a class='cname'>".$arr[$i]['cname']."&nbsp (".$ctime[$index-1].")</a><br />";
        echo "<a class='room'>"."教室: <t>".$arr[$i]['room']."</t></a>&nbsp;&nbsp;&nbsp;";
        echo "<a class='room'>"."老师: <t>".$arr[$i]['teacher']."</t></a><br />";
        echo "<a class='room'>第 ".$arr[$i]['sweek']." 周 ~ 第 ".$arr[$i]['eweek']." 周</a><br />";
        $i++;
        $flag++;
        //echo "<a class = 'corder'>".$index."</a>";
        //echo next($arr);
/*        if(next($arr)['corder'] == $row['corder'])
        {

        }*/
        //echo ." ".$row['room']." ".$row['teacher'] ;
        //echo "\n\t</li>\n";
    }
    $i--;
     echo "<a class = 'corder'>".$index."</a>";
     echo "\n\t</li>\n";
    // else
    // {
    //     for($i=$index; $i<$row['corder'];$i++)
    //     {
    //         echo "\t<li>\n\t\t";
    //         echo "NULL"."&nbsp (".$ctime[$index-1].")</a><br />";
    //         echo "<a class = 'corder'>".$index."</a>";
    //         echo "\n\t</li>\n";
    //     }
    //     $index = $row['corder'];
    //     echo "\t<li>\n\t\t";
    //     echo "<a class='cname'>".$row['cname']."&nbsp (".$ctime[$index-1].")</a><br />";
    //     echo "<a class='room'>"."教室: <t>".$row['room']."</t></a>&nbsp;&nbsp;&nbsp;";
    //     echo "<a class='room'>"."老师: <t>".$row['teacher']."</t></a><br />";
    //     echo "<a class='room'>第 ".$row['sweek']." 周 ~ 第 ".$row['eweek']." 周</a><br />";
    //     echo "<a class = 'corder'>".$index."</a>";
    //     //echo $row['cname']." ".$row['room']." ".$row['teacher'] ;
    //     echo "\n\t</li>\n";

    // }
    $index++;
    
}
for (;$index <=5; $index++)
{
    echo "\t<li>\n\t\t";
    echo "NULL"."&nbsp (".$ctime[$index-1].")</a><br />";
    echo "<a class = 'corder'>".$index."</a>";
    echo "\n\t</li>\n";
}
echo "</div>";
echo "<div class='daytitle'>\n";
echo "<button onclick='prev()' class='dtleft_b'>前一天</button>";
echo "<button font-size='16px' onclick='next()' class='dtright_b'>后一天</button><br />";
echo "</div>";
echo "<a class='ft'>现在是: ". date('Y-m-d H:i') ."</a>\n";


?>
</body>
<script>
var dno = <?php echo $dayno; ?>;
var wno = <?php echo $weekno; ?>;
function prev()
{
	dno = dno % 7;
	dno = dno -1;
	if(dno<1) 
	{
		dno =dno+7;
		wno = wno -1;
	}
	location.href = "result.php?weekno="+String(wno)+"&dayno="+String(dno);
}
function next()
{
	dno = dno % 7;
	dno = dno +1;
	if(dno==1) 
	{
		
		wno = wno +1;
	}
	location.href = "result.php?weekno="+String(wno)+"&dayno="+String(dno);
}
</script>
</html>