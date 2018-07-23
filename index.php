<?php 
 
$method = $_SERVER['REQUEST_METHOD'];
 
// Process only when method is POST
if($method == 'POST'){
 
 
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);
 
    
    $Email = $json->queryResult->parameters->Email;
    $city = $json->queryResult->parameters->city;
    $show = $json->queryResult->parameters->show;	
	
	if (strlen($Email) >1){
 
 
	$to      = $Email;
	$subject = 'Chatbot - Backlog Summary';
	$message = 'We have 43,234 Backlogs, 5400 Exceptions and 50 Escalations effecting the total revenue of 5 billion';
	$headers = 'From: rachnarke@gmail.com' . "\r\n" .
    'Reply-To: rachnarke@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
   $speech = 'I have summarized the details and sent an email.. please check your inbox';

    
    }
	
	elseif (strlen($show) > 1){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/search?q=$show");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);			
	} 
	
	elseif(strlen($city) > 1) {	 

	$opts = array();
	$opts['http'] = array();
	$opts['http']['method']="GET";
	$opts['http']['header']="Accept-language: en\r\n"."Cookie: foo=bar\r\n";

	$t1=stream_context_create($opts);

	// Open the file using the HTTP headers set above
	$test_file=file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$city&appid=cbabb75bf7b81a74a62ff59e543b6b10", false, $t1);

	$file = json_decode($test_file);
	$weather_data = $file->weather[0]->description;
	$temp =  1.8*($file->main->temp - 273) +32 ;
	$speech = "Now the Weather in $city is $weather_data , The temperature is $temp F " ;
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
