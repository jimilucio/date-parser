<?php 
error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__ . '/vendor/autoload.php';

$klein = new \Klein\Klein();

$klein->respond(array('POST','GET'), '/', function ($request) {
    include ("header.php");
    include ("./upload.php");
});
$klein->respond(array('POST','GET'), '/parse', function ($request) {
    include ("header.php");
    include ("parse.php");
});


$klein->dispatch();

?>