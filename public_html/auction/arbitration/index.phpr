<?php
include($_SERVER['DOCUMENT_ROOT'] . '/../include/session.php');  //JJM 1/12/2010  Had to put ticks around DOCUMENT_ROOT in the square brackets... missing
include($_SERVER['DOCUMENT_ROOT'] . '/../include/db.php'); //JJM 4/10/2010
extract(defineVars("id")); //JJM added

db_connect();

$no_menu = 1;
$page_title = "Arbitration Claim";
$help_page = "chp10.php";
include('../header.php');

?>

<style type="text/css">
table.arbitration_auction {
	background: transparent;
	border: 1px solid black;
   width: 500px;
}

table.arbitration_auction:hover {
	background: lightgreen;
	border: 1px solid darkgreen;
	cursor: pointer;
}
</style>




<!--	RANDY COMMENTED THIS OUT	 <table border="0" cellspacing="0" cellpadding="0" width="18%" bgcolor="#EEEEEE" align="left">
							 <tr>
							 <td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>My Control Panel</b></font></td>
 						</tr>
 						<tr>
 							  <td class="normal">     ILANA<?php include('../_menu.php'); ?></td>
 							</tr>
						</table>
-->

<div style="padding: 5px; font-size: 90%;">


<h2 class="head">File an Arbitration Claim</h2>
<center>

<?php

function get_auction_start_date($id)
{
   $sql = "SELECT starts FROM auctions WHERE id = $id";
   $res = db_do($sql);
   $start = mysql_fetch_assoc($res);
   return $start['starts'];
}



// step 0: agree to the terms
if (empty($_POST['arb_step'])) {
   include('_start.php');
}

// step one: select the auction
elseif ($_POST['arb_step'] == 1) {
   include('_select.php');
}

elseif ($_POST['arb_step'] == 2) {

   if (!empty($_POST['arb_auction']) && !is_auctionid_valid($_POST['arb_auction'])) {
	   die("FATAL ERROR: Auction ID is not valid.");
	}

   include('_date.php');
}

elseif ($_POST['arb_step'] == 3) {

   if (strtotime($_POST['arb_recdate']) > strtotime('now')) {
   	die("FATAL: Date is not within bounds");
  	}

	include('_nature.php');
}

elseif ($_POST['arb_step'] == 4) {

   if (empty($_POST['arb_claim'])) {
      die("FATAL: No description provided.");
   }

	include('_resolution.php');
}

elseif ($_POST['arb_step'] == 5) {

   if (empty($_POST['arb_resolution'])) {
      die("FALAL: No resolution provided.");
   }
	include('_review.php');
}

elseif ($_POST['arb_step'] == 6) {
	include('_submit.php');
}

?>

</center>
</div>
<?php

include('../footer.php');

?>
