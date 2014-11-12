<?php
//session var
date_default_timezone_set('Europe/Rome');
set_time_limit(600);
error_reporting(E_ALL);

//constant
$filename = "EURUSD_5mins";
$filedates = "datelist.csv";
$folderPath = "result";

$timezones = array('Europe/Rome');


$minutes_to_remove = 10;
$minutes_to_add = 2880;

$dateList = getDateList($filedates);

// Make a copy for create the temp file to be crunched.
copy($filename.".csv", "./".$folderPath."/".$filename."_snack.csv");

foreach ($dateList as $value) {
   
   $valueToMod1 = DateTime::createFromFormat('d.m.Y H:i:s', $value->format( 'd.m.Y H:i:s' ));
   $valueToMod2 = DateTime::createFromFormat('d.m.Y H:i:s', $value->format( 'd.m.Y H:i:s' ));
   $startDate = $valueToMod1->sub(new DateInterval('PT'.$minutes_to_remove.'M'));
   $endDate = $valueToMod2->add(new DateInterval('PT'.$minutes_to_add.'M'));

   echo "<br/>Try csv from date: ".$value->format( 'd-m-Y H:i:s' )."<br/>";
   echo "Start date to filter: ". $startDate->format('d-m-Y H:i:s')."<br/>";
   echo "End date to filter: ". $endDate->format('d-m-Y H:i:s')."<br/><br/>";

   $newCsv = getListFromDate($startDate->getTimestamp(), $endDate->getTimestamp(), "./".$folderPath."/".$filename."_snack");

   echo "File creato: <a href='".$folderPath."/".$filename."''>". $folderPath."/".$filename."_snack</a><br><br>";

   //exit();
}

function getListFromDate($startDate, $endDate, $filenameOriginal){
   $filename = $filenameOriginal.".csv";
   $filenameWrite = $filenameOriginal."_".date('d-m-Y-H-i-s', $startDate).".csv";
   $filenameTemp = $filenameOriginal."_temp.csv";

   $handle = fopen($filename,"r");
   echo "Open file: ".$filename."<br/>";
   
   $handleWrite = fopen($filenameWrite,"w");
   echo "Write file: ".$filenameWrite."<br/>";
   
   $handleTemp = fopen($filenameTemp,"w");
   echo "Temp file: ".$filenameTemp."<br/>";
   
   $row = 1;
   
   while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
       
       if ($data[0] != 'Time'){
          $tempData = DateTime::createFromFormat('Y.m.d H:i:s', $data[0]);
          
          $tempDataTimestamp = $tempData->getTimestamp();

          //echo "Start: " . $startDate ." - Date: " . $tempDataTimestamp." End:  ". $endDate."<br/>";
          //exit();
          if($tempDataTimestamp <= $endDate && $tempDataTimestamp >= $startDate){
          	//echo "Start: " . $startDate ." - Date: " . $tempDataTimestamp." End:  ". $endDate."<br/>";
          	$returnObj[] = $data;
            fputcsv($handleWrite, $data);
          } elseif($tempDataTimestamp > $endDate) {
          	
          	while(!feof($handle)) {
          		fwrite($handleTemp, fread($handle, 8192));
          	}
          	copy($filenameTemp, $filename);
          	//ftell($handle);
          	continue;
          }
       }
       $row++;

   }
   echo "Total row: ".$row."\n";
   fclose($handle);
   fclose($handleWrite);
   fclose($handleTemp);

   return $returnObj;

}


function getDateList($filedates){

   //$filename = "datelist.csv";
	$filename = $filedates;
   $handle = fopen($filename,"r");
   echo "Open file: ".$filename."<br/>";
   $row = 0;
   while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
   	
       //create a new data object
       $dateObj = DateTime::createFromFormat('d.m.Y H:i:s', $data[0]);
       $returnObj[] = $dateObj;
       $row++;
   }
   
   echo "Record found: ".$row."<br/>";
   fclose($handle);

   return $returnObj;

}

?>
