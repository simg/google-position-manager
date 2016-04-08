<?
session_start();
//unset($_SESSION['user']);
include 'config/settings.php';
include 'includes/functions.php';
include 'includes/pagerank.php';
include 'includes/keyword_density.php';
include 'includes/cache.php';
include 'includes/actions.php';
include 'includes/views.php';
include 'includes/model.php';
include 'includes/user.php';

if (!$_SESSION["user"]["is_authenticated"])
{
   if(isset($_COOKIE['useruuid']))
	{
		$result = get_data_rows("select * from posman_users where uuid = '".dbchkstr($_COOKIE['useruuid'])."'");
		if (mysql_num_rows($result) > 0)
		{
			$_SESSION["user"]["id"] = $row["id"];
			$_SESSION["user"]["email"] = $row["email"];
			$_SESSION["user"]["is_authenticated"] = true;
		}
   }
}

switch(get_action())
{
	case "login":
		actionLogin();
		break;
	case "forgot password":
		actionForgotPassword();
		break;		
	case "register":
		actionRegister();
		break;
	case "logout":
		actionLogout();
		break;
	case "save search":
		actionSaveSearch();
		break;
	case "load_position":
		actionLoadPosition();
		break;
	case "delete_position":
		actionDeletePosition();
		break;					
	case "clear":
		actionNewSearch();
		break;					
		

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<HEAD>
<TITLE>Google Position Manager <? echo $GLOBALS["version_no"] ?></TITLE>
<link rel="stylesheet" href="style.css" type="text/css" />
<!--[if IE]>
<link rel="stylesheet" href="stylefix_IE.css" type="text/css" />
<![endif]-->
<link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script> 
<script type="text/javascript" src="js/jquery.corner.js"></script> 
</head>
  <body>
   <div id="page">
	<div id="header">
		<div id="title"><h1>Google Chart <? echo $GLOBALS["version_no"] ?></h1><div id="version"><? echo $GLOBALS["version_no"] ?></div></div>
		<div id="menu">
			<ul>
			<?
				if ($_SESSION["user"]["is_authenticated"] == true)
				{?>
				<li><a href="index.php?action=logout">Log out</a></li>
				<li><a href="index.php?view=positions">My positions</a></li>
			<? } else { ?>
				<li><a href="index.php?view=login">Login</a></li>
				<li><a href="index.php?view=register">Register</a></li>
			<? } ?>
			
				<li><a href="index.php?view=Help">Help</a></li>
				<li><a href="index.php">Search</a></li>
			</ul>
		</div>
	</div>

<?

//echo "get_action=".get_action()."<BR/>";
switch (get_view())
{
	default:
	case "search":
		showSearch();
		showAbout();
		break;
	case "go":
		showSearch();
		showResults();
		break;
	case "save / notify":
		showSearch();
		showUpdateNotify();
		break;
	case "login":
		showLogin();
		break;
	case "register":
		showRegister();
		break;
	case "about":
		showAbout();
		break;
	case "help":
		showHelp();
		break;		
	case "positions":
		showMyPositions();
		break;	
	case "upgrade":
		showUpgrade();
		break;			
	case "search_saved_successfully":
		showSearch();
		showSearchSaved();
		break;										
}
		

?>
	
  
  <div id="footer">
	  <a href="http://www.holisticsystems.co.uk">by Holistic Systems</a>
  </div>
  </div>
  	<script type="text/javascript">
  		//$(document).ready(function(){
			$("#page").corner("10px");
			$(".tablewrap").corner("10px");
			$(".panel").corner("10px");
			$(".searchBox").corner();
  		//});
	</script><noscript></noscript>	
  <script type="text/javascript"> 
     var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
     document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script><noscript></noscript> 
  <script type="text/javascript"> 
     var pageTracker = _gat._getTracker("UA-1761928-2");
     pageTracker._initData();
     pageTracker._trackPageview();
  </script><noscript></noscript> 
  
  </body>
</HTML>



