<?php 
//consql.php
$con = mysql_connect("localhost","root","123456qwe");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("mkb",$con);
mysql_query("SET NAMES 'utf8'");
?>