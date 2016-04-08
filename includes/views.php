<?

function showHelp()
{
?>
<div class="content">
	<h1>Position Manager Help</h1>
	<p>Position Manager automates the laborious process of monitoring your search engine rankings for a chosen set of keywords.</p>
	<p><h3>Using Position Manager</h3>
		Enter your list of chosen keywords (ie the search keywords that you are competing for on your site). Optionally you can enter 1 or more domain names to keep track off. These domains will be highlighted in the search results and summary.</p>
	<p><h3>Saving your Searches</h3>
		Saving searches is a feature only available to registered users. Once you have registered, clicking on the "Save / Notify" button will prompt you to provide a "position" name and indicate if you want to be notified of changes.</p>
		<p>A "position" is our term for a related group of search terms and monitored domains. You can access your saved positions from the "My Positions" tab which is available to registered users.</p>
	<p><h3>Receiving Notifications</h3>
		Registered users can optionally receive notifications when yours or a competitors domain changes position in one of your monitored positions.</p>
	<p><h3>Restrictions</h3>
		Position Manager does a significant amount of processing to calculate your results. This means we have to apply certain restrictions to the usage of Position Manager.</p>
	<p>Unregistered users have quite a restricted interface that only allows a few search terms and domains. Registered users have approximately double the search terms and domains as unregistered users. If you blog about our service we will give you double the facilities of regular registered users to show our appreciation.</p>
</div>
<?

}

function showWhyRegister()
{
?>
	<h2>Why Register ?</h2>
	<p>Registration gives you the following benefits.</p>
	<ol>
		<li>Max Search Terms increased to 10</li>
		<li>Max "Your Domains" increased to 10</li>
		<li>Max Competitor Domains" increased to 20</li>
		<li>Maximum "positions" increased to 4</li>
		<li>Email notifications when your search positions change</li>
	</ol>
	<p>If you blog about Position Manager and include a link, we will double each of the above benefits</p>
	<p>Please note: we utterly respect your privacy and trust and will not send you marketing emails or pass on your email address to 3rd parties. When we sent out email notifications of position changes we do include a brief unobtrusive message about other quality services that we offer.</p>
<?
}

function showUpgrade()
{
?>
<div class="content"
	<h1>Upgrade your Membership</h1>
	<p>This is a beta version of Position Manager and as such does not yet allow any upgrades beyond registering on the site</p>
	<p>We expect to have premium accounts available shortly and will let all registered users know when these are available.</p>
	<p>In the mean time, blog about Position Manager and provide a link to our service and we will double your existing facilities.</p>
	<!--<p>Position Manager offers several levels of membership depending on your needs.</p>-->
</div>
<?
}

function showSearchSaved()
{
?>
	<div class="message_info">Position Saved</div>
<?
}

function showMyPositions()
{
	echo "<div class=\"positions\"><h1>My Positions</h1>";
	echo "<table><thead><tr><th> </th><th>Position Name</th><th>Delete</th></tr></thead>";
	echo "<tbody>";

	$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
	mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

	// get search terms from cache

	$sql = "select * from posman_users_search where user_id = '".dbchkstr($_SESSION["user"]["id"])."' order by search_terms";
	// Send SQL query
	$result = mysql_query($sql) or die("Error:#8:".mysql_error());
	//echo "num_rows()=".mysql_num_rows($result)."<br/>";

	if (mysql_num_rows($result) > 0)
	{
		$c=0;
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			echo "<tr><td>".++$c.".</td><td class=\"posname\"><a href=\"index.php?action=load_position&id=".$row["id"]."\">".$row["position_name"]."</a></td><td><a href=\"index.php?action=delete_position&id=".$row["id"]."\"><img src=\"images/button_delete.gif\" height=\"14\" width=\"14\" alt=\"Delete\" /></a></td></tr>";
		}
	}
	echo "</tbody></table></div>";
}

function showLogin()
{

?>

<div id="login">
	<h1>Log in</h1>
	<?
		if (!empty($GLOBALS["error_msg"])) echo "<div class=\"info_error\">".$GLOBALS["error_msg"]."</div>";
		if (!empty($GLOBALS["info_msg"])) echo "<div class=\"info_msg\">".$GLOBALS["info_msg"]."</div>";
	?>
	<form action="index.php" method="post" class="panel">
	<table class="form" summary="Login Form">
	<tr><td><label for="email_address">Email Address</label></td>
	<td><input type="textbox" id="email_address" name="email_address" class="inlinebox" value="<? echo $_POST["email_address"] ?>" /></td></tr>
	<tr><td><label for="password">Password</label></td><td><input type="password" id="password" name="password" class="inlinebox" value="<? echo $_POST["password"] ?>" /></td></tr>
	<tr><td><label for="remember">Remember Me</label></td><td><input type="checkbox" id="remember" name="remember" <? echo isset($_POST["remember"])?"checked":"" ?> /></td></tr>
	</table>
	<div class="buttons">
		<input type="submit" name="action" value="Login" />
		<input type="submit" name="action" value="Forgot Password" />
	</div>
	</form>
</div>

<?
}

function showRegister()
{
?>

<div id="register">
	<h1>User Registration</h1>
	<form action="index.php" method="post" class="panel">
	<table class="form" summary="Login Form">
	<tr><td><label for="first_name">First Name</label></td><td><input type="textbox" id="first_name" name="first_name" class="inlinebox" value="<? echo $_POST["first_name"] ?>" /></td></tr>
	<tr><td><label for="last_name">Last Name</label></td><td><input type="textbox" id="last_name" name="last_name" class="inlinebox" value="<? echo $_POST["last_name"] ?>" /></td></tr>
	<tr><td><label for="email_address">Email Address</label></td><td><input type="textbox" id="email_address" name="email_address" class="inlinebox" value="<? echo $_POST["email_address"] ?>" /></td></tr>
	<tr><td><label for="password">Password</label></td><td><input type="password" id="password" name="password" class="inlinebox" value="<? echo $_POST["password"] ?>" /></td></tr>
	</table>
	<div class="buttons">
		<input class="submit" type="submit" name="action" value="Register" />
	</div>
	</form>

	<? echo showWhyRegister()  ?>
</div>

<?


}

function showAbout()
{

?>
<div class="content">
<h1>About Position Manager</h1>
<p>Position Manager from Holistic Systems automates the laborious yet important task of monitoring your websites Google search engine rankings.</p>
<p>By using Position Manager, you gain clear visibilty over the results of your organic search marketing efforts.</p>
<p>Position Manager can send you regular email updates so that you can monitor your search engine ranking effortlessly.</p>
<p>For anyone with an interest in search engine rankings Position Manager provides a huge competitive advantage.</p>
</div>
<?

}

function showUpdateNotify()
{
?>
	<h1>Save Search / Notify Changes</h1>
<?
   if ($_SESSION["user"]["is_authenticated"] != true)
   {
   ?>
   	<p>This function is only available to <a href="index.php?view=register">registered users</a>.</p>
   	<p>Please <a href="index.php?view=login">login</a> or <a href="index.php?view=register">register</a></p>
   <?
   } else {
		$rows = get_data_rows("select user_id from posman_users_search where user_id = '".$_SESSION["user"]["id"]."'");
		if (mysql_num_rows($rows) >= $GLOBALS["max_positions"])
		{
			validation_error("You can only have a maximum of ".$GLOBALS["max_positions"]." saved positions. <a href=\"index.php?view=upgrade\">Upgrade</a>");
			return;
		} else {
		$position_name = $_REQUEST["position_name"];
		if (empty($_REQUEST["position_name"]))
		{
			$position_name = explode("\r",$_SESSION["search"]["keywords"]);
			$position_name = $position_name[0];
		}
	?>
   <div id="save-notify">
   	<form action="index.php" method="post">
		<input type="hidden" name="keywords" value="<? echo $_POST["keywords"] ?>" />
		<input type="hidden" name="your_domains" value="<? echo $_POST["your_domains"] ?>" />
		<input type="hidden" name="competitor_domains" value="<? echo $_POST["competitor_domains"] ?>" />
   	<table class="form" summary="Save / Notify Form">
   	<tr><td><label for="position_name">Position Name</label></td><td><input type="textbox" id="position_name" name="position_name" class="inlinebox" value="<? echo $position_name ?>" /></td></tr>
   	<tr><td><label for="email_notifications">Send Email Notifications</label></td><td><input type="checkbox" id="email_notifications" name="email_notifications" "<? echo empty($_POST["email_notifications"])?"":"checked" ?>" /></td></tr>
   	</table>
   	<input type="submit" name="action" value="Save Search" />
   	</form>
   </div>
   <?
	}}

}

function updateNotify()
{
	//if
	//{
		$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
		mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

		// save search terms / results to cache

		$sql = "insert into posman_users (email) values('".dbchkstr($_REQUEST["email"])."')";
		//echo "<pre>".$sql."</pre><br/>";
		$result = mysql_query($sql) or die("Error:#2:".mysql_error());
	//}

}

function showSearch()
{

if (!get_action("new search"))
{
	if (!empty($_POST["keywords"])) $_SESSION["search"]["keywords"] = $_POST["keywords"];
	if (!empty($_POST["your_domains"])) $_SESSION["search"]["your_domains"] = $_POST["your_domains"];
	if (!empty($_POST["competitor_domains"])) $_SESSION["search"]["competitor_domains"] = $_POST["competitor_domains"];
}
?>
<?
	if (!empty($GLOBALS["error_msg"])) echo "<div class=\"info_error\">".$GLOBALS["error_msg"]."</div>";
	if (!empty($GLOBALS["info_msg"])) echo "<div class=\"info_msg\">".$GLOBALS["info_msg"]."</div>";
?>
<form id="searchForm" action="index.php" method="post">

			<!--<div class="save">
      			<label for="email_address">Your Email Address</label>
      			<input type="textbox" id="email_address" name="email_address" class="inlinebox" value="<? echo $_POST["email_address"] ?>" />
					<input type="submit" name="view" value="Save / Notify" />
			</div>-->
 	<div class="searchBox xui-widget-content xui-corner-all">
		<!--<input type="hidden" name="view" value="results" />-->
			<!--<label for="keywords">Domains</label>
			<textarea id="domains" name="domains"><? echo $_POST["domains"] ?></textarea>-->

   			<div class="cell">
     			<label for="keywords">Search Terms &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(max <? echo $GLOBALS["max_search_terms"] ?>)</label></dt>
      			<textarea id="keywords" name="keywords" rows="5" columns="40" class="inputbox"><? echo $_SESSION["search"]["keywords"] ?></textarea>
   			</div>

				<div class="cell">
      			<label for="your_domains">Your domains &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(max <? echo $GLOBALS["max_your_domains"] ?>)</label>
      			<textarea id="your_domains" name="your_domains" rows="5" cols="40" class="inputbox"><? echo $_SESSION["search"]["your_domains"] ?></textarea>
				</div>

				<div class="cell">
   				<label for="competitor_domains">Competitor domains &nbsp; &nbsp; &nbsp; (max <? echo $GLOBALS["max_competitor_domains"] ?>)</label>
   				<textarea id="competitor_domains" name="competitor_domains" rows="5" cols="40" class="inputbox"><? echo $_SESSION["search"]["competitor_domains"] ?></textarea>
				</div>

				<!--<div class="cell">
      			<label for="email_address">Your email address </label>
      			<textarea id="email_address" name="email_address" rows="5" cols="40" class="inputbox"><? echo $_POST["email_address"] ?></textarea>
      		</div>-->

			<div class="clr"></div>
			<div id="buttons">
			<input type="submit" name="view" value="Go" />
			<input type="submit" name="view" value="Save / Notify" />
			<input type="submit" name="action" value="Clear" />
			<? if ($_SESSION["user"]["is_authenticated"]) { ?>
			<!--<a href="index.php?view=upgrade">Upgrade</a>-->
			<? } ?>
			</div>
	</div>

</form>
	<div class="clr"></div>
	<script type="text/javascript">
		$(document).ready(function(){
 			//$("#tabs").tabs();
		});
	</script><noscript></noscript>


<?
}

function showResults()
{
	//echo "hello<br/>";
	if ($_SESSION["search"]["keywords"] == "")
	{
		validation_error("Please enter up to ".$GLOBALS["max_search_terms"]." set of keywords (1 set per line)");
		return;
	}

	if (count(explode("\r",$_SESSION["search"]["keywords"])) > $GLOBALS["max_search_terms"])
	{
		validation_error("You can have a maximum of ".$GLOBALS["max_search_terms"]." set of keywords (1 set per line). <a href=\"index.php?view=upgrade\">Upgrade</a>");
		return;
	}

	if (count(explode("\r",$_SESSION["search"]["your_domains"])) > $GLOBALS["max_your_domains"])
	{
		validation_error("You can have a maximum of ".$GLOBALS["max_your_domains"]." 'your domains' (1 per line). <a href=\"index.php?view=upgrade\">Upgrade</a>");
		return;
	}

	if (count(explode("\r",$_SESSION["search"]["competitor_domains"])) > $GLOBALS["max_competitor_domains"])
	{
		validation_error("You can have a maximum of ".$GLOBALS["max_competitor_domains"]." competitor domains (1 per line). <a href=\"index.php?view=upgrade\">Upgrade</a>");
		return;
	}

	$chart = new search_chart();
	$chart->search_terms = explode("\r",trim(str_replace("\n","",$_SESSION["search"]["keywords"])));
	if (isset($_SESSION["search"]["your_domains"]))
		$chart->your_domains = explode("\r",trim(str_replace("\n","",$_SESSION["search"]["your_domains"])));
	if (isset($_SESSION["search"]["competitor_domains"]))
		$chart->competitor_domains = explode("\r",trim(str_replace("\n","",$_SESSION["search"]["competitor_domains"])));
	//$chart->email_address = explode("\r",trim(str_replace("\n","",$_POST["email_address"])));
	$chart->init();

	echo "\r<div class=\"summary xui-widget xui-widget-content xui-corner-all\"><p class=\"caption1\">Summary</p>";
	echo "<div class=\"tablewrap\"><div class=\"tablewrapinner\">";
	echo "<table class=\"results\" summary=\"Google Search Results Summary\">";
	echo "<thead><tr><th class=\"desc\">Keywords</th><th>Your positions</th><th>Competitor positions</th></tr></thead>";
	echo "<tbody>\r";
	for ($i=0; $i < count($chart->search_terms); $i++)
	{
		echo "<tr><td class=\"desc\"><a href=\"#result".$i."\" title=\"Click for Search Results\">".$chart->search_terms[$i]."</a></td><td>".$chart->display_list_of_positions($i,"yours")."</td><td>".$chart->display_list_of_positions($i,"competitors")."</td></tr>\r";
	}
	echo "</tbody></table></div></div></div>";
		
	for ($i=0; $i < count($chart->results); $i++)
	{
		echo "\r<div id=\"result".$i."\" class=\"searchResults xui-widget-content xui-corner-all\"><a name=\"result".$i."\"></a><p class=\"caption1\">Top ".$GLOBALS["max_results"]." Search Results for \"".trim($chart->search_terms[$i])."\"</p>";
		echo "<table class=\"results\" summary=\"Personalised Google Chart Data for Keywords - ".$_POST["keywords"]."\">";
   	echo "<thead><tr><th> </th><th class=\"url\">Url</th>\r";
		if ($GLOBALS["get_domain_data"]) echo "<th>Page Rank</th><th>Keyword Count</th><th>Backlinks Count</th>";
		echo "</tr></thead><tbody>";
		$c=0;
		for ($j=0; $j < $GLOBALS["max_results"]; $j++)
		{
			echo "<tr class=\"".$chart->domain_type($chart->results[$i][$j])."\"><td class=\"pos\">".++$c."</td><td class=\"url\"><div><a href=\"".$chart->results[$i][$j]["url"]."\" target=\"_blank\">".str_replace("http://","",$chart->results[$i][$j]["url"])."</a></div></td>";
			if ($GLOBALS["get_domain_data"])	echo "<td>".$chart->results[$i][$j]["page_rank"]."</td><td>".$chart->results[$i][$j]["keyword_count"]."</td><td>".$chart->results[$i][$j]["num_backlinks"]."</td>";
			echo "</tr>\r";
		}
		echo "</tbody></table></div>\r";
   }

	?>
	<script type="text/javascript">
		$(document).ready(function(){
   			//$("#tabs").tabs();
			$(".searchResults").hide();
			$("#result0").show();
			$(".summary A").click( function(){
				//alert("#"+this.href.split('#')[1]);
				$(".searchResults").hide();
				$("#"+this.href.split('#')[1]).show();
				return false;
			})
 			});
	</script><noscript></noscript>

	<?
}

function showWelcome()
{
?>
<div>
<h1>Welcome to Google Chart</h1>
<p><img src="images/google_chart_screen.png" width="300" height="201" alt="Google Chart Screen Shot" align="right" style="margin-left:15px;" border="1" />Google Chart is an SEO tool that at a glance allows you to see the top 32 search results for the entered search terms.</p>
<p>The results include interesting information about each link such as it's page rank, keyword count and the number of Google backlinks.</p>
<p>Give it a go by entering your favourite search terms above. The results may surprise you.</p>
<p>Note: Our server needs to do make a large number of requests per search so it does take about a minute to return all the results, unless we already have your results cached from a previous search.</p>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>
<?
}

?>
