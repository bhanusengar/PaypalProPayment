<?php
// Set sandbox (test mode) to true/false.


// Set PayPal API version and credentials.
$sandbox = TRUE;
$api_version = '204.0';
$api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
$api_username = $sandbox ? 'bhanupay24-facilitator_api1.gmail.com' : '';
$api_password = $sandbox ? 'TW2MFTYRC3J8EHNR' : '';
$api_signature = $sandbox ? 'AFcWxV21C7fd0v3bYYYRCpSSRl31AlyWBKjjQis0slG8cF2cZsqgj0tS' : '';
