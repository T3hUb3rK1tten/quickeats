<?php

error_reporting(E_ALL);

require_once 'inc/secret.inc.php';
require_once 'inc/sanitize.inc.php';
require_once 'inc/yelp.inc.php';
require_once 'inc/geo.inc.php';

// Default search parameters
$options = array();
$options['term'] = 'food';
$options['location'] = '75080';
$options['limit'] = 20;
$options['maxdistance'] = 15; // in miles

// Override if request arguments are not proper
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
if (array_key_exists('maxdistance', $_REQUEST))
{
    $maxdistance = sanitize_numeric($_REQUEST['maxdistance']);
    if (is_numeric($maxdistance))
    {
        // Limit from 1 to 50 miles
        $options['maxdistance'] = max(1, min($maxdistance, 50));
    }
}

// Fetch results in JSON format
$rawresults = request(SEARCH_PATH, $options);
$results = json_decode($rawresults);

// Connect to database
$db = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);
if ($db->connect_errno > 0)
{
    die('Unable to connect to database: ' . $db->connect_error);
}

// Return all rows in addlocations
// Could have database calculate distance and return within bounds, not enough rows yet to justify duplicate code
$queryaddlocations = <<<SQL
SELECT * FROM `addlocations`
SQL;
$queryaddlocationsresult = $db->query($queryaddlocations);

// Insert all businesses into results array, we'll calculate distances and cut off later
while($row = $queryaddlocationsresult->fetch_assoc())
{
    $newbusiness = new stdClass;
    $newbusiness->name = $row['name'];
    $newbusiness->url = $row['url'];
    $newbusiness->phone = $row['phone'];
    $newbusiness->image_url = $row['imageurl'];
    $newbusiness->location = new stdClass;
    $newbusiness->location->display_address = array($row['address']);
    $newbusiness->location->address = array($row['address']);
    $newbusiness->location->coordinate = new stdClass;
    $newbusiness->location->coordinate->latitude = array($row['latitude']);
    $newbusiness->location->coordinate->longitude = array($row['longitude']);

    $results->businesses[] = $newbusiness;
}

// Return all rows in removelocations
$queryremovelocations = <<<SQL
SELECT * FROM `removelocations`
SQL;
$queryremovelocationsresult = $db->query($queryremovelocations);

// Remove all businesses that have a matching ID in removelocations
while($row = $queryremovelocationsresult->fetch_assoc())
{
    for($i = 0; $i < count($results->businesses); $i++)
    {
        if ($results->businesses[$i]->id == $row['locationid'])
        {
            unset($results->businesses[$i]);
        }
    }
}

print_r($results);



//$business = get_business(BUSINESS_PATH . $business_id);

?>