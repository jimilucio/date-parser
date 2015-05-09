<?php
	
class UploadFile{

	private $file;
	private $uploadfile;

	public function __construct(array $userfile){

		$this->file = $userfile;

	}

	public function Save($folder){

		$this->uploadfile = $folder . date('Y-m-d-H-i-s-'). basename($this->file['name']);

		if (move_uploaded_file($this->file['tmp_name'], $this->uploadfile)) {
	      return true;
	  	} else {
	      return false;
	  	}

	}


}

?>