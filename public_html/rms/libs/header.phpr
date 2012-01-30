<?php 

// set the include path
set_include_path(get_include_path() . PATH_SEPARATOR . 
	$_SERVER['DOCUMENT_ROOT'] . '/rms/libs/');
	
include 'constants.php';

function __autoload($class_name)
{
   $class = strtolower(substr($class_name, 5));
   require_once("$class.class.php");
}

ob_start();

session_name('gdtd');
session_start();

if (empty($_SESSION)) {
   header("Location: http://$_SERVER[SERVER_NAME]/");
   die();
}

try {
	$rm = new gdtd_rm($_SESSION['userid']);
} 
catch (Exception $e) {
   header("Location: http://$_SERVER[SERVER_NAME]/auction/logout.php");
   die();
}
if ($_SESSION['access_level'] < 3) {
   header("Location: http://$_SERVER[SERVER_NAME]/auction/");
   die();
}

$start_time = microtime(true);
$GLOBALS['queries'] = 0;

?>

<html>
<head>
   <title><?php echo 'GDTD ' . L3_NAME . ' : ' . $_pagetitle; ?></title> 
   <link rel="stylesheet" href="/site.css" type="text/css" media="screen" />
   <link rel="stylesheet" href="<?php echo L3_CSSDIR . '/managers.css'; ?>" 
   	type="text/css" media="screen" />

   <script language="Javascript1.2"> 
   var check = 1800;

   function countDown(){ 
      var minute=Math.ceil(check/60);
      if (check>0) {
         check--;
      }
      session_time.innerHTML = (" (min. left: "+minute+")");
      setTimeout("countDown()",1000);		
   } 

   function resetCounter() {
      check=1800;
      setTimeout("countDown()",1000);
   }
   </script>


</head>

<body onload="javascript: resetCounter();">

<map name="homenav">
 <area shape="rect" coords="32,32,306,64" href="/">
</map>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td><img src="/images/i1_dms.gif" height="78" width="738" border="0" ismap usemap="#homenav" /></td>
  <td width="100%" background="/images/i2.gif">&nbsp;</td>
 </tr>
</table>
<table bgcolor="#000066" border="0" cellspacing="0" cellpadding="3" width="100%">
      <tr>
       <td width="20%"><font color="#FFFFFF" size="-1"><?php echo date("M j, Y g:i A T"); ?></font></td>
       <td align="center" class="menu" width="60%"><font color="#FFFFFF">
		[ <a class="menu" href="http://<?php echo $_SERVER[SERVER_NAME]?>/auction/index.php">Auction Home</a> |
		<a class="menu" href="http://<?php echo $_SERVER[SERVER_NAME]?>/rms/index.php"><?php echo L3_NAME; ?> Home</a> |
		<a class="menu" href="http://<?php echo $_SERVER[SERVER_NAME]?>/auction/logout.php">Logout</a> ]</font></td>
       <td align="right" width="20%"><font color="#FFFFFF" size="-1">Logged in as <?php echo $_SESSION['username']; ?>
	   	<script language="Javascript1.2"> 
		document.write('<span id="session_time"></span><br>');
		</script>
	   </font></td>
      </tr>
</table>

<div class="ie_center">
<div id="l3_nav">
	<b><?php echo L3_NAME; ?></b><br />
	<span class="nav">
	<a href="my_dms.php">My DMs</a> | 
	<a href="dm_stats.php">DM Stats</a> |
	<a href="sorry.php">My Stats</a> |  
	<a href="sendMessage.php">Send Messages</a> | 
	<a href="tools.php">RM Tools</a>
	</span>
</div>
</div>

<div id="page_content">
