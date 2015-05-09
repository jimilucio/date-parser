<?php
error_reporting(-1);
ini_set('display_errors', 'On');

//session var
date_default_timezone_set('Europe/Rome');
set_time_limit(600);

define("DATA_FOLDER", 'uploads/data/');
define("DATE_LIST", 'uploads/date_list/');
define("RESULTS", 'result/');

?>
<html>
  <head>
  	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Date Parser</title>
    <link rel="stylesheet" href="bower_components/foundation/css/foundation.min.css" />
    <link rel="stylesheet" href="assets/style.css" />
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
  </head>
  <body>
    

    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="#">DateParser</a></h1>
        </li>
         <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
      </ul>

      <section class="top-bar-section">
        <!-- Right Nav Section -->
        <?php echo $request->pathname();?>
        <ul class="right">
          <li class="<?php if ($request->pathname() == "/") { echo "active"; }?>">
            <a href="/">Upload</a></li>
          <li class="<?php if ($request->pathname() == "/parse") { echo "active"; }?>">
            <a href="/parse">Parse</a>
          </li>
        </ul>

        
      </section>
    </nav>
    
    