<?php include("header.php"); ?>
<?php include("class/folder.php"); ?>

    <content>
      <?php
        $folder = new Folder();
        $result = $folder->readFolder('uploads/database/');
      ?>
      <ul>

      </ul>

      <div class="row">
        <div class="large-6 columns">
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
        </div>
        <div class="large-6 columns"></div>
      </div>
    </content>
    
  </body>
</html>