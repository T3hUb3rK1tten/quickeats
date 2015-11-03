<?php

/**
 * Yelp API connection based off
 * https://github.com/Yelp/yelp-api/tree/master/v2/php
 */

error_reporting(E_ALL);

require_once 'inc/secret.inc.php';
require_once 'inc/OAuth.inc.php';

define('API_HOST', 'https://api.yelp.com');
define('SEARCH_PATH', '/v2/search/');
define('BUSINESS_PATH', '/v2/business/');

/**
 * Makes a request to the Yelp API and returns the response
 *
 * @param    $path    The path of the API method
 * @param    $options The options to add to the query string
 * @return   The JSON response from the request
 */
function request($path, $options = null) {
    $unsigned_url = API_HOST . $path;
    if ($options !== NULL) {
        $unsigned_url .= "?" . http_build_query($options);
    }
    // Token object built using the OAuth library
    $token = new OAuthToken(TOKEN, TOKEN_SECRET);
    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer(CONSUMER_KEY, CONSUMER_SECRET);
    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();
    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer,
        $token,
        'GET',
        $unsigned_url
    );

    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);

    // Get the signed URL
    $signed_url = $oauthrequest->to_url();

    // Send Yelp API Call
    $ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    if ($data === FALSE)
    {
        // For certificate error on local XAMPP, refer to http://stackoverflow.com/a/31830614
        die ('CURL Error: ' . curl_error($ch));
    }
    curl_close($ch);

    return $data;
}

$options = array();
$options['term'] = 'food';
$options['location'] = '75080';
$options['limit'] = 10;

$results = json_decode(request(SEARCH_PATH, $options));

print_r($results);

//$business = get_business(BUSINESS_PATH . $business_id);


?>