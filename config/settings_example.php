<?
//copy to settings.php and configure appropriately

$version_no = "V0.8";
$max_results = 32;
$caching=true;
$set_cache=true;
$get_domain_data=false;



$max_search_terms = 5;
$max_your_domains = 3;
$max_competitor_domains = 10;
$max_positions = 2;
if ($_SESSION["user"]["is_authenticated"])
{
	$max_search_terms = 10;
	$max_your_domains = 10;
	$max_competitor_domains = 20;
	$max_positions = 4;
}


$db_host="localhost";
$db_database="dbname";
$db_user="dbuser";
$db_password="dbpassword;

$from_email = "email@yourdomain.com";




if ($_REQUEST["usecache"] == "no") $caching = false;


?>
