<script type="text/javascript">

function validate_claim()
{
	claim = document.forms['claimform'].arb_claim.value;
	if (trim(claim) == '') {
		alert("We cannot file an empty claim, please enter your complaint in the provided input field.");
		return false;
	}

	return true;
}

</script>

<h3>Step 3: State the Problem</h3>
<p>Please state the nature of your complaint against the respondant, including the <em>exact</em> issue with
the item.  <b>Note: </b> The issue <em>must</em> be appraised at $400.00 or more to qualify for Arbitration
as stated in Section 10.1 "Filing a Claim" in the Arbitration Policy.</p>
<p>Be sure to include: transpotation costs, any associated fees, and dates of contact with the respondant.</p>

<form method="post" name="claimform">
<textarea name="arb_claim" rows="7" cols="50"></textarea>
<input type="hidden" name="arb_step" value="4" />
<input type="hidden" name="arb_recdate" value="<?php echo $_POST['arb_recdate']; ?>" />
<input type="hidden" name="arb_auction" value="<?php echo $_POST['arb_auction']; ?>" />
<br />
<input type="submit" value="Continue &raquo;" onclick="javascript: return validate_claim()" />
