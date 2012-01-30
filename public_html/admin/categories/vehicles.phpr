<?php
/**
* Controls the categories administration section
*
* $Id$
*/

$categories_done = array();

function getMakeOptions($parent_id)
{

   global $categories_done;

   if (isset($categories_done[$parent_id]['html'])) {
      return $categories_done[$parent_id]['html'];
   }

   $sql = "SELECT id, name FROM categories WHERE parent_id =
      '$parent_id' AND subparent_id = 0 ORDER BY name";
   $results = db_do($sql);

   $html = '';
   while ($row = mysql_fetch_assoc($results)) {
      $html .= "<option value=\"$row[id]\">$row[name]</option>\n";
   }

   $categories_done[$parent_id]['html'] = $html;

   return $html;

}

function getModelOptions($parent_id, $subparent_id)
{
   global $categories_done;

   if (isset($categories_done[$parent_id][$subparent_id]['html'])) {
      return $categories_done[$parent_id][$subparent_id]['html'];
   }

   $sql = "SELECT id, name FROM categories WHERE subparent_id =
      '$subparent_id' ORDER BY name";
   $results = db_do($sql);

   $html = '';
   while ($row = mysql_fetch_assoc($results)) {
      $html .= "<option value=\"$row[id]\">$row[name]</option>\n";
   }

   $categories_done[$parent_id][$subparent_id]['html'] = $html;

   return $html;
}

$page_title = 'Manage Erroneous Vehicles';

include('../../../include/db.php');

db_connect();


if (isset($_POST['submit'])) {
   echo '<pre>';
   print_r($_POST);
   echo '</pre>';
   die();
}
$sql = "SELECT v.id, CONCAT(year, ' ', make, ' ', model) AS type,
   v.category_id, v.subcategory_id1, v.subcategory_id2, c.name
FROM vehicles v, categories c
WHERE v.subcategory_id2 = c.id
AND v.category_id = 16
AND c.name <> v.model
ORDER BY id";

$results = db_do($sql);

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>

 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
 <table>
   <tr>
      <th>ID</th>
      <th>Type</th>
      <!-- <th>Make</th> -->
      <th>Model</th>
   </tr>
 <?php
   while ($row = mysql_fetch_assoc($results)) {
      ?>
   <tr>
      <td><?php echo $row['id'] ?></td>
      <td><?php echo $row['type']?> </td>
      <?php /*
      <td>
         <select name="<?php echo $row['id']?>_make">
            <?php
            $makedata = getMakeOptions($row['category_id']);

            echo $makedata;

            ?>
         </select>
      </td>
      */ ?>
      <td>
         <select name="<?php echo $row['id']?>_model">
            <?php
            $modeldata = getModelOptions(
                  $row['category_id'], $row['subcategory_id1']);

            echo $modeldata;

            ?>
         </select>
      </td>
      <?php
   }
 ?>
 </tr>
 <tr>
   <td colspan="5"><input type="submit" name="submit" value="Update Vehicles" /></td>
 </tr>
 </table>

 </body>
</html>
