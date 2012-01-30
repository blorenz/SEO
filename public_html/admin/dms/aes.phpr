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
# $srp: godealertodealer.com/htdocs/admin/aes/index.php,v 1.1 2002/10/15 05:27:55 steve Exp $
#

include('../../../include/db.php');
db_connect();

extract(defineVars("s","dir","sort","status","trans_comm","signup_comm","filter",
				   "Firstname","Lastname","Email","Phone","Fax","search","category",
				   "ae_id"));  //JJM 08/30/2010

if (empty($s))
	$status = 'active';
else
	$status = $s;

if (empty($dir))
	$dir = 'asc';

if($dir == 'asc')
{
  $otherdir = 'desc';
}
else
{
  $otherdir = 'asc';
}

if(!empty($_REQUEST['sort']))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "first_name, last_name";


$page_title = ucfirst($status) . ' Account Executives';

if(isset($_POST['trans_comm']))
{
  $result = db_do('UPDATE aes SET commission_percentage="' . $trans_comm . '", signup_percentage="' . $signup_comm . '" WHERE id="' . $ae_id . '"');
}

if(empty($filter))
{
	$sql = "SELECT id, email, CONCAT(first_name, ' ', last_name), " .
    	"phone, fax, commission_percentage, signup_percentage FROM aes WHERE status='$status' AND dm_id='$id'";
}
else
{
    $field = $$category;
	$sql = "SELECT id, email, CONCAT(first_name, ' ', last_name), " .
    	"phone, fax, commission_percentage, signup_percentage FROM aes WHERE status='$status' AND dm_id='$id' " .
    	"AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT id, email, CONCAT(first_name, ' ', last_name), " .
    	"phone, fax, commission_percentage, signup_percentage FROM aes WHERE status='$status' AND dm_id='$id' " .
    	"ORDER BY $SortListBy $dir " .
    	"LIMIT $_start, $limit");
}
else
{
    $field = $$category;
	$result = db_do("SELECT id, email, CONCAT(first_name, ' ', last_name), " .
    	"phone, fax, commission_percentage, signup_percentage FROM aes WHERE status='$status' AND dm_id='$id' " .
    	"AND $field LIKE \"%$search%\" " .
    	"ORDER BY $SortListBy $dir " .
    	"LIMIT $_start, $limit");
}

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
    <input type="hidden" name="Firstname" value="first_name" />
    <input type="hidden" name="Lastname" value="last_name" />
    <input type="hidden" name="Email" value="email" />
    <input type="hidden" name="Phone" value="phone" />
    <input type="hidden" name="Fax" value="fax" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Firstname</option><option>Lastname</option><option>Email</option><option>Phone</option><option>Fax</option></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No account executives found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=first_name&dir=<?php if($sort == 'first_name') { echo $otherdir; } else { echo $dir; } ?>">Name</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=email&dir=<?php if($sort == 'email') { echo $otherdir; } else { echo $dir; } ?>">Email</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>">Phone</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=fax&dir=<?php if($sort == 'fax') { echo $otherdir; } else { echo $dir; } ?>">Fax</a></b></td>
    <td class="header"><b>Trans</b></td>
    <td class="header"><b>Signup</b></td>
    <td class="header">&nbsp;</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $email, $name, $phone, $fax, $commission_percentage, $signup_percentage)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><form method="post" action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>"><input type="hidden" name="ae_id" value="<?php echo $id; ?>" />
    <a href="/admin/aes/edit.php?id=<?php echo $id; ?>">edit</a> | <a href="/admin/aes/accounts.php?id=<?php echo $id; ?>">accounts</a></td>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($email); ?>"><?php tshow($email); ?></a></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($fax); ?></td>
    <td class="normal"><input type="text" size="5" maxlength="20" name="trans_comm" value="<?php echo $commission_percentage; ?>" /></td>
    <td class="normal"><input type="text" size="5" maxlength="20" name="signup_comm" value="<?php echo $signup_percentage; ?>" /></td>
    <td class="normal"><input type="submit" value="Update"></form></td>
   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
 </body>
</html>

<?php
?>
