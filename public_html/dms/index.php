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
# $srp: godealertodealer.com/htdocs/aes/index.php,v 1.21 2002/10/08 05:42:49 steve Exp $
#

include('../../include/session.php');
include('../../include/db.php');
db_connect();

$no_menu = 1;
$page_title = "District Manager Summary";
$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$num_auctions     = 0;
$pending_auctions = 0;
$open_auctions    = 0;
$closed_auctions  = 0;
$pulled_auctions  = 0;

#Auction Query with Totals
$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id and auctions.status='open'");
list($open_auctions) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id and auctions.status='pending'");
list($pending_auctions) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='closed' AND auctions.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
list($closed_auctions) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id and auctions.chaching=1 
				and auctions.status='closed' AND auctions.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
list($closed_auctions_with_sale) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='pulled' AND auctions.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
list($pulled_auctions) = db_row($result);

$num_auctions = + $pending_auctions + $open_auctions + $closed_auctions + $pulled_auctions;
	
db_free($result);

$num_dealers		= 0;
$pending_dealers	= 0;
$active_dealers		= 0;
$suspended_dealers	= 0;
$saved_dealers		= 0;

#Dealers Query with Totals
$result = db_do("SELECT dealers.status FROM dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id ");
		
while (list($status) = db_row($result)) {
	$num_dealers++;

	switch ($status) {
	case 'pending':
		$pending_dealers++;
		break;
	case 'active':
		$active_dealers++;
		break;
	case 'suspended':
		$suspended_dealers++;
		break;
	case 'saved':
		$saved_dealers++;
		break;		
	}
}
db_free($result);

#Closed auctions with sale
$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='closed' AND auctions.current_bid >= auctions.reserve_price");
		
list($num_sales) = db_row($result);
db_free($result);

#Closed auctions without sale
$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='closed' AND auctions.current_bid < auctions.reserve_price");
list($num_no_sales) = db_row($result);
db_free($result);

#Paid Charges (US $)
#$result = db_do("SELECT SUM(charges.fee) FROM charges, dms, aes, dealers, users 
#				WHERE users.username = '$username' and dms.user_id = users.id and dms.id = aes.dm_id
#				and dealers.ae_id = aes.id and charges.dealer_id = dealers.id and charges.status='closed'");
#list($paid_fees) = db_row($result);
#db_free($result);
#
#$paid_fees = number_format($paid_fees, 2);

#Unpaid Charges (US $)
$result = db_do("SELECT SUM(charges.fee) FROM charges, dms, aes, dealers, users 
				WHERE users.username = '$username' and dms.user_id = users.id and dms.id = aes.dm_id
				and dealers.ae_id = aes.id and charges.dealer_id = dealers.id and charges.status='open'");
list($unpaid_fees) = db_row($result);
db_free($result);

$unpaid_fees = number_format($unpaid_fees, 2);

#Auctions closing in next 24 hours
$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id and dealers.id=auctions.dealer_id
				and dealers.ae_id = aes.id and auctions.status='open' AND auctions.ends <= DATE_ADD(NOW(), INTERVAL 1 DAY)");
list($closing_soon) = db_row($result);
db_free($result);

#Auctions closed in last 24 hours
$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id and dealers.id=auctions.dealer_id
				and dealers.ae_id = aes.id and auctions.status='closed' AND auctions.ends >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
list($recent_closings) = db_row($result);
db_free($result);

#Auctions opening in next 24 hours
$result = db_do("SELECT COUNT(*) FROM auctions, dms, aes, dealers, users 
				WHERE users.username='$username' and dms.user_id=users.id and aes.dm_id=dms.id and dealers.id=auctions.dealer_id
				and dealers.ae_id = aes.id and auctions.status='pending' AND auctions.starts <= DATE_ADD(NOW(), INTERVAL 1 DAY)");
list($opening_soon) = db_row($result);

db_free($result);
?>
<html>
 <head>
  <title><?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
	
		<!-- Left Column -->
		<td bgcolor="#EEEEEE" width="20%">
		<?php include('_alerts.php'); ?>
		</td>
		
		<!-- Middle Column -->
		<td valign="top" width="60%">			
			<table align="center" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td class="normal"><a href="auctions.php?s=pending">Auctions - Pending</a></td>
					<td align="right" class="normal"><b><?php echo $pending_auctions; ?></b></td>
				</tr>
				<tr>
					<td class="small">&nbsp;&nbsp;&nbsp;- <?php echo $opening_soon; ?> Opening Soon (next 24 hours)</td>
				</tr>
				<tr>
					<td class="normal"><a href="auctions.php?s=open">Auctions - Open</a></td>
					<td align="right" class="normal"><b><?php echo $open_auctions; ?></b></td>
				</tr>
				<tr>
					<td class="small">&nbsp;&nbsp;&nbsp;- <?php echo $closing_soon; ?> Closing Soon (next 24 hours)</td>
				</tr>
				<tr>
					<td class="normal"><a href="auctions.php?s=closed">Auctions - Closed (last 30 days)</a></td>
					<td align="right" class="normal"><b><?php echo $closed_auctions; ?></b></td>
				</tr>
				<!-- <tr>
					<td class="small">&nbsp;&nbsp;&nbsp;- Closed (in last 24 hours)</a></td>
					<td></td>
					<td align="right" class="small"><?php #echo $recent_closings; ?></td>
				</tr> -->
				<tr>
					<td class="small">&nbsp;&nbsp;&nbsp;- <?php echo $closed_auctions_with_sale; ?> Closed with sale (last 30 days)</a></td>
				</tr>
				<tr>
					<td class="normal"><a href="auctions.php?s=pulled">Auctions - Pulled (last 30 days)</a></td>
					<td align="right" class="normal"><b><?php echo $pulled_auctions; ?></b></td>
				</tr>
				<tr>
					<td class="header">Total Auctions</td>
					<td align="right" class="normal"><b><?php echo $num_auctions; ?></b></td>
				</tr>
				<tr><td colspan="2"><hr /></td></tr>
				<tr>
					<td class="normal"><a href="dealers/index.php?s=pending">Dealers - Pending</a></td>
					<td align="right" class="normal"><?php echo $pending_dealers; ?></td>
				</tr>
				<tr>
					<td class="normal"><a href="dealers/index.php?s=active">Dealers - Active</a></td>
					<td align="right" class="normal"><?php echo $active_dealers; ?></td>
				</tr>
				<tr>
					<td class="normal"><a href="dealers/index.php?s=suspended">Dealers - Suspended</a></td>
					<td align="right" class="normal"><?php echo $suspended_dealers; ?></td>
				</tr>
				<tr>
					<td class="normal"><a href="dealers/index.php?s=saved">Dealers - Saved</a></td>
					<td align="right" class="normal"><?php echo $saved_dealers; ?></td>
				</tr>
				<tr>
					<td class="header">Total Dealers</td>
					<td align="right" class="normal"><?php echo $num_dealers; ?></td>
				</tr>
				<tr><td colspan="2"><hr /></td></tr>
				<tr>
					<td class="normal">Unpaid Charges</td>
					<td align="right" class="normal">$<?php echo $unpaid_fees; ?></td>
				</tr>
			</table>
		</td>
		
		<!-- Right Column -->
		<td width="20%" valign="top" bgcolor="#EEEEEE">		
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
				 <td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>Internal News</b></font></td>
				</tr>
				<tr valign="top" BGCOLOR="#EEEEEE">
				 <td>
			<?php
			$result = db_do("SELECT id, title FROM internal_news WHERE status='active' ORDER BY created LIMIT 10");
			while(list($id, $title) = db_row($result))
				echo "      <font size=\"-1\"><a href=\"news.php?id=$id\">$title</a><br />\n";
			db_free($result);
			?>
				  </ul>
				 </td>
				</tr>
			   </table>
		</td>
		
	</tr>
</table>

<?php
db_disconnect();
include('footer.php');
?>