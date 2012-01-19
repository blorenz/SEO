<h3>Step 1: Select Auction</h3>
<p>Select the auction that you wish to submit for arbitration by clicking the appropriate auction below.  Only auctions that have ended within the past 30 days are eligible for arbitration, auctions older than that are not shown.</p>
<?php







$sql = "SELECT a.id AS auc_id, a.title, b.current_bid, a.id AS seller_d_id, d.dba, MIN(p.id) as photo,"
		  . " a.ends, a.starts"
        . " FROM auctions a, bids b, dealers d, photos p"
        . " WHERE a.winning_bid = b.id AND a.dealer_id = d.id AND"
		  . "	a.status = 'closed' AND a.chaching =1 AND b.dealer_id = '$_SESSION[dealer_id]' AND"
		  . " a.vehicle_id = p.vehicle_id AND a.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)"
		  . " GROUP BY a.id ORDER BY a.ends DESC";

$res = db_do($sql);

setlocale(LC_MONETARY, 'en_US');

while ($row = mysql_fetch_assoc($res)) {
   ?>
   <form method="POST" id="auc<?php echo $row['auc_id']?>">
	<input type="hidden" name="arb_step" value="2" />
   <input type="hidden" name="arb_auction" value="<?php echo $row['auc_id']?>" />

   <table class="arbitration_auction"
   	onclick="javascirpt: document.getElementById('auc<?php echo $row['auc_id']?>').submit();">
   	<tr>
   		<td rowspan="4">
   			<img src="/auction/uploaded/thumbnails/<?php echo $row['photo'] ?>.jpg" />
   		</td>
   	</tr>
   	<tr>
   		<td>
   			<b><?php echo $row['title'] ?></b>
   		</td>
   		<td style="text-align: right; font-size: 80%;">
   			Auction <?php echo $row['auc_id']; ?>
   		</td>
   	</tr>
   	<tr>
   		<td colspan="2">
   			Bought From: <b><?php echo $row['dba']; ?></b> for
   			<b><?php echo money_format('%.2n', $row['current_bid']); ?></b>
   		</td>
   	</tr>
   	<tr>
   		<td>Started: <b><?php echo date("m/d/Y", strtotime($row['starts'])); ?></b></td>
   		<td>Ended: <b><?php echo date("m/d/Y", strtotime($row['ends'])); ?></b></td>
   	</tr>
   </table>

   </form>
   <?php
}
?>
