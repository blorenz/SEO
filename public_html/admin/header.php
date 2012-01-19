<?php

$links = array(
    'Home'       => '/auction/index.php',
    'Admin'      => '/admin/index.php',
	'Auctions'   => '/admin/auctions/index.php',
	'Auction Requests' => '/admin/auc_requests/',
	'Charges'    => '/admin/charges/index.php',
   'Items'     =>  '/admin/items/index.php',
    'Fees'       => '/admin/fees/index.php',
    'Increments' => '/admin/increments/index.php',
	'Categories' => '/admin/categories/index.php',
	'Reg Codes'	 => '/admin/regcodes/index.php',
	'Help'       => '/admin/help/index.php',
    'Internal News' => '/admin/internalnews/index.php',
	'News'       => '/admin/news/index.php',
	'DMs'        => '/admin/dms/index.php',
	'AEs'        => '/admin/aes/index.php',
	'Dealers'    => '/admin/dealers/index.php',
    'Users'      => '/admin/users/index.php',
    'Feeds'    =>   '/admin/feeds/'
);

$nav_str = '';
while (list($str, $href) = each($links))
	$strs[] = "<a href=\"$href\" class=\"menu\">$str</a>";

$nav_str = '[&nbsp;' . implode('&nbsp|&nbsp;', $strs) . '&nbsp;]';
?>
<map name="homenav">
 <area shape="rect" coords="32,32,306,64" href="/">
</map>
<table border="0" cellpadding="3" cellspacing="0" width="100%">
 <tr bgcolor="#000066">
  <td align="center" class="normal"><font color="#FFFFFF"><?php echo $nav_str; ?></font></td>
 </tr>
</table>
