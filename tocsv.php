<?php
	$file=file_get_contents("source.dat");
	$row=explode(PHP_EOL, $file);
	foreach ($row as $key => $value) {
		$cell=explode(",", $value);
		if (count($cell)==1){
			if ($fp!==null){
				fclose($fp);				
			}
			$fp=fopen($value.".csv", "w+");
		}else{
			fwrite($fp, $value);
			fwrite($fp, PHP_EOL);
		}
	}

?>
