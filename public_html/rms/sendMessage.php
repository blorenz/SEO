<?php

/**
 * $Id$
 */

$_pagetitle = "Send A Message";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";

if (isset($_POST['send'])) {
   
	if (empty($_POST['title']) || empty($_POST['dest']) || empty($_POST['message'])) {
	   $errors = true;
	}
	
	if (!$errors) {
	   if ($_POST['dest'] == 'single') {
	      $rm->sendMessage($_POST['to'], $_POST['title'], $_POST['message']);
	   }
	   
	   if ($_POST['dest'] == 'multiple') {
	      $rm->sendMessage('allDMs', $_POST['title'], $_POST['message']);
	   }
	
	   ?>
	   <center>
	   <h1>Message Sent</h1>
	   <p>Your message has been sent.</p>
	   <p><a href="sendMessage.php">Send another?</a>  
	   <a href="index.php">Go home?</a>
	   </p>
	   </center>
	   <?php
	   include 'footer.php';
	   die();
	   
	}
}

$dms = $rm->getDMs();
?>



<center>

<h1>Send Message</h1>

<div style="border: 1px solid #222; background: #bbb; padding-bottom: 1em; 
	width: 80%;">
	
<?php if ($errors && empty($_POST['dest'])) { 
   ?>
   <p style="color: red">Please select the recipient.</p>
   <?php
}
?>
<form method="post">
<h2>Send To</h2>
<span style="font-size: 120%">
<input type="radio" id="single" name="dest" value="single" 
	onclick="javascript: document.getElementById('dmselector').style.display = 'block';" 
	<?php if($_POST['dest'] == 'single') { echo 'checked="checked"'; } ?> />
One of my DMs
<input type="radio" id="multiple" name="dest" value="multiple" 
	onclick="javascript: document.getElementById('dmselector').style.display = 'none';" 
	<?php if($_POST['dest'] == 'multiple') { echo 'checked="checked"'; } ?> />
All of my DMs at once
</span>
<br />

<select name="to" <?php if($_POST['dest'] != 'single' && $errors) { echo 'style="display: none"'; } ?>
	 id="dmselector">
<?php
foreach ($dms as $dm) {
   ?>
   <option value="<?php echo $dm['id'] ?>" 
   	<?php if($_POST['to'] == $dm['id']) { echo 'selected="selected"'; } ?>>
   	<?php echo $dm['name'] ?></option>
   <?php
}
?>
</select>
</div>
<br />
<?php if ($errors && empty($_POST['title'])) { 
   ?>
   <p style="color: red">Please enter a message.</p>
   <?php
}
?>
Subject: <input type="text" name="title" size="30" style="border: 1px solid black" 
	value="<?php echo $_POST['title'] ?>" />
<br /><br />
<?php if ($errors && empty($_POST['message'])) { 
   ?>
   <p style="color: red">Please type your message here.</p>
   <?php
}
?>
Please type your message here:<br />
<textarea cols="60" rows="8" style="border: 1px solid black;" name="message">
<?php echo $_POST['message'] ?>
</textarea>
<br /><br />
<input type="submit" value="Send Now" name="send" />
</form>


</center>

<?php 
include 'footer.php';
?>