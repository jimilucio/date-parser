<?php
if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] === 'upload') {

  $file2Upload = $_FILES['parseFile'];

  if ($file2Upload['size'] == 0){
    print "Inserire un file valido";
    return;
  }

  $uploaddir = './uploads/';
  $uploadfile = $uploaddir . date('Y-m-d-h-i-s-'). basename($file2Upload['name']);
  
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