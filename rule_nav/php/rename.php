<?php
include 'conn.php';
$id=$_GET["id"];
$name=$_GET["name"];
$prepareQuery="update nodes set name='".$name."' where id='$id'";
if(!(mysql_query($prepareQuery)))
{
	print("unable to insert");
	die(mysql_error());
}
echo "Update";