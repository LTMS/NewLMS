<?php
include 'conn.php';
$pid=$_GET["pid"];




$prepareQuery="insert into nodes (name,parentId) values('NewFile',$pid)";
if(!(mysql_query($prepareQuery)))
{
	print("unable to insert");
	die(mysql_error());
}
$getidQuery="select id from nodes where name='NewFile' and parentId=$pid";
if(!($openres2=mysql_query($getidQuery)))
{
	print("errror");
	die(mysql_error());
}
$row1=mysql_fetch_row($openres2);
$id=$row1[0];

$textQuery="insert into json_file (json_text,file_id) values('{}',$id)";
if(!(mysql_query($textQuery)))
{
	print("Aleady New file.Please rename the file");
	die(mysql_error());
}
echo $id;
//echo "Added Successfully";