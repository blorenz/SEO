<?php

$page_title = "Unpaid Late Charges";

include('../../../include/db.php');
db_connect();

if (isset($_POST['submit'])) {
	if (is_array($_POST['paid'])) {
      foreach ($_POST['paid'] as $cid) {
			db_do("UPDATE charges SET status='closed' WHERE id='$cid'");
      }
	}
}

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
  <style type="text/css">
  div#latefees {
     font-size: 80%;
     font-family: arial, helvetica, sans-serif;
     text-align: center;
  }

  table#late {
     font-size: 100%;
  } 

  .important {
     border: 1px solid orange;
     font-weight: bold;
     background: yellow;
     width: 50%;
  }
  </style>
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?>
   
<?php

$sql = "SELECT c.id, c.fee, c.created, d.dba 
FROM charges c, dealers d
WHERE c.fee_type = 'late' AND d.id = c.dealer_id AND c.status = 'open'";

$results = db_do($sql);

if (mysql_num_rows($results) < 1) {
   ?>
   <center>
   <p class="important">No unpaid late fees.</p>
   </center>
   <?php
} else {
?>

<div id="latefees">
<center>

<form method="POST">
<table border="0" width="80%" id="late">
<tr style="background: #9999CC;">
   <th>Invoice No.</th>
   <th>Paid?</th>
   <th>Amount</th>
   <th>Dealership</th>
   <th>Date Posted</th>
</tr>

<?php $style = 'style="background: #ddd"'; ?>
<?php while ($charges = mysql_fetch_assoc($results)) { ?>

   <?php if ($style == 'style="background: #ddd"') {
      $style = '';
   } else {
      $style = 'style="background: #ddd"';
   }
?>

<tr <?php echo $style ?>>
   <td><?php echo date('Ymd') . "-$charges[id]" ?></td>
   <td>
      <input type="checkbox" name="paid[]" value="<?php echo $charges['id']?>" />
   </td>
   <td><?php echo $charges['fee'] ?></td>
   <td><?php echo $charges['dba'] ?></td>
   <td><?php echo date('m/d/Y', strtotime($charges['created'])) ?></td>
</tr>

<?php } ?>

<tr>
   <td colspan="5"><input type="submit" name="submit" value="Update Charges" />
   </td>
</tr>
</table>
</form>

</center>
</div>
<?php } ?>
</body>
</html>
