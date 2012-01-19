




<script type="text/javascript">
function validate_date()
{
	box = document.forms['calendar_test_2'].arb_recdate;
	date = box.value;

	if (trim(date) == '') {
		alert("Please enter or select a date.");
		return false;
	}

	if (new Date() < new Date(date)) {
		alert("Cannot submit arbitration for future dates.");
		return false;
	}

	return true;
}
</script>

<h3>Step 2: Date of Possession</h3>

<p>Enter the date you received the vehicle in mm/dd/yyyy format into the field below.
Alternatively, click the calendar icon to select
the date from an easy-to-use calendar.</p>


<link rel="stylesheet" media="screen" href="dynCalendar.css" />
<script language="javascript" type="text/javascript" src="browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="dynCalendar.js"></script>

<form name="calendar_test_2" method="post">
    <input type="text" name="arb_recdate" />
    <script language="JavaScript" type="text/javascript">
    <!--
        function calendar2Callback(date, month, year)
        {
            document.forms['calendar_test_2'].arb_recdate.value = month + '/' + date + '/' + year;
        }

        calendar2 = new dynCalendar('calendar2', 'calendar2Callback');
        calendar2.setMonthCombo(false);
        calendar2.setYearCombo(false);
    //-->
    </script>
    <input type="hidden" name="arb_step" value="3" />
    <input type="hidden" name="arb_auction" value="<?php echo $_POST['arb_auction'];?>" /> <br />
    <input type="submit" value="Continue &raquo;" onclick="return validate_date();" />
</form>

