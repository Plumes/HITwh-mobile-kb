<?php
date_default_timezone_set('Asia/Shanghai');  
$dayname = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$ctime = array("08:00~09:45","10:05~11:50","14:00~15:45","16:05~17:50","18:20~19:30");
$bj = $_GET['bj'];
$bj = substr($bj,0,5)."01";
$dayno= (int)$_GET['dayno'];
$weekno= (int)$_GET['weekno'];
if ($_GET['dayno'] =="" || $_GET['weekno']=="")
{
    $url="kb.php";
    //echo "*".$_SESSION['uid'];
    header("Location: $url");
}
$dayno= (int)$_GET['dayno'];
$weekno= (int)$_GET['weekno'];
require("consql.php");
$sql = "SELECT cname,teacher,room,corder,sweek,eweek FROM kb "
	."where cno=$bj and weekday=$dayno "
	."and sweek<=$weekno and eweek>=$weekno";

$result = mysql_query($sql);
mysql_close($con);
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
    <title>哈工大威海课表查询</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
$index = 1;

echo "<ul class='weektitle'>\n";
echo "第 ".$weekno." 周";
echo "\n</ul>";
echo "<div class='daytitle'>\n";
echo "<a class='dtleft'>";
echo $dayname[$dayno-1]."</a>";
echo "<a class='dtright'>";
echo "共<t> ".mysql_num_rows($result)." </t>节课</a>";
echo "\n</div>";

echo "<ul class='classlist'>\n";
$flag=1;
while ($row = mysql_fetch_array($result))
{
   // if($flag == 1)
    {
        for (;$index <$row['corder']; $index++)
        {
            echo "\t<li>\n\t\t";
            echo "NULL"."&nbsp (".$ctime[$index-1].")</a><br />";
            echo "<a class = 'corder'>".$index."</a>";
            echo "\n\t</li>\n";
        }
    }
    //if($row['corder'] == $index)
    {
        echo "\t<li>\n\t\t";
        echo "<a class='cname'>".$row['cname']."&nbsp (".$ctime[$index-1].")</a><br />";
        echo "<a class='room'>"."教室: <t>".$row['room']."</t></a>&nbsp;&nbsp;&nbsp;";
        echo "<a class='room'>"."老师: <t>".$row['teacher']."</t></a><br />";
        echo "<a class='room'>第 ".$row['sweek']." 周 ~ 第 ".$row['eweek']." 周</a><br />";
        echo "<a class = 'corder'>".$index."</a>";
        //echo ." ".$row['room']." ".$row['teacher'] ;
        echo "\n\t</li>\n";
    }
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
var bj=<?php echo $bj; ?>;
function prev()
{
    dno = dno % 7;
    dno = dno -1;
    if(dno<1) 
    {
        dno =dno+7;
        wno = wno -1;
    }
    location.href = "kbcx.php?weekno="+String(wno)+"&dayno="+String(dno)+"&bj="+String(bj);
}
function next()
{
    dno = dno % 7;
    dno = dno +1;
    if(dno==1) 
    {
        
        wno = wno +1;
    }
    location.href = "kbcx.php?weekno="+String(wno)+"&dayno="+String(dno)+"&bj="+String(bj);
}
</script>
</html>