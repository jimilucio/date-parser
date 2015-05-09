<?php 
require_once __DIR__ . '/class/folder.php';
require_once __DIR__ . '/class/parser.php';

  
  $alert = '';
  $success = '';
  $log = array();
  if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] === 'generate') {

    if (!array_key_exists('dataFile', $_REQUEST) || $_REQUEST['dataFile'] == ''){
      $alert .= 'Select data file<br>';
    }else
    {
      $dataFile = $_REQUEST['dataFile'];
    } 
    if (!array_key_exists('dateList', $_REQUEST) || $_REQUEST['dateList'] == ''){
      $alert .= 'Select list of date<br>';
    }else{
      $dateList = $_REQUEST['dateList'];
    }

    if($dataFile && $dateList){
      
      $success .= "Data file: ". $dataFile.'<br>';
      $success .= "Date list: ". $dateList.'<br>';

      $parser = new Parser($dataFile, $dateList);
      $parser->parseFile();

      $log = $parser->getLog();

    }


  }
  
  $folderData = new Folder();
  $resultData = $folderData->readFolder(DATA_FOLDER);

  $folderTime = new Folder();
  $resultTime = $folderTime->readFolder(DATE_LIST);
?>
    <content>

      <div class="row">
        <div class="large-6 columns">
          <?php if ($alert) {?>
            <span class="[alert secondary] [round radius] label"><?php echo $alert;?></span>
          <?php } 
          if ($success) {?>
            <span class="label"><?php echo $success;?></span>
          <?php } ?>

        </div>
      </div>

      <form action="/parse" method="POST">
        <div class="row">
          <div class="large-6 columns">
            <h3>Database file:</h3>
            <ul class="listFile">
              <?php
              if (count($resultData)>0){
                foreach($resultData as $key => $value){
              ?>
                  <li>
                    <input type="radio" name="dataFile" value="<?php echo $value?>"><?php echo $value?>
                  </li>  
              <?php 
                }
              } else {
              ?>
                <span class="[success alert secondary] [round radius] label">No file uploaded!</span> 
              <?php } ?>
            </ul>
          </div>
          <div class="large-6 columns">
            <h3>Date filter file:</h3>
            <ul class="listFile">
              <?php
              if (count($resultTime)>0){
                foreach($resultTime as $key => $value){
                ?>
                  <li>
                    <input type="radio" name="dateList" value="<?php echo $value?>"><?php echo $value?>
                  </li>  
              <?php 
                }
              } else {
              ?>
                <span class="[success alert secondary] [round radius] label">No file uploaded!</span> 
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="row">
          <div class="large-6 columns">
            
          </div>
          <div class="large-6 columns">
            <?php if (count($resultTime)>0 && count($resultData)>0){ ?>
              <input type="hidden" name="action" value="generate">
              <button type="submit" class="button">Generate data</button>
            <?php }?>
          </div>
        </div>
      </form>

      <div class="row">
        <div class="large-6 columns code">

        <ul class="vcard">
          <h3>Parser Result</h3>
          <?php foreach($log as $value){?>
          <li><?php echo $value?></li>
          <?php }?>
        </ul>
            
        </div>
        <div class="large-6 columns"></div>
      </div>
    </content>
    
  </body>
</html>