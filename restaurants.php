<?php

error_reporting(E_ALL);

require_once 'inc/secret.inc.php';
require_once 'inc/sanitize.inc.php';
require_once 'inc/yelp.inc.php';
require_once 'inc/geo.inc.php';

// Connect to database
$db = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);
if ($db->connect_errno > 0)
{
    die('Unable to connect to database: ' . $db->connect_error);
}

// Contains user-specified data
$arguments = array();

// Override if request arguments are not proper
if (array_key_exists('term',$_REQUEST))
{
    $arguments['term'] = sanitize_string($_REQUEST['term']);
}

if (array_key_exists('limit', $_REQUEST))
{
    $limit = sanitize_numeric($_REQUEST['limit']);
    // Ignore if it doesn't seem numeric
    if (is_numeric($limit))
    {
        $arguments['limit'] = $limit;
    }
}

if (array_key_exists('maxdistance', $_REQUEST))
{
    $maxdistance = sanitize_numeric($_REQUEST['maxdistance']);
    if (is_numeric($maxdistance))
    {
        // Limit from 1 to 24.855 miles, but distance to API is specified in meters
        // We expect miles from user, convert to meters here
        $arguments['maxdistance'] = $maxdistance * 1609.344;
    }
}

if (array_key_exists('zip',$_REQUEST))
{
    $zip = sanitize_numeric($_REQUEST['zip']);
    if (is_numeric($zip))
    {
        // Remove leading zeros
        $arguments['zip'] = ltrim($zip, "0");
    }
}

if (array_key_exists('latitude',$_REQUEST) && array_key_exists('longitude',$_REQUEST))
{
    $latitude = sanitize_numeric($_REQUEST['latitude']);
    $longitude = sanitize_numeric($_REQUEST['longitude']);
    if (is_numeric($latitude) && is_numeric($longitude))
    {
        $arguments['latitude'] = $latitude;
        $arguments['longitude'] = $longitude;
    }
}

// If there is a zip but no coordinates, look up approximate coordinates from database
if (array_key_exists('zip', $arguments) && (!array_key_exists('latitude', $arguments) || !array_key_exists(('longitude'), $arguments)))
{
    $queryzipcoordinate = <<<SQL
SELECT `latitude`, `longitude` FROM `zipcoordinates`
WHERE `zip` = ?
SQL;

    $stmt = $db->prepare($queryzipcoordinate);
    $stmt ->bind_param('i', $arguments['zip']);
    $stmt->execute();
    $stmt->bind_result($latitude, $longitude);
    $stmt->fetch();
    $arguments['latitude'] = $latitude;
    $arguments['longitude'] = $longitude;
    $stmt->free_result();
}

// If there are coordinates but no zip

print_r($arguments);

// Yelp API options
$options = array();
$options['term'] = (array_key_exists('term', $arguments)) ? $arguments['term'] : 'food';
$options['location'] = (array_key_exists('zip', $arguments)) ? $arguments['zip'] : 'null';
$options['cll'] = (array_key_exists('latitude', $arguments) && array_key_exists('longitude', $arguments)) ? $arguments['latitude'] . ',' . $arguments['longitude'] : '';
$options['limit'] = (array_key_exists('limit', $arguments)) ? min(max($arguments['limit'], 20), 1) : 20; // limited by Yelp to 20, can request another 20
$options['maxdistance'] = (array_key_exists('maxdistance', $arguments)) ? min(max($arguments['maxdistance'], 40000), 1) : 15000; // in meters

// Fetch results in JSON format
$rawresults = request(SEARCH_PATH, $options);
$results = json_decode($rawresults);

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

// If we have only a ZIP and no lat/long, we'll have to look it up

// Calculate distance of user to each business
foreach ($results->businesses as $key => $value)
{

}

print_r($results);



//$business = get_business(BUSINESS_PATH . $business_id);

?>