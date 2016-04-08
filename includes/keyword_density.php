<?

function get_keyword_density($url,$keywords)
{
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_REFERER, "http://www.holisticsystems.co.uk/search_chart");

   $body = curl_exec($ch);
	curl_close($ch);

	$pattern = '/'.strtolower(str_replace(" ","|",$keywords)).'/';
	preg_match_all($pattern, strtolower($body), $matches);

	return count($matches[0]);

}


function get_num_backlinks($url)
{
	$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=link:".$url;

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_REFERER, "http://www.holisticsystems.co.uk/search_chart");

   $body = curl_exec($ch);
	$json = json_decode($body, true);
	curl_close($ch);

	$num_backlinks = $json["responseData"]["cursor"]["estimatedResultCount"];

	return $num_backlinks;
}
