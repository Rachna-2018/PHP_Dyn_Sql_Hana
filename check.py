<?php

$method = $_SERVER['REQUEST_METHOD'];


//process only when method id post

if($method == 'POST')
{
	
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$text = $json->queryResult->parameters->text;
	$text=strtoupper($text);
	
	
	if ($text=='HANA')
	{
		$speech="SAP HANA is an in-memory, column-oriented, relational database management system";
		
	}
	else if($text == 'MySQL')
	{
		
		$speech="MySQL is an open-source relational database management system (RDBMS).";
	}
	else if($text == 'DATABASE')
	{
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
    		$json_url    = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/hana_demo.xsjs";
		$ch      = curl_init( $json_url );
    		$options = array(
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		$someArray = json_decode($json, true);
		$database=  $someArray[0]["DATABASE_NAME"];
		$speech = " Database name is $database" ;
	}
	
	/*else
	{
		$speech = "Input something else";
	}*/
		
		$com = $json->queryResult->parameters->command;
		$com = strtolower($com);
		
		
		
	
	if ($com == 'locality')
	{
		$room = $json->queryResult->parameters->rooms;
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
    		$json_url    = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013.xsjs?cmd=$com&getRooms=$room";
		$ch      = curl_init( $json_url );
    		$options = array(
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		$someobj = json_decode($json,true);
		$speech = "$room bedroom houses are available in metro areas \n" ;
		foreach ($someobj["results"] as $value) 
		{
			$speech .= $value["METRO3"];
			$speech .= "\r\n";
			
			
       		 }	
	}
	else if ($com == 'salary' || $com == 'income')
	{
		$lowsal = $json->queryResult->parameters->lowsal;
		$highsal = $json->queryResult->parameters->highsal;
		$com = "gethousesal";
		
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
    		$json_url    = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013.xsjs?cmd=$com&totSalLow=$lowsal&totSalHigh=$highsal";
		$ch      = curl_init( $json_url );
    		$options = array(
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		$someobj = json_decode($json,true);
		//$speech = "houses are available in metro areas $json" ;
		foreach ($someobj["results"] as $value) 
		{
			$speech .= $value["HOUSE_COUNT"]. " houses available in ".$value["METRO3"]." area";
			$speech .= "\r\n";
			
			
       		 }	
	}
	else if ($com == 'metro')
	{
		$room = $json->queryResult->parameters->rooms;
		$year = $json->queryResult->parameters->year;
		$loc = $json->queryResult->parameters->location;
		$com = "getcount";
		
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
    		$json_url    = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013.xsjs?cmd=$com&getRooms=$room&getBuilt=$year&getLoc=$loc";
		$ch      = curl_init( $json_url );
    		$options = array(
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		$someobj = json_decode($json,true);
		//$speech = "houses are available in metro areas $json" ;
		foreach ($someobj["results"] as $value) 
		{
			$speech = $value["AVAILCOUNT"]. " houses are available in ". $loc. " metro area location";
			$speech .= " built in ". $year . " year having ". " $room ". " bedrooms";
			
			
			
       		 }
	}
	else if($com == 'status')
	{
		
		$com = "tablestatus";
		$schema = $json->queryResult->parameters->schema;
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
    		$json_url    = "http://74.201.240.43:8000/ChatBot/chatbot/HADS_2013.xsjs?cmd=$com&getSchema=$schema";
		$ch      = curl_init( $json_url );
    		$options = array(
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		$someobj = json_decode($json,true);
		$speech = "STATUS   TABLE NAME   TOTAL_RECORDS   MEMORY_SIZE_MAIN   MEMORY_SIZE_DELTA\n\n" ;
		foreach ($someobj["results"] as $value) 
		{
			$speech .= $value["LOADED"]. "  ".$value["TABLE_NAME"]."  ".$value["RECORD_COUNT"]. "  ".$value["MEMORY_SIZE_IN_MAIN"]. "  ".$value["MEMORY_SIZE_IN_DELTA"];
			$speech .= "\r\n";
			
			
       		 }	
	}	
	$response = new \stdClass();
    	$response->fulfillmentText = $speech;
    	$response->source = "webhook";
	echo json_encode($response);

}
else
{
	echo "Method not allowed";
}

?>

