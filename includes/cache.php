<?

function get_cache($id)
{
	$id = strtolower($id);
   $myFile = "cache/$id";
	if (file_exists($myFile))
	{
   	$fh = fopen($myFile, 'r');
	   $theData = fread($fh, filesize($myFile));
   	fclose($fh);
	   return json_decode($theData, true);
	}
	else {
		return null;
	}
}


function set_cache($id, $data)
{
	$id = strtolower($id);
   $myFile = "cache/$id";
   $fh = fopen($myFile, 'w');
	
   $stringData = json_encode($data);
   fwrite($fh, $stringData);
   fclose($fh);
}

function cache_time($id)
{
	$id = strtolower($id);
	return filemtime("cache/$id");

}

?>