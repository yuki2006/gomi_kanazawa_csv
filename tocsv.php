<?php
	$file=file_get_contents("source.dat");
	$mdfile=fopen("README.md","w+");
	fwrite($mdfile, "金沢市のゴミの予定をGoogleカレンダーへ！".PHP_EOL);
	fwrite($mdfile, "ご利用の地域のCSVをGoogleカレンダーにインポートしてください".PHP_EOL);

	$row=explode(PHP_EOL, $file);
	foreach ($row as $key => $value) {
		$cell=explode(",", $value);
		if (count($cell)==1){
			if ($fp!==null){
				fclose($fp);				
			}
			$fp=fopen("csv/".$value.".csv", "w+");
			fwrite($mdfile, "-$value地区".PHP_EOL);
			fwrite($mdfile, "[$value](https://raw.github.com/yuki2006/gomi_kanazawa_csv/master/csv/$value.csv)");
			fwrite($mdfile, PHP_EOL.PHP_EOL);
		}else{
			fwrite($fp, $value);
			fwrite($fp, PHP_EOL);
		}
	}
	fclose($mdfile);

?>
