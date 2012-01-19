<?php

if(!empty($_REQUEST['oConn']))
	$oConn = $_REQUEST['oConn'];
else
	$oConn = "";

?>



<?php

if(extension_loaded("mbstring"))
{
	$acceptCharsetHeader = "Accept-Charset: " . mb_internal_encoding();
	header( $acceptCharsetHeader );
	$head = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=" . mb_http_output() . "'></head>";
	echo( $head );
}

// Build connection object
//if ($connType == "MYSQL")
if (!empty($Type == "MYSQL"))
{
	require("./mysql.php");
	$oConn = new MySqlConnection($_POST['ConnectionString'], $_POST['Timeout'], $_POST['Host'], $_POST['Database'], $_POST['UserName'], $_POST['Password']);
}

// Process opCode
if ($oConn)
{
	$oConn->Open();

	if ($_POST['opCode'] == "IsOpen")
		echo($oConn->TestOpen());
	elseif ($oConn->connectionId && $oConn->isOpen)
	{
		if	   ($_POST['opCode'] == "GetTables")				 echo($oConn->GetTables());
		elseif ($_POST['opCode'] == "GetColsOfTable")			 echo($oConn->GetColumnsOfTable($_POST['TableName']));
		elseif ($_POST['opCode'] == "ExecuteSQL")				 echo($oConn->ExecuteSQL($_POST['SQL'], $_POST['MaxRows']));
		elseif ($_POST['opCode'] == "GetODBCDSNs")				 echo($oConn->GetDatabaseList());
		elseif ($_POST['opCode'] == "SupportsProcedure")		 echo($oConn->SupportsProcedure());
		elseif ($_POST['opCode'] == "GetProviderTypes")		 echo($oConn->GetProviderTypes());
		elseif ($_POST['opCode'] == "GetViews")				 echo($oConn->GetViews());
		elseif ($_POST['opCode'] == "GetProcedures")			 echo($oConn->GetProcedures());
		elseif ($_POST['opCode'] == "GetParametersOfProcedure") echo($oConn->GetParametersOfProcedure($_POST['ProcName']));
		elseif ($_POST['opCode'] == "ReturnsResultset")		 echo($oConn->ReturnsResultSet($_POST['RRProcName']));
		elseif ($_POST['opCode'] == "ExecuteSP")				 echo($oConn->ExecuteSP($_POST['ExecProcName'], 0, $_POST['ExecProcParameters']));
		elseif ($_POST['opCode'] == "GetKeysOfTable")			 echo($oConn->GetPrimaryKeysOfTable($_POST['TableName']));
	}

	// if (!$oConn->isOpen)
	// handle exception is actually called by TestOpen, so this call is not needed
	//	echo($oConn->HandleException());

	$oConn->Close();
}

echo( "</html>" );
?>