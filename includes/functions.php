<?

function get_view()
{
	if ($GLOBALS["override_view"] != null) return strtolower($GLOBALS["override_view"]);
	return strtolower($_REQUEST["view"]);
}

function get_action()
{
	if ($GLOBALS["override_action"] != null) return strtolower($GLOBALS["override_action"]);
	return strtolower($_REQUEST["action"]);
}

function validation_error($msg)
{
	echo "<div class=\"validation_error\">".$msg."</div>";
}

function get_var($var)
{
	if ($_REQUEST[$var] == "" || $_REQUEST[$var] == null)
	{
		return $_POST[$var];
	}
	else
	{
		return $_REQUEST[$var];
	}
}

function dbchkstr($var)
{
	return str_replace("'","''",$var);
}

function get_data_rows($sql)
{
	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());
	
	$result = mysql_query($sql) or die("Error:#10:".mysql_error());

	return $result;
}


function uuid()
{
   // The field names refer to RFC 4122 section 4.1.2

   return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
       mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
       mt_rand(0, 65535), // 16 bits for "time_mid"
       mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
       bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
           // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
           // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
           // 8 bits for "clk_seq_low"
       mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
   );
}


?>
