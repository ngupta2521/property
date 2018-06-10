<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('checkRequireParams'))
{
	function checkRequireParams($requested_params,$params_to_check){
		foreach($params_to_check as $index=>$param){
			if(array_key_exists($param,$requested_params) && is_array($requested_params[$param]) && count($requested_params[$param])>0){
				unset($params_to_check[$index]);
			}
			if(array_key_exists($param,$requested_params) && trim($requested_params[$param]!="")){
				unset($params_to_check[$index]);
			}
		}

		return $params_to_check;
	}
}

if (!function_exists('checkUserRole')){

	function checkUserRole($userRole){
		$userRoles = array('ADMINISTRATOR','USER');
		if(!in_array($userRole, $userRoles)){
			return false;
		}
		return true;
	}
}

if (!function_exists('replaceNullWithEmpty'))
{
	function replaceNullWithEmpty(&$value){
    	$value = $value === null ? "" : $value;		
	}
}

if (!function_exists('delTree'))
{
	function delTree($dir) {
	   $files = array_diff(scandir($dir), array('.','..'));
	    foreach ($files as $file) {
	      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	    }
	    return rmdir($dir);
	  } 
}


function getDates($date)
{
	$seconds = strtotime(date("Y-m-d h:i:s")) - strtotime($date);
	$Greaterseconds = strtotime($date)-strtotime(date("Y-m-d h:i:s"));

	$days    = floor($Greaterseconds / 86400);
	$hours   = floor(($Greaterseconds - ($days * 86400)) / 3600);
	$minutes = floor(($Greaterseconds - ($days * 86400) - ($hours * 3600))/60);
	$seconds = floor(($Greaterseconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
	//echo "Days :: ".$days;
	if($days>0)
	{
		$week=0;
			
		if($days>1 && $days<7)
		{
			return $days." Days to go";
		}
		else
		{
			while($days>0)
			{
				$week=$week+1;
				$days=$days-7;
			}
			return $week." Week to go";
		}
	}
	else if($hours>0)
	{
		return $hours." Hours to go";
	}
	else if($minutes>0)
	{
		return $minutes." Minutes to go";
	}
	else
	{
		return $seconds." Seconds to go";
	}
}
	function getBeforeDates($date){

	$date1=date("Y-m-d h:i:s");

	/* $diff = abs( strtotime( $date1 ) - strtotime( $date ) );

	$days    =  intval( $diff / 86400 );
	$hours   = intval( ( $diff % 86400 ) / 3600);
	$minutes = intval( ( $diff / 60 ) % 60 );
	$seconds = intval( $diff % 60 );


	*/

	//echo "days :: ".$days."--------hours ::: ".$hours." ---- minuteds :: ".$minutes."----seconds :: ".$seconds;
	$seconds = strtotime(date("Y-m-d H:i:s")) - strtotime($date);
	//$Greaterseconds = strtotime($date)-strtotime(date("Y-m-d h:i:s"));
	//echo "seconds :: ".$seconds;
	//echo "Greaterseconds :: ".$Greaterseconds;

	$days    = floor($seconds  / 86400);
	$hours   = floor(($seconds  - ($days * 86400)) / 3600);
	$minutes = floor(($seconds  - ($days * 86400) - ($hours * 3600))/60);
	$seconds = floor(($seconds  - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
	//echo "Days :: ".$days;


	/*$date1 = new DateTime('2006-04-12T12:30:00');
		$date2 = new DateTime('2006-04-14T11:30:00');

		$diff = $date2->diff($date1);

		$hours = $diff->h;
		$hours = $hours + ($diff->days*24);

		echo $hours;
		*/

	$message="";

	if($days>0)
	{
		$week=0;
			
		if($days>1 && $days<7)
		{
			$message=$days." Days ago";
		}
		else
		{
			while($days>0)
			{
				$week=$week+1;
				$days=$days-7;
			}
			$message=$week." Week ago";
		}
	}
	else if($hours>0)
	{
		$message=$hours." Hours ago";
	}
	else if($minutes>0)
	{
		$message=$minutes." Minutes ago";
	}
	else
	{
		$message=$seconds." Seconds ago";
	}

	//return $days."-".$hours."-".$minutes."-".$seconds." :::::: ".$message;
	return $message."";
}

function prepareImageUrl($url){	
	/*if(!empty($url) && !preg_match('@^(http\\:\\/\\/|https\\:\\/\\/)?([a-z0-9][a-z0-9\\-]*\\.)+[a-z0-9][a-z0-9\\-]*$@i', $url)){
		return base_url().$url;
	}*/
	
	$regex = "((https?|ftp)://)?"; // SCHEME
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,4})"; // Host or IP
    $regex .= "(:[0-9]{2,5})?"; // Port
    $regex .= "(/([a-z0-9+\$_%-]\.?)+)*/?"; // Path
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+/\$_.-]*)?"; // GET Query
    $regex .= "(#[a-z_.-][a-z0-9+$%_.-]*)?"; // Anchor
    
    
	if(!empty($url) && !preg_match("~^$regex$~i", $url)){
		return base_url().$url;
	}
	
	return $url;
}

function getLatLong($address_array){
	$final_array = array();
	foreach($address_array as $item){
		if(!empty(trim($item))){
			$final_array[] = $item;		
		}
	}	
	$address_str = implode(",",$final_array);
	
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address_str."&sensor=false";
	
	
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      $details = curl_exec($ch);
      curl_close($ch);
      
    //$details=file_get_contents($url);
    $result = json_decode($details,true);
    
    $array_to_return = array('latitude'=>"0.00","longitude"=>"0.00");
    
    if(is_array($result) && "OK"==$result['status']){
    	$array_to_return['latitude'] = $result['results'][0]['geometry']['location']['lat'];
    	$array_to_return['longitude'] = $result['results'][0]['geometry']['location']['lng'];	
    }
    
	return $array_to_return;
}