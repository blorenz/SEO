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
# $srp: godealertodealer.com/htdocs/auction/vehicles/remove.php,v 1.9 2002/10/14 22:01:15 steve Exp $
#

include('../../../include/session.php');
include('../../../include/db.php');
include('_requests.php');
db_connect();

if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}

$page_title = 'Remove Item';
$help_page = "chp6_create.php";

if (isset($_REQUEST['id']))
	$id = $_REQUEST['id'];

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

$result = db_do("SELECT auctions.status FROM vehicles, auctions
				WHERE auctions.vehicle_id=vehicles.id AND vehicles.dealer_id='$dealer_id' AND vehicles.status!='inactive'
				AND vehicles.id='$id' ORDER BY auctions.created DESC LIMIT 1");
list($status) = db_row($result);
if ($status=='open' || $status=='pending') {
	header('Location: index.php');
	exit;
}

if (isset($_REQUEST['submit'])) {
        if ($_REQUEST['confirm'] == 'yes') {


            notify_requesters($id);


            db_do("UPDATE vehicles SET status='inactive' WHERE id='$id'");

				$result_offer = db_do("SELECT id FROM alerts WHERE vehicle_id='$id' and status='pending' AND title != 'Auction Request'");
				if (db_num_rows($result_offer) > 0) {

					$result_alert = db_do("SELECT auction_id, to_user, from_user FROM alerts WHERE vehicle_id='$id'");
					while(list($alert_auction_id, $to_user, $from_user) = db_row($result_alert)) {
					   $sq = "SELECT year, make, model FROM vehicles v, auctions a
                          WHERE a.id = '$alert_auction_id' AND v.id = a.vehicle_id";
                  $data = mysql_fetch_assoc(mysql_query($sq));

						$msg = "Auction # $alert_auction_id is no longer available for make offer.

Year:  $data[year]
Make:  $data[make]
Model: $data[model]

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

						if ($from_user > 0) {
							$result_email = db_do("SELECT email FROM users WHERE id='$from_user'");
							list($from_user_email) = db_row($result_email);
							mail($from_user_email, 'Make Offer ended for auction #' . $alert_auction_id, $msg, $EMAIL_FROM);
							db_free($result_email);
						}
						if ($to_user > 0) {
							$result_email = db_do("SELECT email FROM users WHERE id='$to_user'");
							list($to_user_email) = db_row($result_email);
							mail($to_user_email, 'Make Offer ended for auction #' . $alert_auction_id, $msg, $EMAIL_FROM);
							db_free($result_email);
						}
					}
				}

				db_do("UPDATE alerts SET status='remove' WHERE vehicle_id='$id'");

		}

        header('Location: index.php');
        exit;
}

$result = db_do("SELECT short_desc, make, model, year, vin FROM vehicles WHERE id='$id'");

if (db_num_rows($result) <= 0) {
        header('Location: index.php');
        exit;
}

list($short_desc, $make, $model, $year, $vin) = db_row($result);
db_free($result);

include('../header.php');
?>
  <br>

<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <center>
   <div class="error">Are you sure you want to remove this item?</div>
   <form action="<?= $PHP_SELF; ?>" method="POST">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <input type="radio" name="confirm" value="yes">Yes <input type="radio" name="confirm" value="no" checked onclick="return goElsewhere('index.php');">No<br><p><input type="submit" name="submit" value=" Remove Item "></p>
   </form>
  </center>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td align="right" class="header">Item Name:</td>
    <td class="normal"><?php tshow($short_desc); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Manufacturer:</td>
    <td class="normal"><?php tshow($make); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Model:</td>
    <td class="normal"><?php tshow($model); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Year:</td>
    <td class="normal"><?php tshow($year); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">VIN:</td>
    <td class="normal"><?php tshow($vin); ?></td>
   </tr>
  </table>

<?php
include('../footer.php');
db_disconnect();
?>
