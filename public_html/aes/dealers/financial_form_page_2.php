<?php

include('../../../include/session.php');
include('../../../include/defs.php');

$page_title = 'Application Form';
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
<style>
.supermini {font-size: 7pt}
.mini {font-size: 8pt}
.short {font-size: 10pt}
.medium {font-size: 11pt}
.large {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	font-size: 18pt;
	font-weight: bold;
}
</style>
 </head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br />
<table width="650" align="center" cellpadding="0" cellspacing="0">
	<tr><td colspan="4"><img src="../../images/Logo-White.gif"></td></tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="4"><b>Checking Account:&nbsp;</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="25%" class="medium" align="left"><b>Opening Date</b></td>
		<td width="25%" class="medium" align="left"><b>Average Balance</b></td>
		<td width="25%" class="medium" align="left"><b>Current Balance</b></td>
		<td width="25%" class="medium" align="left"><b>Relationship</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4"><hr></td>
	</tr>	
		<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="4"><b>Other Deposits:&nbsp;</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="25%" class="medium" align="left"><b>Opening Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type</b></td>
		<td width="25%" class="medium" align="left"><b>Average Balance</b></td>
		<td width="25%" class="medium" align="left"><b>Current Balance</b></td>
		<td width="25%" class="medium" align="left"><b>Relationship</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	</tr>
	<tr>	
		<td colspan="4"><hr></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="4"><b>Floor Plan or Line of Credit:&nbsp;</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="25%" class="medium" align="left"><b>Type</b></td>
		<td width="25%" class="medium" align="left"><b>High Credit</b></td>
		<td width="25%" class="medium" align="left"><b>Terms</b></td>
		<td width="25%" class="medium" align="left"><b>Experience</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4"><hr></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="4"><b>Have any events occurred which have negative impact on this 
														customer’s credit?   Please Explain::&nbsp;</b></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4"><hr></td>
	</tr>
	<tr>	
		<td colspan="4"><hr></td>
	</tr>
	<tr>	
		<td colspan="4"><hr></td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>	
		<td align="left" class="medium" colspan="4"><b>Bank / Financial Institution:&nbsp;</b></td>
	</tr>
	<tr>
	  <td colspan="4"><b><br>Authorized<br> Signature:</b>_____________________________________________&nbsp;<b>Date:</b>_______________</td>
	</tr>
	<tr>
	  <td colspan="4"><b><br> Print Name:</b>________________________________________________________________</td>
	</tr>
	<tr>
	  <td colspan="4"><b><br>Title:</b>______________________________________________________________________</td>
	</tr>
	<tr>
	  <td colspan="4">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" class="supermini" colspan="4"><span class="mini"><b>Go Dealer to Dealer™ Membership / User Agreement Form 1000</b></span><br>
						Copyright© GO DEALER TO DEALER L.L.C. ALL RIGHTS RESERVED<br>
						NO UNAUTHORIZED REPRODUCTION IS PERMITTED
		</td>
	</tr>
</table>
</body>
</html>