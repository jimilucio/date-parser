<?php 

class Parser{
		
	private $dataFile;
	private $dateList;
	private $timezones;
	private $minutes2remove;
	private $minutes2add;
	private $contents;
	
	private $logInfo;
	private $logData;

	//define the name of new directory
	private $directory;

	/**
	* Constructor of class Parser
	* @params: $dataFile string [is the zip file with all data inside]
	* @params: $dateList string [is the csv file with filter data]
	*/
	public function __construct($dataFile, $dateList){

		$this->dataFile = $dataFile;
		$this->dateList = $dateList;
		$this->directory = RESULTS.date('Y.m.d.H.i');
		$this->minutes2remove = 10;
		$this->minutes2add = 2880;
		$this->timezones = array('Europe/Rome');
		$this->logInfo = array();
		$this->logData = array();
		$this->contents = array();

	}

	private function parserLog($info, $type = 'info'){
		if ($type == 'data'){
			array_push($this->logData, $info);
		} else { 
			array_push($this->logInfo, $info);
		}
	}

	/**
	* 
	*/
	private function getDateList(){

		$filename = DATE_LIST.$this->dateList;
		$handle = fopen($filename,"r");
		$this->parserLog("Open file: ".$filename."\n");
		$row = 0;
		while (($data = fgetcsv($handle, 20, "\n")) !== FALSE) {

		   //create a new data object
		   //print_r($data);
		   $dateObj = DateTime::createFromFormat('d.m.Y H:i:s', $data[0]);
		   $returnObj[] = $dateObj;
		   $row++;
		}

		$this->parserLog("Record found: ".$row."\n");
		fclose($handle);

		return $returnObj;

	}

	private function generateListFromDate($startDate, $endDate, $index){

	    //create directory if not exists
	   	if (!file_exists($this->directory)) {
		    mkdir($this->directory, 0777, true);
		}

		//define file name of new csv trunk
	   	$fileName = str_pad($index, 3, "0", STR_PAD_LEFT);
	   	$filenameWrite = $this->directory."/".$fileName.".csv";

	   	//open new file with name defined (es 001.csv)
	   	$handleWrite = fopen($filenameWrite,"w");
   		$this->parserLog("Write file: ".$filenameWrite."\n");
	   	
	   	//contents are saved with index Y.m (es: 2007.01)
	   	//define index for filter csv information
	   	$filterStartDate = new DateTime('@'.$startDate);
	   	$filterEndDate = new DateTime('@'.$endDate);

	   	$this->parserLog("FilterStartDate: ".$filterStartDate->format('Y.m')."\n");
	   	$this->parserLog("FilterEndDate: ".$filterEndDate->format('Y.m')."\n");

	   	//define data index
	   	$dataIndex = $filterStartDate->format('Y.m');


	   	if(array_key_exists($dataIndex, $this->contents)){


		   	$startData = str_getcsv($this->contents[$dataIndex], "\n");

		   	
		   	$rowCreated = 0;
		   	foreach ($startData as $row) {

	   			$rowData = 	str_getcsv($row, ',');

	   			if ($rowData[0] != 'Time'){
		          
		          $tempData = DateTime::createFromFormat('Y.m.d H:i:s', $rowData[0]);

		          $tempDataTimestamp = $tempData->getTimestamp();

		          //echo "Start: " . $startDate ." - Date: " . $tempDataTimestamp." End:  ". $endDate."<br/>";
		          
		          if($tempDataTimestamp <= $endDate && $tempDataTimestamp >= $startDate){
		          	//echo "Start: " . $startDate ." - Date: " . $tempDataTimestamp." End:  ". $endDate."<br/> Save value: ". $value."<br><br>";
		          	fputcsv($handleWrite, $rowData);
		            $rowCreated++;
		          } 

		        }

		   	}
		   	
		   	$this->parserLog("Total row: ".$rowCreated."\n");
		    
		    fclose($handleWrite);
		    
		    //$this->parserLog("File creato: <a href='./".$filenameWrite."'>". $filenameWrite."</a>", 'data');
		} else {

			$this->parserLog("Indice non trovato: ". $dataIndex);

		}
	}

	private function createZip(){

		// Get real path for our folder
		$rootPath = realpath($this->directory);

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($this->directory.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();
		$this->parserLog("File creato: <a href='./".$this->directory.".zip'>".$this->directory.".zip</a>", 'data');

	}

	private function unzip($dataFile){

		$zip = new ZipArchive;
		if ($zip->open($dataFile)) {
			
			$info = $zip->statIndex(0);

			$this->parserLog('Filename founded: '. $info['name']);
			$fp = $zip->getStream($info['name']);

			
			while (!feof($fp)) {
		        
		        //get new value
		        $data2Append = fgets($fp);

		        $index = substr($data2Append, 0, 7);
		        
		        //initialize the string
		        if (!array_key_exists($index, $this->contents)){
		        	$this->contents[$index] = '';
		        }

		        $this->contents[$index] .= fgets($fp);
		        
		    }

	        fclose($fp);
	        $zip->close();

		}

	}

	public function parseFile(){

		$timezones = $this->timezones;

		$this->parserLog('Set timezones in ' . print_r($timezones, true));
		$minutes_to_remove = $this->minutes2remove;
		$minutes_to_add = $this->minutes2add;

		$dateList = $this->getDateList();

		//Unzip file from source
		$this->parserLog('Unzip file: '. $this->dataFile);
		$this->unzip(DATA_FOLDER.$this->dataFile);
		
		$index = 0;
		foreach ($dateList as $value) {

		   $valueToMod1 = DateTime::createFromFormat('d.m.Y H:i:s', $value->format( 'd.m.Y H:i:s' ));
		   $valueToMod2 = DateTime::createFromFormat('d.m.Y H:i:s', $value->format( 'd.m.Y H:i:s' ));
		   $startDate = $valueToMod1->sub(new DateInterval('PT'.$minutes_to_remove.'M'));
		   $endDate = $valueToMod2->add(new DateInterval('PT'.$minutes_to_add.'M'));

		   $this->parserLog("Try csv from date: ".$value->format( 'd-m-Y H:i:s' ));
		   $this->parserLog("Start date to filter: ". $startDate->format('d-m-Y H:i:s'));
		   $this->parserLog("End date to filter: ". $endDate->format('d-m-Y H:i:s'));
		   $index++;
		   $this->generateListFromDate($startDate->getTimestamp(), $endDate->getTimestamp(), $index);

		}

		$this->createZip();

	}

	public function getLog($type='data'){
		if ($type == 'info'){
			return $this->logInfo;	
		}else{
			return $this->logData;	
		}
		
	}

}