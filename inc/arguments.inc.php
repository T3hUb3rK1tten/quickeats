<?php

function getArguments($request)
{
    // Override if request arguments are not proper
    $arguments = array();

    // Defaults for below

    $arguments['limit'] = 50;
    if (array_key_exists('limit', $request))
    {
        $limit = sanitize_numeric($request['limit']);
        // Ignore if it doesn't seem numeric
        if (is_numeric($limit))
        {
            $arguments['limit'] = max(min($limit, 50), 1);
        }
    }

    $arguments['maxdistance'] = 10000;
    if (array_key_exists('maxdistance', $request))
    {
        $maxdistance = sanitize_numeric($request['maxdistance']);
        if (is_numeric($maxdistance))
        {
            // We expect miles from user, convert to meters here for API
            $arguments['maxdistance'] = max(min($maxdistance * 1609.344, 50000), 1000);
        }
    }
    $arguments['minprice'] = null;
    if (array_key_exists('minprice',$request))
    {
        $minprice = sanitize_numeric($request['minprice']);
        if (is_numeric($minprice))
        {
            $arguments['minprice'] = max(min($minprice, 4), 0);
        }
    }

    $arguments['maxprice'] = null;
    if (array_key_exists('maxprice',$request))
    {
        $maxprice = sanitize_numeric($request['maxprice']);
        if (is_numeric($maxprice))
        {
            $arguments['maxprice'] = max(min($maxprice, 4), 0);
        }
    }

    // No defaults for below

    if (array_key_exists('zip',$request))
    {
        $zip = sanitize_numeric($request['zip']);
        if (is_numeric($zip))
        {
            // Remove leading zeros
            $arguments['zip'] = ltrim($zip, "0");
        }
    }

    if (array_key_exists('latitude',$request) && array_key_exists('longitude',$_REQUEST))
    {
        $latitude = sanitize_numeric($request['latitude']);
        $longitude = sanitize_numeric($request['longitude']);
        if (is_numeric($latitude) && is_numeric($longitude))
        {
            $arguments['latitude'] = $latitude;
            $arguments['longitude'] = $longitude;
        }
    }

    if (array_key_exists('pagetoken', $request))
    {
        $pagetoken = sanitize_string($request['pagetoken']);
        $arguments['pagetoken'] = $pagetoken;
    }

    return $arguments;
}

?>