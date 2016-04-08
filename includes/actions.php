<?

function actionForgotPassword()
{
	if ($_REQUEST["email_address"] == "")
	{
		$GLOBALS["error_msg"] = "You must supply a valid email address";
		$GLOBALS["override_view"] = "login";
		return;
	}

	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	$sql = "select * from posman_users where email = '".dbchkstr($_REQUEST["email_address"])."'";

	$result = mysql_query($sql) or die("Error:#5:".mysql_error());

	if (mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
      $to = $row["email"];
      $subject = "Forgot Password > Holistic Systems Position Manager";
      $body = "Hi ".$row["first_name"].",\n\nYou requested your password from Holistic Systems Position Manager.\n\nYour password is ".$row["password"]."\n\nKind Regards\n\nHolistic Systems";
      $headers = "From: ".$GLOBALS["from_email"]."\r\n"."X-Mailer: php";
      if (mail($to, $subject, $body, $headers)) {
        $GLOBALS["info_msg"] = "Your password has been sent to your registered email address";
       } else {
        $GLOBALS["error_msg"] = "Message delivery failed.";
       }
		$GLOBALS["override_view"] = "login";
		return;

	}
	else
	{
		$GLOBALS["error_msg"] = "Email addresss not recognised";
		$GLOBALS["override_view"] = "login";
		return;
	}

	mysql_close($conn);

	$GLOBALS["override_view"] = "login";

}


function actionLogin()
{
	if ($_REQUEST["email_address"] == "")
	{
		$GLOBALS["error_msg"] = "You must supply a valid email address";
		$GLOBALS["override_view"] = "login";
		return;
	}

	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	$sql = "select * from posman_users where email = '".dbchkstr($_REQUEST["email_address"])."' and password = '".dbchkstr($_REQUEST["password"])."'";

	$result = mysql_query($sql) or die("Error:#5:".mysql_error());

	if (mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		// $_SESSION["user"] = new user($row["id"], $row["email"], true);
		$_SESSION["user"]["id"] = $row["id"];
		$_SESSION["user"]["email"] = $row["email"];
		$_SESSION["user"]["is_authenticated"] = true;

		if(isset($_POST['remember']))
		{
      	setcookie("useruuid", $row["uuid"], time()+60*60*24*100, "/");
		}

	}
	else
	{
		$GLOBALS["error_msg"] = "User not recognised";
		$GLOBALS["override_view"] = "login";
		return;
	}

	mysql_close($conn);

	$GLOBALS["override_view"] = "";

}

function actionLogout()
{
	$_SESSION["user"] = null;
	setcookie("useruuid"); // delete authentication cookie
}

function actionRegister()
{
	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	$sql = "insert into posman_users (first_name, last_name, email, password, uuid) VALUES ('".dbchkstr($_REQUEST["first_name"])."','".dbchkstr($_REQUEST["last_name"])."','".dbchkstr($_REQUEST["email_address"])."','".dbchkstr($_REQUEST["password"])."','".uuid()."')";
	$result = mysql_query($sql) or die("Error:#6:".mysql_error());

	mysql_close($conn);
}

function actionSaveSearch()
{
	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	$sql = "insert into posman_users_search (user_id, position_name, search_terms, your_domains, competitor_domains, email_notifications ) VALUES ('".dbchkstr($_SESSION["user"]["id"])."','".dbchkstr($_REQUEST["position_name"])."','".dbchkstr($_REQUEST["keywords"])."','".dbchkstr($_REQUEST["your_domains"])."','".dbchkstr($_REQUEST["competitor_domains"])."','".dbchkstr($_REQUEST["email_notifications"])."')";
	$result = mysql_query($sql) or die("Error:#7:".mysql_error());

	mysql_close($conn);

	$GLOBALS["override_view"] = "search_saved_successfully";
}


function actionLoadPosition()
{
	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	$sql = "select * from posman_users_search where id = '".dbchkstr($_REQUEST["id"])."'";

	$result = mysql_query($sql) or die("Error:#9:".mysql_error());

	if (mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		if ($row["user_id"] != $_SESSION["user"]["id"])
		{
			die("<div class=\"error\">You do not have permission to execute the requested action</div>");
		}
		$_SESSION["search"]["keywords"] = $row["search_terms"];
		$_SESSION["search"]["your_domains"] = $row["your_domains"];
		$_SESSION["search"]["competitor_domains"] = $row["competitor_domains"];
	}

	mysql_close($conn);

	$GLOBALS["override_view"] = "go";

}

function actionDeletePosition()
{
	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	$sql = "delete from posman_users_search where id = '".dbchkstr($_REQUEST["id"])."'";

	$result = mysql_query($sql) or die("Error:#10:".mysql_error());

	mysql_close($conn);

	$GLOBALS["override_view"] = "positions";

}

function actionNewSearch()
{
	$_SESSION["search"] = null;
	$GLOBALS["override_view"] = "";
}

?>
