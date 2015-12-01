<?php

error_reporting(E_ALL);

require_once 'inc/secret.inc.php';
require_once 'inc/sanitize.inc.php';
require_once 'inc/geo.inc.php';
require_once 'inc/GooglePlacesClient.inc.php';
require_once 'inc/GooglePlaces.inc.php';
require_once 'inc/arguments.inc.php';

// Connect to database
$db = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);
if ($db->connect_errno > 0)
{
    die('Unable to connect to database: ' . $db->connect_error);
}

// Contains user-specified data
$arguments = getArguments($_REQUEST);

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

// Places Search API object
$places = new joshtronic\GooglePlaces(GOOGLE_SERVER_KEY);
$places->location = array($arguments['latitude'], $arguments['longitude']);
$places->radius = $arguments['maxdistance'];
$places->types = array('restaurant', 'food');
$places->keyword = 'food';
$places->opennow = true;
$search = $places->nearbySearch();

// Return all rows in addlocations
// Could have database calculate distance and return within bounds, not enough rows yet to justify duplicate code
$queryaddlocations = <<<SQL
SELECT * FROM `addlocations`
SQL;
$queryaddlocationsresult = $db->query($queryaddlocations);

// Insert all businesses into results array, we'll calculate distances and cut off later
while($row = $queryaddlocationsresult->fetch_assoc())
{
    $newbusiness = array();
    $newbusiness['geometry']['location']['lat'] = $row['latitude'];
    $newbusiness['geometry']['location']['lng'] = $row['longitude'];
    $newbusiness['place_id'] = $row['id'];
    $newbusiness['name'] = $row['name'];
    $newbusiness['image_url'] = $row['imageurl'];
    $newbusiness['vicinity'] = $row['address'];
    $search['results'][] = $newbusiness;
}

// Return all rows in removelocations
$queryremovelocations = <<<SQL
SELECT * FROM `removelocations`
SQL;
$queryremovelocationsresult = $db->query($queryremovelocations);

// Remove all businesses that have a matching ID in removelocations
while($row = $queryremovelocationsresult->fetch_assoc())
{
    for($i = 0; $i < count($search['results']); ++$i)
    {
        if ($search['results'][$i]['place_id'] == $row['locationid'])
        {
            unset($search['results'][$i]);
        }
    }
}

// Calculate distance of user to each business
for($i = 0; $i < count($search['results']); $i++)
{
    $search['results'][$i]['distance'] = distanceBetweenPoints($arguments['latitude'], $arguments['longitude'], $search['results'][$i]['geometry']['location']['lat'], $search['results'][$i]['geometry']['location']['lng']);
}

// Now sort by distance
function resultsSortCompare($a, $b)
{
    return strcmp($a['distance'], $b['distance']);
}
usort($search['results'], 'resultsSortCompare');

echo json_encode($search);

?>