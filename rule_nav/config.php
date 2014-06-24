<?php
// Database config & class
$db_config = array(
	"servername"=> "localhost",
	"username"	=> "root",
	"password"	=> "icandoit4deas",
	"database"	=> "rule"
);
if(extension_loaded("mysqli")) require_once("jstree/_inc/class._database_i.php");
else require_once("jstree/_inc/class._database.php");

// Tree class
require_once("jstree/_inc/class.tree.php");
?>