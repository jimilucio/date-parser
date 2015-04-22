<?php
//session var
date_default_timezone_set('Europe/Rome');
set_time_limit(600);
?>
<html>
  <head>
    <title>Date Parser</title>
  </head>
  <body>
    
    
    <header>
      <h1>Parse date</h1>
      <a href="index.php">Upload page</a>
    </header>

    <content>
      <ul>
      <?php
      if ($handle = opendir('./uploads/')) {

          /* This is the correct way to loop over the directory. */
          while (false !== ($entry = readdir($handle))) {
              if ($entry != '.' && $entry != '..' && $entry!='.DS_Store')
              echo "<li>$entry</li>";
          }

          closedir($handle);
      }
      ?>
      </ul>

      <fieldset>
        <legend>Upload CSV date</legend>
        <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
          <input type="hidden" name="action" value="upload">
          <!-- MAX_FILE_SIZE deve precedere campo di input del nome file -->
          <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
          <input type="file" name="parseFile" />
          <input type="submit" value="salva">
        </form>
      </fieldset>
    </content>
    
  </body>
</html>