<?php

// $Id: db.php 354 2006-07-11 20:59:45Z kaneda $

define('DB_HOST',		'localhost');
//define('DB_NAME', 	'gdtdrestore');
define('DB_NAME',		'godealertodealer');
define('DB_PASSWORD',		'Gdtd6330');
define('DB_USER',		'godealertodealer');



function db_connect() {
	
	print "Connecting...<br/>";
        
        global $db;

        $db = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            or die("Unable to connect to the database server");
        mysql_select_db(DB_NAME, $db)
            or die("Unable to select the database");
}

function db_disconnect() {
	print "Disconnecting...<br/>";
        global $db;

        mysql_close($db);
}

?>
