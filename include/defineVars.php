<?

//This function will be used in place of the previously used "Register Global" option that was set.
//All variables that you want to use in your script should be passed into this function as a string (all variables are case sensitive).
//If the variable is not found, it will be returned empty.
//To get the values you need back from this function, you must extract the results.  example: extract(defineVars("varible1","var2","CaseSensitiveVar3")
//The order this functions gets the variables is (Environment (not implemented), Get, Post, Cookie, and Server)
function defineVars()
{
	//define our output variable
	$returnArray = array();

	//get the list of arguments
	$arg_list = func_get_args();

	//lets loop through all our variables passed and do our thing
	foreach ($arg_list as $key => $value)
	{
		$tempVar = "";

		//first lets check the Get
		if(isset($_GET[$value]))
			$tempVar = $_GET[$value];
		elseif(isset($_POST[$value]))
			$tempVar = $_POST[$value];
		elseif(isset($_COOKIE[$value]))
			$tempVar = $_COOKIE[$value];
		elseif(isset($_SESSION[$value]))
			$tempVar = $_SESSION[$value];
		elseif(isset($_SERVER[$value]))
			$tempVar = $_SERVER[$value];
		else
		{
			//didn't find a value, lets pass back a NULL (meaning not set)
			$returnArray[$value] = NULL;
			continue;  //we don't need to run through the code below, lets loop back up to the top
		}

		//don't forget to do any and all error checking here
		if(is_array($tempVar))
		{
			$tempVar = array_filter($tempVar, "cleanValue");
		}
		else //not an array
		{
			$tempVar = cleanValue($tempVar);
		}

		//lets push the variable onto the output array
		$returnArray[$value] = $tempVar;
	}

	return($returnArray);
}

function cleanValue($var)
{
//			$tempVar = mysql_real_escape_string($tempVar);
	return addslashes(trim($var));
}

?>
