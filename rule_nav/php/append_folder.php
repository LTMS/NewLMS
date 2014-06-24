<?php
include 'conn.php';
$pid=$_GET["pid"];

$getQuery="select * from nodes where name='NewFolder' and parentId=$pid";
if(!($openres=mysql_query($getQuery)))
{
	print("unable to insert");
	die(mysql_error());
}

if(mysql_num_rows($openres)==1){
	print("Aleady New folder.Please rename the folder");
	die();
}

/*add folder*/
$prepareQuery="insert into nodes (name,parentId) values('NewFolder',$pid)";
if(!(mysql_query($prepareQuery)))
{
	print("unable to insert");
	die(mysql_error());
}

$getPidQuery="select id from nodes where name='NewFolder' and parentId=$pid";
if(!($openres1=mysql_query($getPidQuery)))
{
	print("unable to insert");
	die(mysql_error());
}
$row=mysql_fetch_row($openres1);

$fpid=$row[0];
/*add file*/
$fileQuery="insert into nodes (name,parentId) values('NewFile',$fpid)";
if(!(mysql_query($fileQuery)))
{
	print("unable to insert");
	die(mysql_error());
}

$getidQuery="select id from nodes where name='NewFile' and parentId=$fpid";
if(!($openres2=mysql_query($getidQuery)))
{
	print("Aleady New file.Please rename the file");
	die();
}
$row1=mysql_fetch_row($openres2);
$id=$row1[0];

$textQuery="insert into json_file (json_text,file_id) values('{}',$id)";
if(!(mysql_query($textQuery)))
{
	print("Aleady New file.Please rename the file");
	die(mysql_error());
}
echo "OK"."::".$id;

//echo "add folder" ;