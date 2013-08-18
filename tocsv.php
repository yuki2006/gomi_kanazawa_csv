<?php
	$file=file_get_contents("source.dat");
	$mdfile=fopen("README.md","w+");
	$row=explode(PHP_EOL, $file);
	foreach ($row as $key => $value) {
		$cell=explode(",", $value);
		if (count($cell)==1){
			if ($fp!==null){
				fclose($fp);				
			}
			$fp=fopen("csv/".$value.".csv", "w+");
			fwrite($mdfile, "-$value".PHP_EOL);
			fwrite($mdfile, "[$value](https://github.com/yuki2006/gomi_kanazawa_csv/blob/master/%E9%9E%8D%E6%9C%88.csv)");
			fwrite($mdfile, PHP_EOL);
		}else{
			fwrite($fp, $value);
			fwrite($fp, PHP_EOL);
		}
	}
	fclose($mdfile);

?>
