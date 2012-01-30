<?php

include '/sites/production/include/db.php';

db_connect();

$username = 'tmccarthy';

$dmid = findDMid($username);


print_r(findAEforDM($dmid));

$array = findAEforDM($dmid);

$check = false;
foreach($array as $aeid) {
   print_r(findDEALERforAE($aeid));

}



?>
