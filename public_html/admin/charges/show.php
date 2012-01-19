<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/admin/charges/dealer.php,v 1.4 2002/09/03 00:36:09 steve Exp $
#

if (empty($id) || $id <= 0) {
	header('Location: ../dealers/index.php');
	exit;
}

$page_title = 'Update Charges';


include('../../../include/db.php');
db_connect();

if (isset($submit_confirm)) {
	if ($confirm == 'yes') {	
		$pieces = explode(",", $pid);
			foreach($pieces as $value)
				db_do("UPDATE charges SET status='closed' WHERE " .
				    "id='$value'");	
	}	
	
	header('Location: /admin/dealers');
	db_disconnect();
	exit;


}

include('../header.php');

$paid_new = $paid;

$result = db_do("SELECT name FROM dealers WHERE id='$id'");
list($dealer) = db_row($result);
db_free($result);

$paid_new = implode(",", $paid);
	
	
?>

<html>
<head>
<title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>

 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <br />
  <p align="center" class="big"><b>Update charges for <a href="../dealers/edit.php?id=<?php echo $id; ?>"><?php echo $dealer; ?></b></a></p><br><br>
  <center>
   <div class="big">Are you sure you want to update these charges?</div>
   <form action="<?= $PHP_SELF; ?>" method="POST">
	<input type="hidden" name="id" value="<?= $id; ?>">
	<input type="hidden" name="pid" value="<?= $paid_new; ?>">
    <input type="radio" name="confirm" value="yes">Yes 
    <input type="radio" name="confirm" value="no" checked>No<br><p>
    <input type="submit" name="submit_confirm" value=" Update Charges "></p>
   </form>
  </center><br><br>
  
  	<br>  
  <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tr> 
     <td class="header">Invoice Number</td>
     <td align="right" class="header"><b>Fee (US $)</b></td>
     <td class="header"><b>Auction Title</b></td>
     <td class="header"><b>Auction #</b></td>
     <td align="center" class="header"><b>Dealership</b></td>
     <td class="header"><b>Pull Type</b></td>
    </tr>

<?php
$count = 0;

if (is_array($paid)) {
	while (list(, $cid) = each($paid)){

$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, " .
    "charges.dealer_id, charges.fee, DATE_FORMAT(charges.created, '%Y%m%d'), " .
    "dealers.name, charges.fee_type FROM auctions, charges, dealers WHERE " .
    "charges.id='$cid' AND " .
    "charges.auction_id=auctions.id AND " .
    "charges.dealer_id=dealers.id ORDER BY charges.created");
    
    	list($title, $cid, $aid, $did, $fee, $created, $dealer, $type) = db_row($result);
		$invoice_num = "$created-$cid";

     	if (isset($pull_type_old))
     		if ($pull_type_old != $type)
     		{
     		?>
     			    <tr> 
				     <td></td>
				     <td></td>
				     <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
				    </tr>
			<?php
			}
?>
    <tr> 
     <td class="normal"><?php echo $invoice_num; ?></td>
     <td align="right" class="normal"><?php tshow($fee); ?></td>
     <td class="normal"><a href="../../auction/auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
     <td align="center" class="normal"><?php echo $aid; ?></td>
     <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dealer); ?></a></td>
     <td align="center" class="normal"><?php tshow(ucfirst($type)); ?></td>
    </tr>

<?php
	db_free($result);
	}
?>
</table>

<?php
db_disconnect();
}
?>

</html>