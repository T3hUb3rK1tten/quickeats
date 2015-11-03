<?php

error_reporting(E_ALL);

require_once 'inc/secret.inc.php';
require_once 'inc/sanitize.inc.php';
require_once 'inc/yelp.inc.php';

// Default search parameters
$options = array();
$options['term'] = 'food';
$options['location'] = '75080';
$options['limit'] = 20;

// Override if request arguments are proper
if (array_key_exists('term',$_REQUEST))
{
    $options['term'] = sanitize_string($_REQUEST['term']);
}
if (array_key_exists('location',$_REQUEST))
{
    $options['location'] = sanitize_string($_REQUEST['location']);
}
if (array_key_exists('limit', $_REQUEST))
{
    $limit = sanitize_numeric($_REQUEST['limit']);
    // Ignore if it doesn't seem numeric
    if (is_numeric($limit))
    {
        // Limit to 25 results
        $options['limit'] = min($limit, 25);
    }
}

// Return results in JSON format
$rawresults = request(SEARCH_PATH, $options);
echo $rawresults;

//$results = json_decode($rawresults);
//print_r($results);
//$business = get_business(BUSINESS_PATH . $business_id);

?>