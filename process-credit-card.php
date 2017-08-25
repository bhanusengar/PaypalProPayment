<?php
ini_set('max_execution_time', 0);
// Include config file
require_once('includes/config.php');
date_default_timezone_set('America/Chicago');
echo date('d-M-Y').'<br>';
//date_default_timezone_set("Asia/Kolkata");
$DaysTimestamp = strtotime('now');
$Mo = date('m', $DaysTimestamp);
$Day = date('d', $DaysTimestamp);
$Year = date('Y', $DaysTimestamp);
$StartDateGMT = $Year . '-' . $Mo . '-' . $Day . 'T00:00:00\Z';

// Store request params in an array
$request_params = array
					(
					'METHOD' => 'CreateRecurringPaymentsProfile', 
					'USER' => $api_username, 
					'PWD' => $api_password, 
					'SIGNATURE' => $api_signature, 
					'VERSION' => $api_version, 
					'PAYMENTACTION' => 'Sale', 					
					'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
					'CREDITCARDTYPE' => 'Visa', 
					'ACCT' => '4111111111111111', 						
					'EXPDATE' => '032018', 			
					'CVV2' => '123', 
					'FIRSTNAME' => 'Tester', 
					'LASTNAME' => 'Testerson', 
					//'STREET' => '707 W. Bay Drive', 
					//'CITY' => 'Largo', 
					//'STATE' => 'FL', 					
					//'COUNTRYCODE' => 'US', 
					//'ZIP' => '33770', 
					'PHONENUMBER'=>'+919051536268',
					'EMAIL'=>'abc@mail.com',
					'AMT' => '20', 
					'CURRENCYCODE' => 'CAD', 
					'DESC' => 'Testing Payments Pro',
					'BILLINGPERIOD' => 'Day',
					'BILLINGFREQUENCY' => '1',
					'PROFILESTARTDATE' => $StartDateGMT,
					'MAXFAILEDPAYMENTS' => '3'	
					); 
				 //$amountTodiduct = ((30/100)*1);
	/* $request_params = array
                    (
                    'METHOD' => 'DoDirectPayment', 
                    'USER' => $api_username, 
                    'PWD' => $api_password, 
                    'SIGNATURE' => $api_signature, 
                    'VERSION' => $api_version, 
                    'PAYMENTACTION' => 'Sale',                   
                    'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CREDITCARDTYPE' => 'Visa', 
                    'ACCT' => '4900000000000086',                        
                    'EXPDATE' => '032018',           
                    'CVV2' => '123', 
                    'FIRSTNAME' => 'Tester', 
                    'LASTNAME' => 'Testerson', 
                    //'STREET' => '707 W. Bay Drive', 
                    //'CITY' => 'Largo', 
                    //'STATE' => 'FL',                     
                    //'COUNTRYCODE' => 'USD', 
                   // 'ZIP' => '33770', 
                    'AMT' => 100, 
                    'CURRENCYCODE' => 'USD', 
                   // 'DESC' => 'Testing Payments Pro'
                    ); */
					
// Loop through $request_params array to generate the NVP string.
$nvp_string = '';
foreach($request_params as $var=>$val)
{
	$nvp_string .= '&'.$var.'='.urlencode($val);	
}
echo $nvp_string;
echo '<br>';
// Send NVP string to PayPal and store response
$curl = curl_init();
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

$result = curl_exec($curl);
echo $result.'<br /><br />';
curl_close($curl);

// Parse the API response
$result_array = NVPToArray($result);

echo '<pre />';
print_r($result_array);

// Function to convert NTP string to an array
function NVPToArray($NVPString)
{
	$proArray = array();
	while(strlen($NVPString))
	{
		// name
		$keypos= strpos($NVPString,'=');
		$keyval = substr($NVPString,0,$keypos);
		// value
		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
		// decoding the respose
		$proArray[$keyval] = urldecode($valval);
		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
	}
	return $proArray;
}