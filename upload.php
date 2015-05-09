<?php
require_once __DIR__ . '/class/upload.php';

?>
<content>
  <?php
  $alert = '';
  $success = '';

  if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] === 'upload') {

    if (array_key_exists('dataFile', $_FILES) && $_FILES['dataFile']['name']) {
      
      $file2Upload = $_FILES['dataFile'];
      if ($file2Upload['size'] == 0){
        $alert = "Inserire un file zip valido";
      }
      $uploadFile = new UploadFile($file2Upload);
      $uploadFile->save(DATA_FOLDER);
      $alert = '';
      $success = 'File '. $file2Upload['name'].' uploaded!<br>';
      $success .= 'File size: '.$file2Upload['size'].'<br>';

    } else if (array_key_exists('dateList', $_FILES) && $_FILES['dateList']['name']) {
      
      $file2Upload = $_FILES['dateList'];
      if ($file2Upload['size'] == 0){
        $alert = "Inserire un file csv valido";
        
      }
      $uploadFile = new UploadFile($file2Upload);
      $uploadFile->save(DATE_LIST);
      $success = 'File '. $file2Upload['name'].' uploaded!<br>';
      $success .= 'File size: '.$file2Upload['size'].'<br>';

    }

  }

  ?>
  
  <div class="row">
    <div class="large-12 columns">
      <?php if ($alert) {?>
        <span class="[alert secondary] [round radius] label"><?php echo $alert;?></span>
      <?php } 
      if ($success) {?>
        <span class="[success primary] [round radius] label"><?php echo $success;?></span>
      <?php } ?>

    </div>
  </div>
  <div class="row">
    <div class="large-6 columns">
      <fieldset>
        <legend>Upload CSV completo</legend>
        <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
          <label>Insert file</label>
          <br>
          <input type="hidden" name="action" value="upload">
          <!-- MAX_FILE_SIZE deve precedere campo di input del nome file -->
          <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
          <input type="file" name="dataFile" />
          <br><br>
          <button type="submit" class="button">Upload!</button>
        </form>
      </fieldset>
    </div>
    <div class="large-6 columns">
      
      <fieldset>
        <legend>Upload list of date</legend>
        <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
          
          <label>Insert file</label>
          <br>
          <input type="hidden" name="action" value="upload">
          <!-- MAX_FILE_SIZE deve precedere campo di input del nome file -->
          <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
          <input type="file" name="dateList" />
          <br><br>
          <button type="submit" class="button">Upload!</button>
        </form>
      </fieldset>

    </div>
  </div>

</content>