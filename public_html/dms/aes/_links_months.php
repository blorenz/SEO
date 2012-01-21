<?php


if(!empty($_REQUEST['stats']))
	$stats = $_REQUEST['stats'];
else
	$stats = "";




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
# $srp: godealertodealer.com/htdocs/auction/fees/_links_months.php,v 1.2 2002/09/03 00:40:33 steve Exp $
#

?>
<p align="center" class="normal">
<?php
$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$month = number_format(date("m"), 0);
$current = TRUE;
echo " [ ";

if (!isset($stats)) {
	echo "<b>Last 30 Days</b> | ";
	$current = FALSE;
}
else
	echo "<a href=\"?\">Last 30 Days</a> | ";

do{

	if ($month >= number_format(date("m"), 0)) $year = date("Y")-1;
	else $year = date("Y");

	$timeperiod = $year.str_pad($month+1, 2, "0", STR_PAD_LEFT);

	if ($stats == $timeperiod) {
		echo "<b>".$months[$month]." ".substr($year, -2, 2)."</b> | ";
		$current = FALSE;
	}
	else
		echo "<a href=\"?stats=$timeperiod\">".$months[$month]." ".substr($year, -2, 2)."</a> | ";


	if ($month < 11)
		$month++;
	else
		$month = 0;

}while($month != date("m")-1);
if ($current == TRUE)
	echo "<b>Current Month</b> ]";
else {
	$timeperiod = date("Y").str_pad(number_format(date("m"), 0), 2, "0", STR_PAD_LEFT);
	echo "<a href=\"?stats=$timeperiod\">Current Month</a> ]";
}
?>
</p><br>