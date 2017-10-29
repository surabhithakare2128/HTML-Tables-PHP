<?php

//include page.php;

class homepage extends page {	
	public function get() {
		$form = '<form action="index.php" method="post" enctype="multipart/form-data">';
		$form .= 'Upload the CSV file <br><br>';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload"> <br>';
		$form .= '<br><input type="submit" value="Submit" name="Submit">';
		$form .= '<input type="reset" value="Cancel">';
		$form .= '</form> ';
		$this->html .= $form;
	}		
	/*public function post(){
		$target_dir = "uploads/";
		print_r($_FILES);
		$fileName = $_FILES[]
		$target_file = $target_dir.$_FILES["fileToUpload"]["name"];	
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);																			    
		if(isset($_POST["Submit"])){
		$file_name = $_FILES["fileToUpload"]["tmp_name"];
		move_uploaded_file($file_name,$target_file);
		echo "Your file has been uploaded.";
		header("Location:http://web.njit.edu/~st638/project1/index.php?page=htmlTable&filename=".$_FILES["fileToUpload"]["name"]);
		
		}
	}*/
	public function post() {
		$fileName = $_FILES["chooseFile"]["name"];
            	$tmpFileName = $_FILES["chooseFile"]["tmp_name"];
		$fileName =  upload::csvUpload($fileName,$tmpFileName);
		header('Location:?page=htmlTable&fileName='. $fileName);
	}
}

?>
