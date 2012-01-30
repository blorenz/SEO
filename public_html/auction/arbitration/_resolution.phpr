<script type="text/javascript">

function validate_res() 
{
	claim = document.forms['resform'].arb_resolution.value;
	if (trim(claim) == '') {
		alert("Please enter your desired resolution in the field provided.");
		return false;
	}
	
	return true;	
}

</script>

<h3>Step 4: Appropriate Resolution</h3>

<p>Please state an appropriate resolution to your arbitration claim.</p>

<form method="post" name="resform">
<textarea name="arb_resolution" rows="7" cols="50"></textarea>
<input type="hidden" name="arb_step" value="5" />
<input type="hidden" name="arb_auction" value="<?php echo $_POST['arb_auction']; ?>" />
<input type="hidden" name="arb_recdate" value="<?php echo $_POST['arb_recdate']; ?>" />
<input type="hidden" name="arb_claim" value="<?php echo $_POST['arb_claim']; ?>" />
<br />
<input type="submit" value="Continue &raquo;" onclick="javascript: return validate_res();" />
