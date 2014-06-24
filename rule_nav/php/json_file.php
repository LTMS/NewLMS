<?php
$text=$_GET['text'];
$file_id=$_GET['file_id'];
include 'conn.php';
$prepareQuery="update json_file set json_text='".$text."' where file_id=$file_id";
if(!(mysql_query($prepareQuery)))
{
	print("unable to insert1:$file_id");
	die(mysql_error());
}
echo "JSON File Saved";