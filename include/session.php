<?php

/**
* session functions and site setup
* I think
*
* $Id: session.php 562 2006-09-21 20:17:49Z kaneda $
*
**/
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT']; //JJM Added 9/19/2009
$PHP_SELF = $_SERVER['PHP_SELF']; //JJM Added 1/4/2010
include("$DOCUMENT_ROOT/../include/defs.php");
include_once("$DOCUMENT_ROOT/../include/defineVars.php");    // RJM added for checking the variables. 12.29.09

extract(defineVars( "q",  "no_menu"));    // Added by RJM 1/4/10

date_default_timezone_set('America/New_York');

// define the default include path
$path = "$_SERVER[DOCUMENT_ROOT]/../include/";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// set session_start() after session_set_cookie_params(), 'cause the manual says to.
// kaneda, 20060315

session_name('gdtd');
//session_set_cookie_params(1800); //JJM temporarily commented out.  this should prevent the 30 minute logout  -- testing the line below instead
ini_set("session.cookie_lifetime", "1800");
session_start();
// Reset the expiration time upon page load //session_name() is default name of session PHPSESSID  //JJM Testing 6/17/2010
if (isset($_COOKIE[session_name()])) setcookie(session_name(), $_COOKIE[session_name()], time() + 30 * 60, "/");

extract($_SESSION); //JJM added, because many references are used throught the code without explicitly calling $_SESSION


function decode_privs ($str) {
        return (empty($str)) ? array() :explode(',', $str);
}

function encode_privs ($a) {
        return implode(',', $a);
}

function has_priv ($str, $a) {
        return in_array($str, $a);
}

if(empty($skip_privs))
	$skip_privs = false;


if ((!$skip_privs && empty($_SESSION['username'])) ||
    (!empty($need_priv) && !has_priv($need_priv, $_SESSION['privs']))) {
	$destination = $_SERVER['REQUEST_URI'];
	session_register('destination');

        header("Location: http://$_SERVER[SERVER_NAME]/");
        exit;
}
?>
