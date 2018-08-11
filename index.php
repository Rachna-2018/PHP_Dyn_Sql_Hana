<?php

$method = $_SERVER['REQUEST_METHOD'];


//process only when method id post

if($method == 'POST')
{
	
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	    
			     
	$com = $json->queryResult->parameters->command;
	
	/*$ENT_ROOM= $json->queryResult->parameters->ENT_ROOM;
	$ENT_LOC= $json->queryResult->parameters->ENT_LOC;
	$ENT_SAL= $json->queryResult->parameters->ENT_SAL;
	$ENT_OP= $json->queryResult->parameters->ENT_OP;
	$ENT_BUILT= $json->queryResult->parameters->ENT_BUILT;
	$ENT_SAL= $json->queryResult->parameters->ENT_SAL;
	$AREA_NUM= $json->queryResult->parameters->AREA_NUM;
	$ROOMS= $json->queryResult->parameters->ROOMS;
	$BUILT_YEAR= $json->queryResult->parameters->BUILT_YEAR;*/
	
			     
	$com = strtolower($com);
		
	if ($com == 'locality')
	{
		$ENT_ROOM= $json->queryResult->parameters->ENT_ROOM;
		$ENT_ROOM= strtoupper($ENT_ROOM);
		$ENT_LOC= $json->queryResult->parameters->ENT_LOC;
		$ENT_LOC= strtoupper($ENT_LOC);
		$ENT_OP= $json->queryResult->parameters->ENT_OP;
		$ENT_OP= strtoupper($ENT_OP);
		$ROOMS= $json->queryResult->parameters->ROOMS;
		if($ENT_ROOM == "") {$ENT_ROOM = 'BEDROOM';}
		if($ENT_LOC == "") {$ENT_LOC = 'LOCATION';}
		if($ENT_OP == "") {$ENT_OP = '0';}
		
		
	
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
		//$json_url = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013_DYN.xsjs?ENT_OP=WHICH&ENT_LOC=LOCATION&ENT_ROOM=BEDROOM&ENT_BUILT=0&ENT_SAL=0&COMMAND=locality&AREA_NUM=0&ROOMS=5&BUILT_YEAR=0&LOWSAL=0&HIGHSAL=0";
		$json_url = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013_DYN.xsjs?ENT_OP=$ENT_OP&ENT_LOC=$ENT_LOC&ENT_ROOM=$ENT_ROOM&ENT_BUILT=0&ENT_SAL=0&COMMAND=$com&AREA_NUM=0&ROOMS=$ROOMS&BUILT_YEAR=0&LOWSAL=0&HIGHSAL=0";
    		//$json_url    = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013.xsjs?cmd=locality&getRooms=$room";
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
		$speech = "$ROOMS bedroom houses are available in metro areas \n" ;
		foreach ($someobj["results"] as $value) 
		{
			$speech .= $value["METRO3"];
			$speech .= "\r\n";
			
			
       		 }
	//	$speech .="\r\n\n Which metro area will you prefer to get more info\n";
	}
	else if ($com == 'gethousesal')
	{
			
		$ENT_LOC= $json->queryResult->parameters->ENT_LOC;
		$ENT_LOC= strtoupper($ENT_LOC);
		$ENT_SAL = $json->queryResult->parameters->ENT_SAL;
		$ENT_SAL= strtoupper($ENT_SAL);
		$ENT_OP= $json->queryResult->parameters->ENT_OP;
		$ENT_OP= strtoupper($ENT_OP);
		$LOWSAL= $json->queryResult->parameters->lowsal;
		$HIGHSAL= $json->queryResult->parameters->highsal;
		if($ENT_LOC == "") {$ENT_LOC = 'LOCATION';}
		if($ENT_OP == "") {$ENT_OP = 'MANY';}
		if($ENT_SAL =="") {$ENT_SAL = 'INCOME';}
		
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
		//$json_url = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013_DYN.xsjs?ENT_OP=HOW%20MANY&ENT_LOC=LOCATION&ENT_ROOM=0&ENT_BUILT=0&ENT_SAL=EARN&COMMAND=gethousesal&AREA_NUM=0&ROOMS=0&BUILT_YEAR=0&LOWSAL=15000&HIGHSAL=20015";
    		$json_url = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013_DYN.xsjs?ENT_OP=$ENT_OP&ENT_LOC=$ENT_LOC&ENT_ROOM=0&ENT_BUILT=0&ENT_SAL=$ENT_SAL&COMMAND=$com&AREA_NUM=0&ROOMS=0&BUILT_YEAR=0&LOWSAL=$LOWSAL&HIGHSAL=$HIGHSAL";
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
		//$speech .="\r\n\n Which area will you prefer to get more info\n";
	}
	else if ($com == 'getcount')
	{
		$ENT_ROOM= $json->queryResult->parameters->ENT_ROOM;
		$ENT_ROOM= strtoupper($ENT_ROOM);
		$ENT_LOC= $json->queryResult->parameters->ENT_LOC;
		$ENT_LOC= strtoupper($ENT_LOC);
		$ENT_OP= $json->queryResult->parameters->ENT_OP;
		$ENT_OP= strtoupper($ENT_OP);
		$ENT_BUILT= $json->queryResult->parameters->ENT_BUILT;
		$ENT_BUILT= strtoupper($ENT_BUILT);
		$ROOMS= $json->queryResult->parameters->ROOMS;
		$AREA_NUM= $json->queryResult->parameters->AREA_NUM;
		$BUILT_YEAR= $json->queryResult->parameters->BUILT_YEAR;
		$LOWSAL= $json->queryResult->parameters->lowsal;
		$HIGHSAL= $json->queryResult->parameters->highsal;
		$ENT_SAL = $json->queryResult->parameters->ENT_SAL;
		$ENT_SAL= strtoupper($ENT_SAL);
		if($ENT_SAL =="") {$ENT_SAL = 'INCOME';}
		
		if($LOWSAL == "") {$LOWSAL = 0;}
		if($HIGHSAL == "") {$HIGHSAL = 0;}
		if($ENT_ROOM == "") {$ENT_ROOM = 'BEDROOM';}
		if($ENT_LOC == "") {$ENT_LOC = 'LOCATION';}
		if($ENT_OP == "") {$ENT_OP = 'MANY';}
		if($ENT_BUILT == "") {$ENT_BUILT = 'BUILT';}
		//echo $ENT_ROOM; echo $ENT_LOC; echo $ENT_OP; echo $ENT_BUILT;
		
		$AREA_NUM= strtoupper($AREA_NUM);
		$ROOMS= strtoupper($ROOMS);
		$BUILT_YEAR= strtoupper($BUILT_YEAR);
		
		//echo $AREA_NUM; echo $ROOMS; echo $BUILT_YEAR;
		//echo "\n";
		
		$userespnose = array("PLEASE IGNORE", "IGNORE","IGNORE IT", "ANY VALUE", "ANY" , "NO IDEA",);
		if (in_array($AREA_NUM, $userespnose)) {$AREA_NUM = '0';}
		if (in_array($ROOMS, $userespnose)) {$ROOMS = '0';}
		if (in_array($BUILT_YEAR, $userespnose)) {$BUILT_YEAR = '0';}
		
		//echo $AREA_NUM; echo $ROOMS; echo $BUILT_YEAR;
		
		$username    = "SANYAM_K";
    		$password    = "Welcome@123";
		$json_url = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013_DYN.xsjs?ENT_OP=$ENT_OP&ENT_LOC=$ENT_LOC&ENT_ROOM=$ENT_ROOM&ENT_BUILT=$ENT_BUILT&ENT_SAL=$ENT_SAL&COMMAND=getcount&AREA_NUM=$AREA_NUM&ROOMS=$ROOMS&BUILT_YEAR=$BUILT_YEAR&LOWSAL=$LOWSAL&HIGHSAL=$HIGHSAL";
    		//$json_url = "http://74.201.240.43:8000/ChatBot/Sample_chatbot/HADS_2013.xsjs?cmd=$com&getRooms=$room&getBuilt=$year&getLoc=$loc";
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
		// $area_text = " in ".$AREA_NUM. " metro area location";
		 //$year_text = " built in ". $BUILT_YEAR . " year ";
		 //$room_text = " having ". " $ROOMS ". " bedrooms ";
		 $area_text = " in $AREA_NUM metro area location";
		 $year_text = " built in $BUILT_YEAR year ";
		 $room_text = " having $ROOMS bedrooms ";
		$sal_text = " who earns between $LOWSAL and $HIGHSAL";
		if($AREA_NUM == 0 AND $BUILT_YEAR == 0 AND $ROOMS == 0)
		{
			$display_text = "";
		}
		else if($AREA_NUM != 0 AND $BUILT_YEAR != 0 AND $ROOMS != 0)
		{
			$display_text = $area_text.$year_text.$room_text;
		}
		else if($AREA_NUM != 0 AND $BUILT_YEAR == 0 AND $ROOMS == 0)
		{
			$display_text = $area_text;
		}
		else if($AREA_NUM == 0 AND $BUILT_YEAR != 0 AND $ROOMS == 0)
		{
			$display_text = $year_text;
		}
		else if($AREA_NUM == 0 AND $BUILT_YEAR == 0 AND $ROOMS != 0)
		{
			$display_text = $room_text;
		}
		else if($AREA_NUM != 0 AND $BUILT_YEAR != 0 AND $ROOMS == 0)
		{
			$display_text = $area_text.$year_text;
		}
		else if($AREA_NUM == 0 AND $BUILT_YEAR != 0 AND $ROOMS != 0)
		{
			$display_text = $year_text.$room_text;
		}
		else if($AREA_NUM != 0 AND $BUILT_YEAR == 0 AND $ROOMS != 0)
		{
			$display_text = $area_text.$room_text;
		}
		if($HIGHSAL == 0 and $LOWSAL == 0) {$sal_text = " "; }
		$display_text .= $sal_text;
		foreach ($someobj["results"] as $value) 
		{
			
			$speech = $value["AVAILCOUNT"]." houses are available " .$display_text;
			
			
			
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

