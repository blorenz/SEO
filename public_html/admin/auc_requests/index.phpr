<?php

$dbh = new PDO('mysql:host=localhost;dbname=godealertodealer','gdtd','gdtdJiL');
$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);


include('../../../include/db.php');
extract(defineVars("SERVER_NAME", "from_dealer", "to_dealer", "invalid_dealer")); //JJM 5/8/2010


// MYSQL didn't want to play ball with the inner joins, so we're doing it
// the old way.

$sql = "SELECT ra.id, d1.dba AS 'from_dealer', d1.id AS 'from_did',
d2.dba as 'to_dealer', d2.id as 'to_did',
CONCAT(u.first_name, ' ', u.last_name) AS username, v.year, v.make, v.model, v.id AS vid
FROM request_auction ra, vehicles v, users u, dealers d1, dealers d2
WHERE v.id = ra.vehicle_id
AND d1.id = ra.dealer_id
AND d2.id = v.dealer_id
AND u.id = ra.user_id";

$count_sql = "SELECT COUNT(*) FROM request_auction";

if (!empty($_GET['from_dealer'])) {
   $q = $dbh->prepare("SELECT id FROM dealers WHERE id = :id");
   $q->bindParam(":id", $_GET['from_dealer']);
   $q->execute();

   $row = $q->fetchAll(PDO::FETCH_ASSOC);

   $dealer_id = $row[0]['id'];

   if ($dealer_id != $_GET['from_dealer']) {
      $invalid_dealer = true;
   } else {
      $sql .= " AND d1.id = '$_GET[from_dealer]'";
   }
}

if (!empty($_GET['to_dealer'])) {
   $q = $dbh->prepare("SELECT id from dealers WHERE id = :id");
   $q->bindParam(":id", $_GET['to_dealer']);
   $q->execute();

   $row = $q->fetchAll(PDO::FETCH_ASSOC);

   $dealer_id = $row[0]['id'];

   if ($dealer_id != $_GET['to_dealer']) {
      $invalid_dealer = true;
   } else {
      $sql .= " AND d2.id = '$_GET[to_dealer]'";
   }
}

$sql .= " ORDER BY d2.dba";

$dealers_sql = "SELECT d.id, d.dba FROM dealers d
               WHERE d.status='active' ORDER BY dba";


$req_query = $dbh->prepare($sql);
$dealers_query = $dbh->prepare($dealers_sql);
$count_query = $dbh->prepare($count_sql);

$count_query->execute();
$count = $count_query->fetchColumn();
?>
<html>
   <head>
      <title>Administration: Auction Requests</title>
      <script src="/sorttable.js"></script>
      <link type="text/css" href="../../site.css" rel="stylesheet" />
   </head>
   <body style="margin: 0;">
      <?php include('../header.php'); ?>

      <center>
         <h1>Auction Requests (<?php echo $count; ?>)</h1>

         <?php
         if ($invalid_dealer) :
            ?>
`           <div style="background: grey; border: 2px solid scarlet;">
            <h1>Invalid parameters -- stop messing around!</h1>
            <p>Invalid values for: <b>dealer</b> (valid values: any existant dealer id)
            </div>
            <?php
            die();
         endif;
         ?>

         <div id="menu">
        		<form name="dealers" method="GET">

            <b>From Dealer:</b> <select name="from_dealer">
               <option value="">(Any Dealer)</option>
               <?php

               $dealers_query->execute();

               while ($row = $dealers_query->fetch(PDO::FETCH_ASSOC)) :
                  ?>
                  <option value="<?php echo $row['id']?>" <?php if ($from_dealer== $row['id']) echo 'selected="selected"' ?>>
                     <?php echo $row['dba']?>
                  </option>
                  <?php
               endwhile;
               ?>
            </select>

            <b>To Dealer:</b> <select name="to_dealer">
               <option value="">(Any Dealer)</option>
               <?php
               $dealers_query->execute();

               while ($row = $dealers_query->fetch(PDO::FETCH_ASSOC)) :
                  ?>
                  <option value="<?php echo $row['id']?>" <?php if ($to_dealer == $row['id']) echo 'selected="selected"' ?>>
                     <?php echo $row['dba']?>
                  </option>
                  <?php
               endwhile;
               ?>
            </select>

            <input type="submit" value="Filter" />
            </form>
         </div>

         <table style="width: 90%; margin-top: 1em" class="sortable" id="tab1">
            <tr>
               <th>ID</th>
               <th>Sending Dealership</th>
               <th>Sending User</th>
               <th>Receiving Dealership</th>
               <th>Vehicle Info</th>
            </tr>

            <?php
            $req_query->execute();

            if ($req_query->errorCode() != PDO::ERR_NONE) {
               $err = $req_query->errorInfo();
               throw new Exception($err[2]);
            }

            $alt = false;
            while ($row = $req_query->fetch(PDO::FETCH_ASSOC)) :
               $alt = !$alt;
            ?>

            <tr <?php if ($alt) echo 'style="background: #ddd"'; ?>>
               <td><?php echo $row['id']; ?></td>
               <td><a href="http://<?php echo $SERVER_NAME?>/admin/dealers/index.php?category=Dealer_ID&search=<?php echo $row['from_did']?>&filter=true">
               <?php echo $row['from_dealer']; ?></a></td>
               <td><?php echo $row['username']; ?></td>
               <td><a href="http://<?php echo $SERVER_NAME?>/admin/dealers/index.php?category=Dealer_ID&search=<?php echo $row['to_did']?>&filter=true">
               <?php echo $row['to_dealer']; ?></a></td>
               <td><a href="../dealers/view.php?vid=<?php echo $row['vid']; ?>&did=<?php echo $row['to_did']; ?>">
					<?php echo "$row[year] $row[make] $row[model]" ?></a></td>
            </tr>

            <?php
            endwhile;
            ?>
        </table>

      </center>
   </body>
</html>
