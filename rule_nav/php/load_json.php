<?php
include 'conn.php';
$id=$_GET["id"];

$getPidQuery="select json_text from json_file where file_id=$id";
if(!($openres1=mysql_query($getPidQuery)))
{
	print("unable to view");
	die(mysql_error());
}
$row=mysql_fetch_row($openres1);

$fpid=$row[0];

echo $fpid;
