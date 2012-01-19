
<?php
$PHP_SELF = $_SERVER['PHP_SELF'];


if(!empty($_REQUEST['username']))
	$username = $_REQUEST['username'];
else
	$username = "";

if(!empty($_REQUEST['gas']))
	$gas = $_REQUEST['gas'];
else
	$gas = "";

if(!empty($_REQUEST['distance']))
	$distance = $_REQUEST['distance'];
else
	$distance = "";

if(!empty($_REQUEST['mpg']))
	$mpg = $_REQUEST['mpg'];
else
	$mpg = "";

if(!empty($_REQUEST['submit']))
	$submit = $_REQUEST['submit'];

if(!empty($_REQUEST['total_cars']))
	$total_cars = $_REQUEST['total_cars'];
else
	$total_cars = "";

if(!empty($_REQUEST['cars_return_from_auction']))
	$cars_return_from_auction = $_REQUEST['cars_return_from_auction'];
else
	$cars_return_from_auction = "";

if(!empty($_REQUEST['people']))
	$people = $_REQUEST['people'];
else
	$people = "";

if(!empty($_REQUEST['time']))
	$time = $_REQUEST['time'];
else
	$time = "";

if(!empty($_REQUEST['cars_sold_dealership']))
	$cars_sold_dealership = $_REQUEST['cars_sold_dealership'];
else
	$cars_sold_dealership = "";


if(!empty($_REQUEST['cars_profit_dealership']))
	$cars_profit_dealership = $_REQUEST['cars_profit_dealership'];
else
	$cars_profit_dealership = "";


if(!empty($_REQUEST['weeks_year']))
	$weeks_year = $_REQUEST['weeks_year'];
else
	$weeks_year = "";




?>





<?php

$title="Auction Costs Calculator";

if (isset($submit)) {

	// Columns A-D, can be used to create a table to show our fees or can be erased - not used in calculations
	$sale = array(0,500,1000,2000,2300,4000,5000,6500,7500,10000,12500,15000,17500,20000,22500,25000, 27500,30000, 32500,35000,37500,40000,42500,45000,47500);
	$price = array(499,999,1999,2299,3999,4999,6499,7499,9999,12499,14999,17499,19999,22499,24999, 27499,29999, 32499,34999,37499,39999,42499,44499,47499, 49999);
	$sell_fee = array(85.00, 95.00, 110.00, 120.00, 125.00, 130.00, 135.00, 140.00, 145.00, 150.00, 155.00, 160.00, 165.00, 170.00, 175.00, 180.00, 190.00, 200.00, 210.00, 220.00, 230.00, 240.00, 250.00, 260.00, 270.00);

	//Set variables to 1 if they are not set to avoid division by zero errors
	if ($total_cars<=0)
		$total_cars=1;
	if ($weeks_year<=0)
		$weeks_year=1;
	if ($mpg<=0)
		$mpg=1;
	if ($cars_return_from_auction<=0)
		$cars_return_from_auction=.6;

	// Columns G, H, and T - fixed variables used in calculations
	$no_sell_fee = 10;
	$input_buy_sell_fee = 200;
	$burned = .25;

	//Calculating gasoline costs per car
	$fuel_consumed = $distance/$mpg;
	$total_gas_one_way = $fuel_consumed + $burned;
	$gas_cost_taken_to_auction = $total_gas_one_way*$gas;

	//I column, total fees for all cars taken to auction based on percent sold
	$calc_total_fees = ((($input_buy_sell_fee * $total_cars)*(1-$cars_return_from_auction)) + ($no_sell_fee * $total_cars * $cars_return_from_auction));

	//S Columnn
	$all_cars_gas_cost_taken_to_auction = $gas_cost_taken_to_auction*$total_cars;

	//U Column
	$cars_returned_gas_cost = ($cars_return_from_auction*$total_cars)*$fuel_consumed;

	//V Column
	$total_gas_cost_per_auction = $cars_returned_gas_cost + $all_cars_gas_cost_taken_to_auction;

	//AB Column
	$lost_sales_per_man_hours = ((($people*$time)*$cars_sold_dealership)*$cars_profit_dealership);

	//AD Column
	$total_cost_per_auction = $calc_total_fees+$total_gas_cost_per_auction+$lost_sales_per_man_hours;

	//AF Column
	$annual_auction_cost = $total_cost_per_auction*$weeks_year;

	//AH Column
	$annual_average_auction_cost_per_vehicle = ($annual_auction_cost/(($total_cars*$weeks_year)*$cars_return_from_auction)+50);

	//AJ Column
	$auction_costs_minus_fees = $total_cost_per_auction-$calc_total_fees;

	//AK Column
	$annual_auction_costs_minus_fees = $auction_costs_minus_fees*$weeks_year;
}


?>
<html>
 <head>
  <title><?=$title?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<br>
<br>
<table class="normal" width="75%" align="center">
<tr><td colspan="2" class="big" align="center"><b><?php echo $title ?></b></td></tr>
<tr><td>&nbsp;</td></tr>
<form action="<?=$PHP_SELF?>" method="post">
<tr><td width="50%" align="right"><strong>Price of Gas:</strong></td>
<td><input type="text" name="gas" value="<?php echo $gas?>"></td></tr>
<tr><td align="right"><strong>Distance to Auction:</strong></td>
<td><input type="text" name="distance" value="<?php echo $distance?>"></td></tr>
<tr><td align="right"><strong>Average Miles per Gallon:</strong></td>
<td><input type="text" name="mpg" value="<?php echo $mpg?>"></td></tr>
<tr><td align="right"><strong>Total Cars at Auction:</strong></td>
<td><input type="text" name="total_cars" value="<?php echo $total_cars?>"></td></tr>
<tr><td align="right"><strong>Decimal Percent of Cars that Return from Auction:</strong></td>
<td><input type="text" name="cars_return_from_auction" value="<?php echo $cars_return_from_auction?>"></td></tr>
<tr><td align="right"><strong>Number of Salepeople at the Auction:</strong></td>
<td><input type="text" name="people" value="<?php echo $people?>"></td></tr>
<tr><td align="right"><strong>Time Spent at the Auction per Hour (for each Saleperson):</strong></td>
<td><input type="text" name="time" value="<?php echo $time?>"></td></tr>
<tr><td align="right"><strong>Average Number of Cars Sold per Hour (at the Dealership):</strong></td>
<td><input type="text" name="cars_sold_dealership" value="<?php echo $cars_sold_dealership?>"></td></tr>
<tr><td align="right"><strong>Average Profit per Car Sold (at the Dealership):</strong></td>
<td><input type="text" name="cars_profit_dealership" value="<?php echo $cars_profit_dealership?>"></td></tr>
<tr><td align="right"><strong>Number of Weeks Spent at Auction (per Year):</strong></td>
<td><input type="text" name="weeks_year" value="<?php echo $weeks_year?>"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr align="center"><td colspan="2"><input type="submit" name="submit" value="Submit"></td></tr>
<tr><td>&nbsp;</td></tr>
</form>

<?php
 if (isset($submit)) {
	//Outputs
	//Columns AD, AF, AH, AJ, and AK

	//AD Column
	echo "<tr><td align=\"right\"><strong>Total Cost per Auction:</strong></td><td align=\"left\">";
	echo number_format($total_cost_per_auction,2);

	//AF Column
	echo "</td></tr><tr><td align=\"right\"><strong>Annual Auction Costs:</strong></td><td align=\"left\">";
	echo number_format($annual_auction_cost,2);

	//AH Column
	echo "</td></tr><tr><td align=\"right\"><strong>Annual Average Auction Costs per Vehicle:</strong></td><td align=\"left\">";
	echo number_format($annual_average_auction_cost_per_vehicle,2);

	//extra space
	echo "</td></tr><tr><td>&nbsp;</td></tr>";
	}
?>
<tr><td colspan="2">
  <h3><br>
  Calculations:</h3>
  The <b>Total Cost per Auction</b> is the most complicated calculation, so it will be broken up into three parts that are added together at the end.  Those three parts are the <b>Total Cost of Gas</b>, the <b>Total Fees at the Auction</b>, and the <b>Lost Money from having Salespeople at the Auction</b>.<br>
  <br>
  <b>Total Cost of Gas</b>:&nbsp; &nbsp;
  We divide the <b>Distance to Auction</b> by the <b>Average Miles per Gallon</b> to see how many gallons are used on the drive to the auction.  That is added to the amount of gas burned while the car is idle at the auction, which we assume to be .25 gallon.  We multiply that number by the <b>Price of Gas</b> to see how much money is spent bringing one car to the auction.  We then multiply that cost by the <b>Total Cars at Auction</b> to get the cost of driving every car to the auction.
  Finally, we want to get the cost of gas for the drive back.  To get the number of cars that we will have to drive back, we multiply the <b>Total Cars at Auction</b> by the <b>Percent of Cars that Return from Auction</b>, which defaults to .6 if no other number is put in.  We then multiply the number of cars that we take back by the gallons used on the drive (which is the <b>Distance to Auction</b> divided by the <b>Average Miles per Gallon</b>).
   <br>
   <br>
   <b>Total Fees at the Auction</b>:&nbsp; &nbsp;
   The <b>Total Fees at the Auction</b> calculates the sell and no sell fees.  The no sell fee is assumed to be $10.  We multiply the <b>Total Cars at Auction</b> with the <b>Percent of Cars that Return from Auction</b>, which gives us the number of cars that return from the auction.  We multiply that by the $10 no sell fee to get the fees from the cars that did not sell.  We next multiply the <b>Total Cars at Auction</b> with one minus the <b>Percent of Cars that Return from Auction</b>, which gives us the number of cars that were sold at the auction.  We assume the sell fee to be $200, so we multiply $200 by the previous calculation of the number of cars which are sold at the auction.  That calculation gives us the fees for the cars which are sold, so we add that to the fees for the cars which were not sold to get the <b>Total Fees at the Auction</b>.
   <br>
   <br>
   <b>Lost Money from having Salespeople at the Auction</b>:&nbsp; &nbsp;
  To get this we multiply the <b>Number of Salepeople at the Auction</b> by the <b>Time Spent at the Auction per Hour</b>.  We multiply that number by the <b>Average Number of Cars Sold per Hour</b>, and then the <b>Average Profit per Car Sold</b>.  When we multiply the <b>Number of Salepeople at the Auction</b> by the <b>Time Spent at the Auction per Hour</b>, that number could be hours that these salespeople spent at the dealership, instead of at the auction.  When we multiply the <b>Average Number of Cars Sold per Hour</b> and the <b>Average Profit per Car Sold</b>, we see the average that the dealership makes per hour.  When we multiply the number of hours that the salespeople could be at the dealership by the average amount that the dealership makes per hour, we can see how much we are losing by having the salespeople at the auction instead of the dealership.
  <br>
  <br>
  <br>
  We get the <b>Annual Auction Costs</b> by multiplying the <b>Total Fees at the Auction</b> by the <b>Number of Weeks Spent at Auction (per Year)</b>.
  <br>
  <br>
  <br>
  To get the <b>Annual Average Auction Costs per Vehicle</b>, we first multiply the <b>Total Cars at Auction</b> by the <b>Number of Weeks Spent at Auction (per Year)</b>.  Then we multiply that by the <b> Percent of Cars that Return from Auction</b>.  This gives us the total number of cars that are taken to the auction, taking in to consideration that a certain percentage will be returned.
  <br>
  <br>
  <br>
  <strong>Auction Costs Minus Fees</strong>:<br>
  The <strong>Auction Costs Minus Fees</strong> is simple to calculate given our previous calculations.  We have the <b>Total Fees at the Auction</b>, which is already calculated to find the <b>Total Cost per Auction</b>.  We subtract that number from <b>Annual Auction Costs</b> to get the <strong>Auction Costs Minus Fees</strong>.
  <br>
  <br>
  <br>
  <strong>Annual Auction Costs Minus Fees</strong>:<br>
  To get the <strong>Annual Auction Costs Minus Fees</strong>, we just multiply the <strong>Auction Costs Minus Fees</strong> by the <b>Number of Weeks Spent at Auction (per Year)</b>.
  <br>
  <br>
  <br>

</h2></td></tr>

<tr><td align="center" class="small" colspan="2">
<?php include('../footer.php'); ?>
</td></tr>
</table>

</body>
</html>

