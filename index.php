<?
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
      <a href="parseHome.php">Parse page</a>
    </header>

    <content>
    <?php
    

    if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] === 'upload') {

      $file2Upload = $_FILES['parseFile'];

      if ($file2Upload['size'] == 0){
        print "Inserire un file valido";
        return;
      }

      $uploaddir = './uploads/';
      $uploadfile = $uploaddir . date('Ymdhis'). '_'. basename($file2Upload['name']);
      
      echo '<pre>';
      if (move_uploaded_file($file2Upload['tmp_name'], $uploadfile)) {
          echo "File is valid, and was successfully uploaded.\n";
      } else {
          echo "Possibile attacco tramite file upload!\n";
      }

      // echo 'Alcune informazioni di debug:';
      // print_r($file2Upload);

      print "</pre>";

    }
    ?>

      <fieldset>
        <legend>Upload CSV completo</legend>
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