<?php
ini_set("display_errors",1);
date_default_timezone_set("Asia/Calcutta");

$urls="http://search.twitter.com/search.json?q=I+love+you&rpp=100";

$dbhost="localhost";
$dbname="sqlbox";
$dbuser="root";
$dbpassword="**********";
$connect=mysql_connect($dbhost,$dbuser,$dbpassword) or die("Connection to DB Failed");
mysql_select_db($dbname,$connect) or die("Couldnt select database");

$q="I love you";
$page=1;
while($page<=15)
{
$url=$urls."&page=$page";
//echo $url;
$page++;
$a=file_get_contents($url);
//$a=file_get_contents('./search.json', true);
$data=json_decode($a,true);

foreach($data as $key => $items)
{
if(is_array($items))
foreach($items as $item)
	{
	$text=$item["text"];
	$id=$item["id_str"];
	$time=explode(" ",$item["created_at"]);
	$dataitem=explode(":",$time[4]);
	//echo "$text $time[4] $id <br/> ";
	$utime=mktime($dataitem[0],$dataitem[1],"00");
	
	$pos=strripos($text,$q);
	if($pos!==false)
		$query=mysql_query("Insert into twitter(id,text,time) values('$id','$text','$utime')");	
		if($query!=false)
		{
		$insert = mysql_query("insert into twit_map(time,count) values($utime,1)");
		if($insert==false)
		$update = mysql_query("Update twit_map set count=count+1 where time=$utime");
		}
	}
} 
}
?>
