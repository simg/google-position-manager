<?

class search_chart
{
	public function __constructor()
	{

	}

	public $search_terms;
	public $your_domains;
	public $competitor_domains;
	public $email_address;

	public $results;


	public function init()
	{
		for ($i=0; $i < count($this->your_domains); $i++)
		{
			$url = $this->your_domains[$i];
			$this->your_domains[$i] =  array("url"=>$url, "pos"=> array());
		}

		for ($i=0; $i < count($this->competitor_domains); $i++)
		{
			$url = $this->competitor_domains[$i];
			$this->competitor_domains[$i] = array("url"=>$url, "pos"=> array());
		}


		$this->get_google_results();
		if ($GLOBALS["get_domain_data"]) $this->get_domain_data();
		$this->process_data();

		if ($GLOBALS["set_cache"]) $this->save_to_cache();

	}



	private function save_to_cache()
	{
		// this code is inefficient because mysql_query does not allow multi-line sql statements !! this means you *have* to interate over each insert statement !!
		$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
		mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

		// save search terms / results to cache
		$sql = "insert into posman_search_terms (terms, results, updated) values";
		// Build SQL update string
		$first=true;
		for ($i=0; $i < count($this->results); $i++)
		{
			if ($this->results[$i]["from_cache"] == null)
			{
				// only do this if the results weren't loaded from the cache in the first place - no point in re-caching the same data
				if (!$first) $sql .= ",";
				$sql .= "('".$this->search_terms[$i]."','".serialize($this->results[$i])."','".date("Y-m-d H:m:s")."')\r\n";
				$first = false;
			}
		}
		// Send SQL query

		if (!$first)
		{
			$result = mysql_query($sql) or die("Error:#2:".mysql_error());
		}

		// save url data to cache
		if ($GLOBAL["get_domain_data"])
		{
   		$sql = "insert into posman_urls (url, page_rank, keyword_count, backlink_count, updated) values";
   		$first = true;
   		for ($i=0; $i < count($this->results); $i++)
   		{
   			for ($j=0; $j < count($this->results[$i]); $j++)
   			{
   				$result = &$this->results[$i][$j];
   				if ($result["updated"] == null)
   				{
   					// only do this if the results weren't loaded from the cache in the first place - no point in re-caching the same data
   					if (!$first) $sql .= ",";
   					$sql .= "('".$result["url"]."','".$result["page_rank"]."','".$result["keyword_count"]."','".$result["num_backlinks"]."','".date ("Y-m-d H:m:s")."')\r\n";
   					$first = false;
   				}
   			}
   		}

   		// Send SQL query
   		if (!$first)
   		{
   			$result = mysql_query($sql) or die("Error:#1:".mysql_error());
   		}
		}
	}


	public function display_list_of_positions($result_idx, $type)
	{

		$h = "<span class=\"positions\">";

		$first = true;
		for ($i=0; $i < count($this->results[$result_idx]); $i++)
		{
			if ($this->results[$result_idx][$i][$type] == true)
			{

				if (!$first) $h .= ",";
				$h .= " <a href=\"#\" title=\"".$this->get_domain($this->results[$result_idx][$i]["url"])."\">".$this->position_format($i+1)."</a>";
				$first = false;
			}
		}

		$h .= "</span>";

		return $h;

	}


	private function position_format($pos)
	{
		switch($pos)
		{
			case 11:
			case 12:
			case 13:
				return $pos."th";
				break;
		}
		// else
		switch(substr($pos, strlen($position)-1))
		{
			case 1:
				return $pos."st";
				break;
			case 2:
				return $pos."nd";
				break;
			case 3:
				return $pos."rd";
				break;
			default:
				return $pos."th";
				break;
		}
	}

	private function process_data()
	{

		$c=0;
		for ($i=0; $i < count($this->results); $i++)
   	{
			   for($k=0; $k < $GLOBALS["max_results"]; $k++)
      		{
					//if (++$c > 60) break;
					$domain_pos = $this->is_your_domain($this->results[$i][$k]["url"]);

					// clear any previous results left over from unsophisticated caching
					$this->results[$i][$k]["yours"] = null;
					$this->results[$i][$k]["your_domain"] = null;
					$this->results[$i][$k]["competitors"] = null;
					$this->results[$i][$k]["competitor_domain"] = null;

					if ( $domain_pos > 0)
					{
						$this->results[$i][$k]["yours"] = true;
						$this->results[$i][$k]["your_domain"] = $this->results[$i][$k]["url"];
						//echo "count(this->your_domains[domain_pos][pos])=".$this->your_domains[$domain_pos]."<br/>";
						$this->your_domains[$domain_pos-1]["pos"][count($this->your_domains[$domain_pos]["pos"])] = (1+($i*$k));

					}
					else
					{
						$domain_pos = $this->is_competitor_domain($this->results[$i][$k]["url"]);
   					if ($domain_pos > 0)
   					{

   						$this->results[$i][$k]["competitors"] = true;
							$this->results[$i][$k]["competitor_domain"] = $this->results[$i][$k]["url"];
							$this->competitor_domains[$domain_pos-1]["pos"][count($this->competitor_domains[$domain_pos]["pos"])] = (1+($i*$k));
   					}
					}
      		}
		}

	}

	private function is_your_domain($url)
	{
		$url_domain = $this->get_domain($url);

		for ($i=0; $i < count($this->your_domains); $i++)
		{

			if ($url_domain == $this->get_domain($this->your_domains[$i]["url"]))
				return $i+1;
		}
		return 0;
	}

	private function is_competitor_domain($url)
	{
		//if (count($this->competitor_domains) == 0) return 0;
		$url_domain = $this->get_domain($url);
		for ($i=0; $i < count($this->competitor_domains); $i++)
		{
			if ($url_domain == $this->get_domain($this->competitor_domains[$i]["url"]))
				return $i+1;
		}
		return 0;

	}

	public function domain_type($domain)
	{
		if ($domain["yours"] == true)
			return "yours";
		else
		{
			if ($domain["competitors"] == true)
			return "competitors";
		}

	}

	private function get_domain($url)
	{

		$str = strtolower($url);
		$str = str_replace("http://","", $str);
		$str = str_replace("www.","", $str);
		$str = explode("/",$str);
		$str = $str[0];

		return $str;
	}

	private function load_search_from_cache($search_term_idx)
	{
		$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
		mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

		// get search terms from cache
		$sql = "select * from posman_search_terms where terms = '".dbchkstr($this->search_terms[$search_term_idx])."' order by updated desc  limit 1";
		// Send SQL query
		$result = mysql_query($sql) or die("Error:#3:".mysql_error());


		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result,MYSQL_ASSOC);
			$this->results[$search_term_idx] = unserialize($row["results"]);
			$this->results[$search_term_idx]["from_cache"] = true;
			return true;
		}
		else
		{
			$this->results[$search_term_idx] = null;
			return false;
		}


	}

	private function get_google_results()
	{
		for ($i=0; $i < count($this->search_terms); $i++)
   	{
			if (!$GLOBALS["caching"] || !$this->load_search_from_cache($i))
			{
      		$keywords = $this->search_terms[$i];
          for ($j=0; $j < ($GLOBALS["max_results"]/4); $j++)
         	{
         	   $url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".urlencode($keywords)."&start=".($j*4);
            	$ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $url);
      			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_REFERER, "http://www.holisticsystems.co.uk/search_chart");

         		$body = curl_exec($ch);

         		// now, process the JSON string
               $json = json_decode($body, true);

         		// extract the results
         		$result = $json["responseData"]["results"];

         		//combine the results for all api calls and filter out unused data
         		for($k=0; $k < count($result); $k++)
         		{
						//echo "url=".$result[$k]["url"]."<br/>";
         			$this->results[$i][($j*4)+$k]["url"] = $result[$k]["url"];
         		}

               curl_close($ch);
				}
   		}
		}

	}

	private function load_domain_data_from_cache($search_term_idx, $result_idx)
	{
		$url = $this->results[$search_term_idx][$result_idx]["url"];
		$sql = "select * from posman_urls where url = '".dbchkstr($url)."' order by updated desc limit 1";

		$conn = mysql_connect($GLOBALS["db_host"],$GLOBALS["db_user"],$GLOBALS["db_password"], true) or die(mysql_error());
		mysql_select_db($GLOBALS["db_database"], $conn) or die(mysql_error());

		// get urls from cache

		// Send SQL query
		$result = mysql_query($sql) or die("Error:#4:".mysql_error());
		//echo "num_rows()=".mysql_num_rows($result)."<br/>";

		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result,MYSQL_ASSOC);

			$this->results[$search_term_idx][$result_idx]["page_rank"] = $row["page_rank"];
			$this->results[$search_term_idx][$result_idx]["keyword_count"] = $row["keyword_count"];
			$this->results[$search_term_idx][$result_idx]["num_backlinks"] = $row["backlink_count"];
			$this->results[$search_term_idx][$result_idx]["updated"] = $row["updated"];
			return true;
		}
		else
		{
			//$this->results[$search_term_idx] = null;
			return false;
		}
	}

	private function get_domain_data()
	{
		for ($i=0; $i < count($this->results); $i++)
		{
			for ($j=0; $j < count($this->results[$i]); $j++)
			{
				if (!$GLOBALS["caching"] || !$this->load_domain_data_from_cache($i,$j))
				{
					$this->results[$i][$j]["page_rank"] = get_page_rank($this->results[$i][$j]["url"]);
	 				$this->results[$i][$j]["keyword_count"] = get_keyword_density($this->results[$i][$j]["url"],$_POST["keywords"]);
					$this->results[$i][$j]["num_backlinks"] = get_num_backlinks($this->results[$i][$j]["url"]);
				}
			}
		}

	}

	private function old_process()
	{
		if ($caching == true)
		{
	   	$results = get_cache($_POST["keywords"]);
			if ($results != null) $cache_hit = true; else $cache_hit = false;
		}
		else
		{
			$results = null;
			$cache_hit = false;
		}

		if ($cache_hit)
		{
			echo "<div id=\"cache_hit\">Results loaded from cache taken @ ".  date ("F d Y H:i:s.",cache_time($_POST["keywords"])) ."</div>";
		} else {
			echo "<div id=\"cache_hit\">Please be patient. Calculating this isn't easy !!</div>";
		}

		/* cache results */
		if ($cache_hit == false) set_cache($_POST["keywords"],$results);


	}



}

?>
