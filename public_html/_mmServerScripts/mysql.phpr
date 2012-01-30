<?php
class MySqlConnection
{
	var $isOpen;
	var $hostname;
	var $database;
	var $username;
	var $password;
	var $timeout;
	var $connectionId;

	function MySqlConnection($ConnectionString, $Timeout, $Host, $DB, $UID, $Pwd)
	{
		$this->isOpen = false;
		$this->timeout = $Timeout;

		if( $Host ) { 
			$this->hostname = $Host;
		}
		elseif( ereg("host=([^;]+);", $ConnectionString, $ret) )  {
			$this->hostname = $ret[1];
		}
		
		if( $DB ) {
			$this->database = $DB;
		}
		elseif( ereg("db=([^;]+);",   $ConnectionString, $ret) ) {
			$this->database = $ret[1];
		}
		
		if( $UID ) {
			$this->username = $UID;
		}
		elseif( ereg("uid=([^;]+);",  $ConnectionString, $ret) ) {
			$this->username = $ret[1];
		}
		
		if( $Pwd ) {
			$this->password = $Pwd;
		}
		elseif( ereg("pwd=([^;]+);",  $ConnectionString, $ret) ) {
			$this->password = $ret[1];
		}
	}

	function Open()
	{
		// if ($this->connectionId = mysql_connect($this->hostname, $this->username, $this->password) or die(mysql_error()))
	    if ($this->connectionId = mysql_connect($this->hostname, $this->username, $this->password))
		{
			$this->isOpen = ($this->database == "") ? true : mysql_select_db($this->database, $this->connectionId);
		}
		else
		{
           // this error information gets added in test open
		
		   //	$error_message = mysql_error() ;
			
			// if ( $error_message == "" ){
			//	$error_message = "Unable to Establish Connection to " . $this.hostname . " for user " . $this->username ;
			//}
			
            // echo("<ERRORS><ERROR><DESCRIPTION>" . $error_message . "</DESCRIPTION></ERROR></ERRORS>");

			// $this->isOpen = false;
		}	
			
			
	}

	function TestOpen()
	{
		return ($this->isOpen) ? "<TEST status=true></TEST>" : $this->HandleException();
	}

	function Close()
	{
		if ($this->connectionId && $this->isOpen)
		{
			if (mysql_close($this->connectionId))
			{
				$this->isOpen = false;
				$this->connectionId = 0;
			}
		}
	}

	function GetTables()
	{
		$xmlOutput = "";
		$result = mysql_list_tables($this->database, $this->connectionId);

		if ($result)
		{
			$xmlOutput = "<RESULTSET><FIELDS>";

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= "<FIELD><NAME>TABLE_CATALOG</NAME></FIELD>";		// column 0 (zero-based)
			$xmlOutput .= "<FIELD><NAME>TABLE_SCHEMA</NAME></FIELD>";		// column 1
			$xmlOutput .= "<FIELD><NAME>TABLE_NAME</NAME></FIELD>";		// column 2

			$xmlOutput .= "</FIELDS><ROWS>";
			$tableCount = mysql_num_rows($result);

			for ($i=0; $i < $tableCount; $i++)
			{
				$xmlOutput .= "<ROW><VALUE/><VALUE/><VALUE>";
				$xmlOutput .= mysql_tablename ($result, $i);
				$xmlOutput .= "</VALUE></ROW>";
			}

			$xmlOutput .= "</ROWS></RESULTSET>";
		}

		return $xmlOutput;
	}

	function GetViews()
	{
		// not supported
		return "<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>";
	}

	function GetProcedures()
	{
		// not supported
		return "<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>";
	}

	function GetColumnsOfTable($TableName)
	{
		$xmlOutput = "";
		$query  = "DESCRIBE $TableName";
		// $result = mysql_query($query) or die("Invalid query: $query");
		$result = mysql_query($query) or die("<ERRORS><ERROR Identification=\"" . mysql_errno() .
		   "\"><DESCRIPTION>" . mysql_errno() . " " . mysql_error() . "</DESCRIPTION></ERROR></ERRORS>");

		
		if ($result)
		{
			$xmlOutput = "<RESULTSET><FIELDS>";

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= "<FIELD><NAME>TABLE_CATALOG</NAME></FIELD>";		// column 0 (zero-based)
			$xmlOutput .= "<FIELD><NAME>TABLE_SCHEMA</NAME></FIELD>";		// column 1
			$xmlOutput .= "<FIELD><NAME>TABLE_NAME</NAME></FIELD>";			// column 2
			$xmlOutput .= "<FIELD><NAME>COLUMN_NAME</NAME></FIELD>";
			$xmlOutput .= "<FIELD><NAME>DATA_TYPE</NAME></FIELD>";
			$xmlOutput .= "<FIELD><NAME>IS_NULLABLE</NAME></FIELD>";
			$xmlOutput .= "<FIELD><NAME>COLUMN_SIZE</NAME></FIELD>";

			$xmlOutput .= "</FIELDS><ROWS>";

			// The fields returned from DESCRIBE are: Field, Type, Null, Key, Default, Extra
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$xmlOutput .= "<ROW><VALUE/><VALUE/><VALUE/>";

				// Separate type from size. Format is: type(size)
				if (ereg("(.*)\\((.*)\\)", $row["Type"], $ret))
				{
					$type = $ret[1];
					$size = $ret[2];
				}
				else
				{
					$type = $row["Type"];
					$size = "";
				}

				// MySQL sets nullable to "YES" or "", so we need to set "NO"
				$null = $row["Null"];
				if ($null == "")
					$null = "NO";

				$xmlOutput .= "<VALUE>" . $row["Field"] . "</VALUE>";
				$xmlOutput .= "<VALUE>" . $type         . "</VALUE>";
				$xmlOutput .= "<VALUE>" . $null         . "</VALUE>";
				$xmlOutput .= "<VALUE>" . $size         . "</VALUE></ROW>";
			}
			mysql_free_result($result);

			$xmlOutput .= "</ROWS></RESULTSET>";
		}

		return $xmlOutput;
	}

	function GetParametersOfProcedure($ProcedureName, $SchemaName, $CatalogName)
	{
		// not supported
		return "<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>";
	}

	function ExecuteSQL($aStatement, $MaxRows)
	{
		if ( get_magic_quotes_gpc() )
		{
			$aStatement = stripslashes( $aStatement ) ;
		}
				
		$xmlOutput = "";
		// $result = mysql_query($aStatement) or die("Invalid query: $aStatement");
		// the error must be in the correct XML format to get picked up by the Error parser in DW
		// added by DRN 1-29-02.
		$result = mysql_query($aStatement) or die("<ERRORS><ERROR Identification=\"" . mysql_errno() .
		   "\"><DESCRIPTION>" . mysql_errno() . " " . mysql_error() . "</DESCRIPTION></ERROR></ERRORS>");
		
		if ($result)
		{
			$xmlOutput = "<RESULTSET><FIELDS>";

			$fieldCount = mysql_num_fields($result);
			for ($i=0; $i < $fieldCount; $i++)
			{
				$meta = mysql_fetch_field($result);
				if ($meta)
				{
					$xmlOutput .= "<FIELD";
					$xmlOutput .= " type=\""			. $meta->type;
					$xmlOutput .= "\" max_length=\""	. $meta->max_length;
					$xmlOutput .= "\" table=\""			. $meta->table;
					$xmlOutput .= "\" not_null=\""		. $meta->not_null;
					$xmlOutput .= "\" numeric=\""		. $meta->numeric;
					$xmlOutput .= "\" unsigned=\""		. $meta->unsigned;
					$xmlOutput .= "\" zerofill=\""		. $meta->zerofill;
					$xmlOutput .= "\" primary_key=\""	. $meta->primary_key;
					$xmlOutput .= "\" multiple_key=\""	. $meta->multiple_key;
					$xmlOutput .= "\" unique_key=\""	. $meta->unique_key;
					$xmlOutput .= "\"><NAME>"			. $meta->name;
					$xmlOutput .= "</NAME></FIELD>";
				}
			}

			$xmlOutput .= "</FIELDS><ROWS>";
			$row = mysql_fetch_assoc($result);

			for ($i=0; $row && ($i < $MaxRows); $i++)
			{
				$xmlOutput .= "<ROW>";

				foreach ($row as $key => $value) /* what is $key???? */
				{
					$xmlOutput .= "<VALUE>";
					$xmlOutput .= htmlspecialchars($value);
					$xmlOutput .= "</VALUE>";
				}

 				$xmlOutput .= "</ROW>";
				$row = mysql_fetch_assoc($result);
			}

			mysql_free_result($result);

			$xmlOutput .= "</ROWS></RESULTSET>";
		}
				
		return $xmlOutput;
	}

	function GetProviderTypes()
	{
		// not supported?
		return "<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>";
	}

	function ExecuteSP($aProcStatement, $TimeOut, $Parameters)
	{
		// not supported
		return "<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>";
	}

	function ReturnsResultSet($ProcedureName)
	{
		// not supported
		return "<RETURNSRESULTSET status=false></RETURNSRESULTSET>";
	}

	function SupportsProcedure()
	{	
		return "<SUPPORTSPROCEDURE status=false></SUPPORTSPROCEDURE>";
	}

	function HandleException()
	{
		return "<ERRORS><ERROR Identification=\"" . mysql_errno() .
			   "\"><DESCRIPTION>". mysql_errno() . " " . mysql_error() . "</DESCRIPTION></ERROR></ERRORS>";
	}

	function GetDatabaseList()
	{
		$xmlOutput = "<RESULTSET><FIELDS><FIELD><NAME>NAME</NAME></FIELD></FIELDS><ROWS>";
		$dbList = mysql_list_dbs($this->connectionId);

		while ($row = mysql_fetch_object($dbList))
		{
			$xmlOutput .= "<ROW><VALUE>" . $row->Database . "</VALUE></ROW>";
		}

		$xmlOutput .= "</ROWS></RESULTSET>";

		return $xmlOutput;
	}

	function GetPrimaryKeysOfTable($TableName)
	{
		$xmlOutput = "";
		$query  = "DESCRIBE $TableName";
		// $result = mysql_query($query) or die("Invalid query: $query");
		$result = mysql_query($query) or die("<ERRORS><ERROR Identification=\"" . mysql_errno() .
		   "\"><DESCRIPTION>" . mysql_errno() . " " . mysql_error() . "</DESCRIPTION></ERROR></ERRORS>");
		
		
		if ($result)
		{
			$xmlOutput = "<RESULTSET><FIELDS>";

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= "<FIELD><NAME>TABLE_CATALOG</NAME></FIELD>";		// column 0 (zero-based)
			$xmlOutput .= "<FIELD><NAME>TABLE_SCHEMA</NAME></FIELD>";		// column 1
			$xmlOutput .= "<FIELD><NAME>TABLE_NAME</NAME></FIELD>";			// column 2
			$xmlOutput .= "<FIELD><NAME>COLUMN_NAME</NAME></FIELD>";
			$xmlOutput .= "<FIELD><NAME>DATA_TYPE</NAME></FIELD>";
			$xmlOutput .= "<FIELD><NAME>IS_NULLABLE</NAME></FIELD>";
			$xmlOutput .= "<FIELD><NAME>COLUMN_SIZE</NAME></FIELD>";

			$xmlOutput .= "</FIELDS><ROWS>";

			// The fields returned from DESCRIBE are: Field, Type, Null, Key, Default, Extra
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
			  if (strtoupper($row["Key"]) == "PRI"){
  				$xmlOutput .= "<ROW><VALUE/><VALUE/><VALUE/>";
  
  				// Separate type from size. Format is: type(size)
  				if (ereg("(.*)\\((.*)\\)", $row["Type"], $ret))
  				{
  					$type = $ret[1];
  					$size = $ret[2];
  				}
  				else
  				{
  					$type = $row["Type"];
  					$size = "";
  				}
  
  				// MySQL sets nullable to "YES" or "", so we need to set "NO"
  				$null = $row["Null"];
  				if ($null == "")
  					$null = "NO";
  
  				$xmlOutput .= "<VALUE>" . $row["Field"] . "</VALUE>";
  				$xmlOutput .= "<VALUE>" . $type         . "</VALUE>";
  				$xmlOutput .= "<VALUE>" . $null         . "</VALUE>";
  				$xmlOutput .= "<VALUE>" . $size         . "</VALUE></ROW>";
  			}
			}
			mysql_free_result($result);

			$xmlOutput .= "</ROWS></RESULTSET>";
		}
		return $xmlOutput;
	}

}	// class MySqlConnection
?>
