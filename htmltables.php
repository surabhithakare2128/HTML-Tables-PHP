<?php

class htmlTables extends page{
	public function get(){
		$fileName = $_GET['fileName'];
		echo trim($fileName, "uploads/") . "was uploaded <br> The table
		is listed below, <br>";
		$heading = 1;
		$handle = fopen($fileName,"r");
		$table = '<table border="1">';
		while(($data = fgetcsv($handle))!=FALSE){
			if($heading == 1){
				$table .= '<thead><tr>';
				foreach($data as $value){
					if(!isset($value))
						$value = "&nbsp";
					else
						$table .= "<th>" . $value .
						"</th>";
				}
				$table .= '</tr></thead><tbody>';
			}
			else{
				$table .= '<tr>';
				foreach($data as $value){
					if(!isset($value))
						$value = "nbsp";
					else
						$table .= "<td>" . $value .
						"</td>";
				}
				$table .= '</tr>';
			}
			$heading++;
		}
		$table .= '</tbody></table>';
		$this->html .= $table;
		fclose($handle);
	}

} 

?>
