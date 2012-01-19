<?php

include('../../../../include/defineVars.php');
extract(defineVars("dealer","from","limit"));       //JJM 9/9/2010

$dbh = new PDO('mysql:host=localhost;dbname=godealertodealer','gdtd','gdtdJiL');
$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

$valid_limit = array('10', '50');
$valid_from = array('top', 'bottom');

if (!empty($_GET['from']) && !in_array($_GET['from'], $valid_from)) {
   $invalid_from = true;
}

if (!empty($_GET['limit']) && !in_array($_GET['limit'], $valid_limit)) {
   $invalid_limit = true;
}

$sql = "SELECT u.username, CONCAT(u.first_name, ' ', u.last_name) as name, u.lastlogin, d.dba
   FROM users u, dealers d WHERE u.status='active' AND u.dealer_id = d.id";

if (!empty($_GET['dealer'])) {
   $q = $dbh->prepare("SELECT id, dba FROM dealers WHERE id = :id");
   $q->bindParam(":id", $_GET['dealer']);
   $q->execute();

   $row = $q->fetchAll(PDO::FETCH_ASSOC);

   $dealer_dba = $row[0]['dba'];
   $dealer_id = $row[0]['id'];

   if ($dealer_id != $_GET['dealer']) {
      $invalid_dealer = true;
   } else {
      $sql .= " AND d.id = '$_GET[dealer]'";
   }
}

if ($from == 'top') {
   $sql .= " ORDER BY lastlogin DESC";
} elseif ($from == 'bottom') {
   $sql .= " ORDER BY lastlogin ASC";
} elseif (empty($from)) {
   $sql .= " ORDER BY name";
}

if ($limit == '10') {
   $sql .= " LIMIT 10";
} elseif ($limit == '50') {
   $sql .= " LIMIT 50";
} elseif (empty($limit)) {
   $sql .= " LIMIT 10";
}

$users_query = $dbh->prepare($sql);


?>

<html>
   <head>
      <title>Administration: User Logins</title>
      <script src="/sorttable.js"></script>
      <link type="text/css" href="../../../site.css" rel="stylesheet" />
      <script type="text/javascript">
      function submit()
      {
        did = document.getElementById('selectDealer').value;
        url = 'http://<?php echo $_SERVER['SERVER_NAME']?>/admin/users/login/?dealer='+did;

        window.location=url;
      }
      </script>
   </head>
   <body style="margin: 0;">
      <?php include('../../header.php'); ?>

      <center>
         <h1>User Login Times</h1>

         <?php
         if ($invalid_limit || $invalid_from || $invalid_dealer) :
            ?>
`           <div style="background: grey; border: 2px solid scarlet;">
            <h1>Invalid parameters -- stop messing around!</h1>
            <p>Invalid values for:
            <?php if ($invalid_limit) : ?>
              <b>limit</b> (valid values: 10, 50)
            <?php endif; ?>
            <?php if ($invalid_from) : ?>
              <b>from</b> (valid values: top, bottom)
            <?php endif; ?>
            <?php if ($invalid_dealer) : ?>
              <b>dealer</b> (valid values: any existant dealer id)
            <?php endif; ?>
            </div>
            <?php
            die();
         endif;
         ?>

         <div id="menu">
            <b>Recent:</b> <a href="/admin/users/login/?limit=10&from=top">10</a>,
             <a href="/admin/users/login/?limit=50&from=top">50</a> |
            <b>Oldest:</b> <a href="/admin/users/login/?limit=10&from=bottom">10</a>,
             <a href="/admin/users/login/?limit=50&from=bottom">50</a> |
           <b>By Dealer:</b> <select name="dealer" id="selectDealer" onChange="javascript: submit();">
               <option value="">--Choose Dealer--</option>
               <?php
               $sql = "SELECT DISTINCT d.id, d.dba FROM dealers d
               INNER JOIN users u ON u.dealer_id = d.id AND u.status='active'
               WHERE d.status='active' ORDER BY dba";

               foreach ($dbh->query($sql) as $row) :
                  ?>
                  <option value="<?php echo $row['id']?>" <?php if ($dealer == $row['id']) echo 'selected="selected"' ?>>
                     <?php echo $row['dba']?>
                  </option>
                  <?php
               endforeach;
               ?>
            </select>

         </div>

         <table style="width: 90%; margin-top: 1em" class="sortable" id="tab1">
            <tr>
               <th>Username</th>
               <th>Real Name</th>
               <th>Dealership</th>
               <th>Last Login Time</th>
            </tr>

            <?php
            $users_query->execute();

            if ($users_query->errorCode() != PDO::ERR_NONE) {
               $err = $users_query->errorInfo();
               throw new Exception($err[2]);
            }

            $alt = false;
            while ($row = $users_query->fetch(PDO::FETCH_ASSOC)) :
               $alt = !$alt;
            ?>

            <tr <?php if ($alt) echo 'style="background: #ddd"'; ?>>
               <td><?php echo $row['username']; ?></td>
               <td><?php echo $row['name']; ?></td>
               <td><?php echo $row['dba']; ?></td>
               <td>
               <?php
                  if ($row['lastlogin'] == '') {
                     echo "N/A";
                  } else {
                     echo date('j M Y H:i',
                      strtotime($row['lastlogin']));
                  }
               ?>
               </td>
            </tr>

            <?php
            endwhile;
            ?>
        </table>

      </center>
   </body>
</html>
