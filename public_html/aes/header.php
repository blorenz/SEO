<?php
/**
* controls the links at the top of the AE pages
*
* $Id: header.php 370 2006-07-17 21:18:57Z dsmalley $
*
**/
?>

<script language="JavaScript" type="text/JavaScript">
function ChooseMenu(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;}
</script>

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


resetCounter();

</script>

<map name="homenav">
 <area shape="rect" coords="32,32,306,64" href="/">
</map>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td><img src="/images/i1_aes.gif" height="78" width="738" border="0" ismap usemap="#homenav" /></td>
  <td width="100%" background="/images/i2.gif">&nbsp;</td>
 </tr>
</table>
<table bgcolor="#000066" border="0" cellspacing="0" cellpadding="3" width="100%">
      <tr>
       <td width="20%"><font color="#FFFFFF" size="-1"><?php echo date("M j, Y g:i A T"); ?></font></td>
       <td align="center" class="menu" width="60%"><font color="#FFFFFF">
		[ <a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/aes/index.php">AE
		Home</a> |
		<a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/aes/message">Send
		a Message</a> |
		<a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/aes/tools">Online
		Tools</a> | <a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/aes/help/index.php">Help</a> |	   <a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/auction/logout.php">LOGOUT</a> ]</font></td>
       <td align="right" width="20%"><font color="#FFFFFF" size="-1">Logged in as <?=$username?>
	   <script language="Javascript1.2">document.write('<span id="session_time"></span><br>');
	   </script>

	   </font></td>
      </tr>
</table>