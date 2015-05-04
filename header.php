<?php
//session var
date_default_timezone_set('Europe/Rome');
set_time_limit(600);

define("DATA_FOLDER", './uploads/data/');
define("DATE_LIST", './uploads/date_list/');

?>
<html>
  <head>
  	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Date Parser</title>
    <link rel="stylesheet" href="./vendor/foundation-5.5.1.custom/css/foundation.css" />
    <script src="./vendor/foundation-5.5.1.custom/js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <div class="row">
      <div class="large-6 columns">
        <h1>Parse date</h1>
      </div>
      <div class="large-3 columns"><a href="index.php" class="small secondary button">Upload database</a></div>
      <div class="large-3 columns"><a href="parseHome.php" class="small secondary button">Parser page</a></div>
    </div>
    
    