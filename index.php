<?php

$timezones = array('Europe/Rome');
date_default_timezone_set('Europe/Rome');
set_time_limit(600);

$minutes_to_remove = 10;
$minutes_to_add = 5000;

$dateList = getDateList();

foreach ($dateList as $value) {
   
   $startDate = $value->sub(new DateInterval('PT'.$minutes_to_remove.'M'));
   $endDate = $value->add(new DateInterval('PT'.$minutes_to_add.'M'));

   echo "\nTry csv from date: ".$value->format( 'd-m-Y H:i:s' )."\n";
   echo "Start date to filter: ". $startDate->format('d-m-Y H:i:s')."\n";
   echo "End date to filter: ". $endDate->format('d-m-Y H:i:s')."\n\n";

   $newCsv = getListFromDate($startDate->getTimestamp(), $endDate->getTimestamp());

   print_r($newCsv);
   exit();
}

function getListFromDate($startDate, $endDate){

   $filename = "EURUSD_UTC_5-Mins_Bid_2006.12.31_2014.11.04.csv";

   $handle = fopen($filename,"r");
   echo "Open file: ".$filename."\n";

   $row = 1;
   while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
       
       
       if ($data[0] != 'Time'){

          $tempData = DateTime::createFromFormat('Y.m.d H:i:s', $data[0]);
          $tempDataTimestamp = $tempData->getTimestamp();

          echo "Start: " . $startDate ." - Date: " . $tempDataTimestamp." End:  ". $endDate."\n";
          exit();
          if ( $tempDataTimestamp >= $endDate && $tempDataTimestamp <= $endDate ){
            $returnObj[] = $data;
          }elseif($tempDataTimestamp > $endDate){
            continue;
          }
         
       }
       $row++;

   }
   echo "Total row: ".$row."\n";
   fclose($handle);

   return $returnObj;

}


function getDateList(){

   $filename = "datelist.csv";
   $handle = fopen($filename,"r");
   echo "Open file: ".$filename."\n";
   $row = 1;
   while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
       
       //create a new data object
       $dateObj = DateTime::createFromFormat('d.m.Y H:i:s', $data[0]);
       $returnObj[] = $dateObj;
       $row++;

   }
   echo "Record found: ".$row."\n";

   fclose($handle);

   return $returnObj;

}

?>