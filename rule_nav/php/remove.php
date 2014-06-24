<?php
include 'conn.php';
$pid=$_GET["pid"];

$prepareQuery="delete from nodes where id=$pid";
if(!(mysql_query($prepareQuery)))
{
	print("unable to insert");
	die(mysql_error());
}
$prepareQuery1="delete from json_file where file_id=$pid";
if(!(mysql_query($prepareQuery1)))
{
	print("unable to insert");
	die(mysql_error());
}

echo "removed";