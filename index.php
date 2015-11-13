<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(480);

/**
 * include vendor libs
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * $klein is a module to manage route and state information
 * @var [object]
 */
$klein = new \Klein\Klein();

/**
 * add post and get method when the root path is "/" (home)
 */
$klein->respond(array('POST','GET'), '/', function ($request) {
    include ("./header.php");
    include ("./upload.php");
});

/**
 * add post and get method when the root path is /parse
 */
$klein->respond(array('POST','GET'), '/parse', function ($request) {
    include ("./header.php");
    include ("./parse.php");
});

/**
 * dispatch data
 */
$klein->dispatch();
?>
