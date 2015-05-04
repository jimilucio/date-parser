<?php include("header.php"); ?>
<?php include("class/upload.php"); ?>
    <content>
      <?php
      if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] === 'upload') {

        $file2Upload = $_FILES['parseFile'];

        if ($file2Upload['size'] == 0){
          print "Inserire un file valido";
          return;
        }

        $upload = new Upload($file2Upload);
        $upload->save(DATA_FOLDER);

      }

      ?>

      <div class="row">
        <div class="large-6 columns">
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
        </div>
        <div class="large-6 columns"></div>
      </div>

    </content>
    
  </body>
</html>