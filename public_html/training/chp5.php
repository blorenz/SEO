<?php
include('../../include/session.php');
?>
<head>

<title>Online Help Document</title>

<style>
<!--
.MsoNormal
	{font-size:12.0pt;
	font-family:"Times New Roman";}
.GramE
	{}
.Section1
	{}
.style4 {font-size: 14pt}
-->
</style>
</head>
<body bgcolor="#FFFFFF" link="blue" vlink="purple" class="Normal" lang="EN-US">
  <p class="MsoNormal"><b><span style="font-size: 18pt;"><i>Chapter 5 - Fees
          and Invoices </i></span></b></p> 
  <p class="MsoNormal"><a name="Chp5_Feestructure"><span style="font-size: 16pt;">Fee
  Structure</span></a></p>
  <p class="MsoNormal">All fees are generated after a successful auction transaction.
    The reserve must be met and the auction end time must be expired or the Buy
    Now option is executed. Dealers do not pay a sell fee, but all buyers pay
    this fee. The fees are calculated by a percentage of the closing price. The
    percentage goes down as the price goes up. Below in figure 5.1 is the current
    fee structure.</p>
  <p class="MsoNormal" style="text-align: center; " align="center"><b><span style="font-size: 16pt;">Auction
        Service Fees Schedule</span></b></p>
<div align="center">
    <table class="MsoNormalTable" border="0" cellpadding="0" cellspacing="3">
      <tbody>
        <tr>
          <td bgcolor="rgb(238, 238, 238) none repeat scroll 0%" class="Normal">
            <p class="MsoNormal"><b><span style="font-size: 10pt; font-family: Arial;  color: #FFFFFF;">From</span></b></p></td>
          <td bgcolor="rgb(238, 238, 238) none repeat scroll 0%" class="Normal">
            <p class="MsoNormal"><b><span style="font-size: 10pt; font-family: Arial;  color: #FFFFFF;">To</span></b></p></td>
          <td bgcolor="rgb(238, 238, 238) none repeat scroll 0%" class="Normal">
            <p class="MsoNormal"><b><span style="font-size: 10pt; font-family: Arial;  color: #FFFFFF;">Percentage</span></b></p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text" type="text" value="1.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="500.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="10.00" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="501.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="9.00" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="2,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="5.00" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="2,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="3,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="4.00" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="3,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="4,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="3.50" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="4,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="5,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="3.00" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="5,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="6,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="2.45" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="6,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="7,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="2.25" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="7,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="8,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.90" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="8,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="10,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.80" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="10,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="12,500.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.60" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="12,501.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="15,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.40" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="15,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="17,500.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.35" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="17,501.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="20,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.25" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="20,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="22,500.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.20" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="22,501.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="25,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.15" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="25,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="27,500.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.10" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="27,501.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="30,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.09" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="30,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="35,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.08" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="35,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="40,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.07" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="40,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="50,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.05" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="50,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="75,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1.04" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="75,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="100,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.95" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="100,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="150,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.85" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="150,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="200,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.70" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="200,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="250,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.65" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="250,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="300,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.60" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="300,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="500,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.50" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="500,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="750,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.45" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="750,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1,000,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.40" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="1,000,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="2,000,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.30" size="15">
          </p></td>
        </tr>
        <tr>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="2,000,001.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="50,000,000.00" size="15">
          </p></td>
          <td class="Normal">
            <p class="MsoNormal">
              <input name="text2" type="text" value="0.25" size="15">
          </p></td>
        </tr>
      </tbody>
    </table>
    <div align="right"><i>fig 5.1</i>
    </div>
</div>
  <p class="MsoNormal">All pulled items are issued a fee based on the reserve
    price. The pull option is not available if there was no reserve set or the
    reserve was met. Below in figure 5.2 is the fee schedule for pulled items.</p>
   <blockquote>
     <p><strong>2.5 Pull Fee <em>(Paid by Dealer or FC Seller) <br> 
    </em></strong>The Pulling Dealer / FC shall pay GDTD a “Pull
     Fee” for each vehicle / item pulled from a GDTD electronic   auction. Pull
     Fees shall be based upon the Dealer's / FC's stated minimum vehicle price
     / item price / Seller's reserve price placed on a vehicle / item. This fee
     shall be due upon the pulling of a vehicle / item prior to the stated minimum
     vehicle price and / or vehicle reserve price being met or exceeded by a bidding
     member. When the Dealer / FC exercise this “Pull Option” it ends the auction
     for that vehicle / item. <strong>(See
     2.6 “Fees Schedule”)</strong><br>
     <div align="right"><em><a href="../docs/membershipagreement.php">User Agreement</a>&nbsp; fig 5.2</em>
       </p>
</div>
</blockquote>
<p class="MsoNormal style4"><span class="MsoNormal"><a name="Chp5_Invoices"><span style="font-size: 16pt;">Invoices</span></a></span></p>
<p class="MsoNormal">All Invoices are available online and kept for 1 year.
    To view your current invoice for the current month, click the My Invoice
    History in the Control Panel under the My Account section. See figure 5.3
    for an example below.</p>
  <table>
    <tr>
      <td>
        <p class="MsoNormal" style=" text-align: right;" align="right"><img src="images/Invoice.gif"  border="0" height="241" width="673"> </td>
    </tr>
    <tr>
      <td align="right"> <font face="Geneva, Arial, Helvetica, sans-serif" size="-1"><b>Total:&nbsp;&nbsp;&nbsp; &nbsp;US
            $145.00</b></font>
          <p></p></td>
    </tr>
  </table>
  <p class="MsoNormal" style=" text-align: right;" align="right"><i>fig 5.3 </i></p>
  <p class="MsoNormal">From here, you can view every item that is set to charge
    at the beginning of the month. Each item will explain what the charge was
    for in the Fee Type column. The status will remain as unpaid until the beginning
    of the month when the automated charge takes place and clears all charges.
    To view past invoices, click on the month link above. All auctions are available
    for display for up to 60 days. </p>
    	<table align="center" width="80%">
	<tr><td align="left"><a href="chp4.php">Previous</a></td>
	<td align="right"><a href="chp6.php">Next</a></td>
	</tr></table>
  <p class="MsoNormal" style="text-align: center;" align="center"><a href="index.php">Table of Contents</a></p> 
    <p class="MsoNormal" style="text-align: center;" align="center"><a href="http://[SERVER_NAME]/auction/index.php">Go Dealer to Dealer Home Page</a></p> 
</body>
