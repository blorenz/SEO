<?php
// $Id$

function getDatabaseHandle() 
{
   $dsn = "mysql:host=localhost;dbname=gdtdtest";
	$user = 'gdtdtest';
	$pass = 'tenjorchler';
   
   return new PDO($dsn, $user, $pass); 
}
?>