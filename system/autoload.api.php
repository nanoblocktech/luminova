<?php
require_once(__DIR__ . '/vendor/autoload.php');
use \Luminova\DatabaseManager\Query;
use \Luminova\Config\DotEnv;
use \Luminova\SessionManager\Session;
// Initialize the session manager
Session::initializeSessionManager();

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Get the Singleton instance with the desired type
$session = Session::getInstance(Session::LIVE);

/*
Register dot environment variables
*/
DotEnv::register( dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env' );

/*
Initialize database instance for queries
*/
//$query = new Query();
$query = Query::getInstance();