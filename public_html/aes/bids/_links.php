

<?php

if(!empty($_REQUEST['did']))
	$did = $_REQUEST['did'];
else
	$did = "";



?>

<p align="center" class="normal">[ <a href="index.php?did=<?=$did?>"> Bids for Open Auctions</a> | <a href="won.php?did=<?=$did?>">Bids for Auctions Won</a> | <a href="all.php?did=<?=$did?>">All Bids</a> ]</p>
