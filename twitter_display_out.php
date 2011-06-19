<?php

date_default_timezone_set("Asia/Calcutta");

$dbhost="localhost";
$dbname="sqlbox";
$dbuser="root";
$dbpassword="**********";
$connect=mysql_connect($dbhost,$dbuser,$dbpassword) or die("Connection to DB Failed");
mysql_select_db($dbname,$connect) or die("Couldnt select database");

$t=mysql_query("Select * from twit_map order by time asc");
$x="";
$y="";
$xstart="";
$xend="";
$ymax = 0;
while($row=mysql_fetch_assoc($t))
{
if($xstart=="")
$xstart=$row["time"];
$xend=$row["time"];
if($row["count"]>$ymax)
$ymax=$row["count"];
$x.=$row["time"].",";
$y.=$row["count"].",";
}
$x=substr($x,0,strlen($x)-1);
$y=substr($y,0,strlen($y)-1);
echo "<img src='http://chart.apis.google.com/chart?chxr=0,0,$ymax|1,$xstart,$xend&chxt=y,x&chs=440x220&cht=lxy&chco=49188F&chds=$xstart,$xend,0,$ymax&chd=t:";
echo "$x|$y";
echo "&chdl=I+love+you&chdlp=b&chls=2&chma=5,5,5,25&chtt=Twitter+-+I+love+you'/>";

?>
