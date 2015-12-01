<?php

// We're unable to access the admin for our app to set the appropriate environment variables for these
define('CONSUMER_KEY', '');
define('CONSUMER_SECRET','');
define('TOKEN','');
define('TOKEN_SECRET','');

if (array_key_exists('OPENSHIFT_APP_NAME', $_ENV))
{
    // We're running on OpenShift
    define('MYSQL_DATABASE', 'mwa3');

    // Pre-defined in OpenShift Environment variables
    define('MYSQL_HOST', $_ENV["OPENSHIFT_MYSQL_DB_HOST"]);
    define('MYSQL_PORT', $_ENV["OPENSHIFT_MYSQL_DB_PORT"]);
    define('MYSQL_USERNAME', $_ENV["OPENSHIFT_MYSQL_DB_USERNAME"]);
    define('MYSQL_PASSWORD', $_ENV["OPENSHIFT_MYSQL_DB_PASSWORD"]);
}
else
{
    // Running locally
    define('MYSQL_DATABASE', 'quickeats_db');

    define('MYSQL_HOST', 'localhost');
    define('MYSQL_PORT', 3306);
    define('MYSQL_USERNAME', 'root');
    define('MYSQL_PASSWORD', '');
}

?>