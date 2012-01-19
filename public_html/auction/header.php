<?php
/**
* $Id: header.php 509 2006-09-05 14:53:21Z dsmalley $
*/
$result = db_do("SELECT SUM(no_of_stores) FROM dealers WHERE status='active'");
list($num_users) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='closed'");
list($num_auctions) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM vehicles WHERE status='active'");
list($num_vehicles) = db_row($result);
db_free($result);
?>

<html>
 <head>


<?php if ($PHP_SELF == '/auction/auction.php') { ?>
  <meta http-equiv="Pragma" content="no-cache">


<?php } ?>
  <title><?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="/site.css" title="site" />
  <script type="text/javascript" language="JavaScript">
<!--
function goElsewhere(there) {
	window.location = there;
}
//-->
  </script>


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

function DisplayMessage(){
	document.getElementById("StatusLine").innerHTML = "<br><font size='+2' color='#0000FF'><b>Please Wait While the System Uploads Your Images...</b></font><br><br>(This may take several minutes depending on the speed of your Internet Connection and the size of the photos.)<br><br>"
}

function submit_vehicle_id()
{
   search_box = document.getElementById('search');
   v_id = search_box.value;
   window.location = "http://<?php echo $_SERVER['SERVER_NAME']?>/auction/vehicles/preview.php?id=" +  v_id;
}
</script>

 <style type="text/css">
<!--
.style1 {color: #000066}

.print {display: none;}
-->
  </style>
 </head>
 <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="resetCounter()">


 <div class="print" style="text-align: center;">
   <img src="/images/Logo-White.gif" alt="Go Dealer to Dealer" />
 </div>


  <map name="logo_map"><area shape="rect" coords="30,30,313,69" href="/auction/"></map>
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
   <tr>
    <td>
     <table border="0" cellspacing="0" cellpadding="0" width="100%" id="header_top">
      <tr>
       <td><img src="/images/i1.gif" height="78" width="738" border="0" usemap="#logo_map"></td>
       <td width="100%" background="/images/i2.gif">&nbsp;</td>
      </tr>
     </table>
     <table bgcolor="#000066" border="0" cellspacing="0" cellpadding="3" width="100%"
     id="header_nav">
       <tr>
       <td width="20%"><font color="#FFFFFF" size="-1"><?php echo date("M j, Y g:i A T"); ?></font>
	   </td>

       <td align="center" class="menu" width="53%"><font color="#FFFFFF">
        [&nbsp;<a class="menu" href="/auction/">HOME</a>&nbsp;|
<?php if (has_priv('sell', $privs)) { ?>
        <a class="menu" href="/auction/vehicles/index.php">CREATE AN AUCTION</a>&nbsp;|
<?php } ?>
        <a class="menu" href="../../docs/documents.php">HELP</a>&nbsp;|
		<a class="menu" href="/auction/feedback.php">CONTACT US</a>&nbsp;|
        <a class="menu" href="/auction/logout.php">LOGOUT</a>&nbsp;]
        </font></td>
       <td align="right" width="22%"><font color="#FFFFFF" size="-1">Logged in as <?=$username?>
	   <script language="Javascript1.2">
		document.write('<span id="session_time"></span><br>');
		</script>
		</font></td>
      </tr>
     </table>
   <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="5" width="100%" id="header_search">
      <tr>
         <td valign="top" cellspacing="0" cellpadding="0">
           <form action="/auction/advsearch.php" method="post">
            <input type="submit" value="Advanced Search" />
           </form>
         </td>
       <td valign="top">
			<form action="/auction/search.php" method="post">
				<input class="normal" type="text" name="q" value="<?=$q?>" size="25"
            style="border: 1px solid black" id="search">
				<input class="header" type="submit" name="submit" value="Search">
				<input class="header" type="submit" name="submit_id" value="Auction ID">
            <input class="header" type="button" value="Vehicle ID" onClick="javascript: submit_vehicle_id()" />
			</form>
       </td>
       <td align="right" valign="top"><font size="-1"><b><?=$num_users?></b>
	   	<font size="-2">DEALERS</font> | <b><?=$num_auctions?></b>
		<font size="-2">CLOSED AUCTIONS</font> | <b><?=$num_vehicles?></b>
		<font size="-2">ITEMS</font></font>&nbsp;&nbsp;<font color="#FFFFFF" size="-1">
		<a target="help" href="../../docs/<? echo $help_page?>"><img src="../../docs/help.gif" border="0" title="Online Help Document"></a></font><br>&nbsp;</td>
      </tr>
      <tr>
      </tr>
     </table>
<?php if (!$no_menu) { ?>
     <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr valign="top">
       <td bgcolor="#EEEEEE" width="20%" id="header_cpanel">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
         <tr>
          <td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>My Control Panel</b></font></td>
         </tr>
         <tr>
          <td class="normal"><?php include("$DOCUMENT_ROOT/auction/_menu.php"); ?></td>

        </tr>
        </table>

       </td>
       <td>
<?php } ?>
