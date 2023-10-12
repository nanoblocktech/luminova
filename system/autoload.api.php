<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
require_once(__DIR__ . '/plugins/autoload.php');
use \Luminova\Database\Query;
use \Luminova\Config\DotEnv;
use \Luminova\Sessions\Session;
use \Luminova\Sessions\SessionManager;
// Get the Singleton instance with the desired type
$session = Session::getInstance(new SessionManager());
// Initialize start session manager
$session->start();

/*
Register dot environment variables
*/
DotEnv::register( dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env' );

/*
Initialize database instance for queries
*/
//$query = new Query();
$query = Query::getInstance();