<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

class Manage {
	public static function autoload($class) {
		include $class . '.php';
	}
}

spl_autoload_register(array('Manage', 'autoload'));
	
$obj = new main();

class main {
	public function __construct(){
		$pageRequest = 'homepage';
		if(isset($_REQUEST['page'])) {
			$pageRequest = $_REQUEST['page'];
		}
		$page = new $pageRequest;
	  	if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$page->get();
		} 
		else {
		        $page->post();
		}
	}
}

abstract class page {	
	protected $html;	
	public function __construct() {									         
		$this->html .= '<html>';
		$this->html .= '<link rel="stylesheet" href="styles.css">';
		$this->html .= '<body>';
	}        
	public function __destruct() {
		$this->html .= '</body></html>';
		stringFunctions::printThis($this->html);
        }
        public function get() {
		echo 'default get message';
	}	
	public function post() {
		print_r($_POST);
	}
}

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
	public function post(){
		$target_dir = "uploads/";
		//print_r($_FILES);
		$target_file = $target_dir . $_FILES["fileToUpload"]["name"];	
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
		if(isset($_POST["Submit"])) {
			$file_name = $_FILES["fileToUpload"]["tmp_name"];
			move_uploaded_file($file_name,$target_file);
			echo "Your file has been uploaded.";
			header("Location:http://web.njit.edu/~st638/project1/index.php?page=htmlTable&filename=".$_FILES["fileToUpload"]["name"]);
		}
	}
}

class uploadform extends page {
	public function get() {
     		$form = '<form action="index.php?page=uploadform" method="post" enctype="multipart/form-data">';
	        $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Submit">';
		$form .= '</form> ';
		$this->html .= '<h1>Upload Form</h1>';
		$this->html .= $form;																						    }
	public function post() {
		echo 'test';
		print_r($_FILES);
	}	
}

class stringFunctions{
	static public function printThis($text){
		print($text);
	}
}

class htmlTable extends page {
	public function get(){
		$csvFile=$_REQUEST["filename"];
			//echo $csvFile;
		$row = 1;
		if (($handle = fopen("uploads/".$csvFile, "r")) !== FALSE) {
    			echo '<table border="1">';
	    		while (($data = fgetcsv($handle)) !== FALSE) {
		       		$num = count($data);
		        	if ($row == 1) {
			        	echo '<thead><tr>';
				}
				else{
				        echo '<tr>';
				}
				for ($c=0; $c < $num; $c++) {
					if(!isset($data[$c])) {
						$value = "&nbsp;";
					}
					else{
					        $value = $data[$c];
					}
					if ($row == 1) {
					        echo '<th>'.$value.'</th>';
					}
					else{
					        echo '<td>'.$value.'</td>';
					}
				}
				if($row==1){
					echo '</tr></thead><tbody>';
				}
				else{
					echo '</tr>';
				}
				$row++;
			}
			echo '</tbody></table>';
			fclose($handle);
		}
	}
}
?>
