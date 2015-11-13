<?php
/**
 *  class Folder
 */
class Folder
{

	/**
	 * [$items description]
	 * @var [type]
	 */
	private $items;

	/**
	 * [readFolder description]
	 * @param  [type]
	 * @return [type]
	 */
	public function readFolder($folderPath){


		if ($handle = opendir($folderPath)) {
			
			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if ($entry != '.' && $entry != '..' && $entry!='.DS_Store'){
			  		$this->items[] = $entry;
			  	}
			}

			closedir($handle);
			return $this->items;
	  	}


	}

}
?>