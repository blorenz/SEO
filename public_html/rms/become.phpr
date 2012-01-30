<?php

if (empty($_GET['id'])) {
   header("Location: http://$_SERVER[SERVER_NAME]/rms/");
   die();
}

include($_SERVER['DOCUMENT_ROOT'].'/../include/session.php');

include($_SERVER['DOCUMENT_ROOT'].'/../include/db.php');
db_connect();

$result = db_do("SELECT id, privs, dealer_id, username, access_level FROM users " .
    "WHERE id='$id'");
list($userid, $privs, $dealer_id, $username, $access_level) = db_row($result);

db_free($result);
db_disconnect();

$privs = decode_privs($privs);

session_register('dealer_id');
session_register('privs');
session_register('userid');
session_register('username');
session_register('access_level');

header("Location: http://$_SERVER[SERVER_NAME]/dms/index.php");
exit;
?>
