<?php

$conn = @mysql_connect('localhost','root','icandoit4deas');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('rule', $conn);

?>