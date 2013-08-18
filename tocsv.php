<?php
	$file=file_get_contents("source.dat");
	$mdfile=fopen("README.md","w+");
	fwrite($mdfile, "金沢市のゴミの予定をGoogleカレンダーへ！".PHP_EOL);
	fwrite($mdfile, "ご利用の地域をクリックしてをGoogleカレンダーにインポートしてください".PHP_EOL);

	$row=explode(PHP_EOL, $file);
	foreach ($row as $key => $value) {
		$cell=explode(",", $value);
		if (count($cell)==1){
			if ($fp!==null){
				fwrite($fp, "BEGIN:VCALENDAR");	
				fclose($fp);				
			}
			$fp=fopen("ical/".$value.".ical", "w+");
$ical=<<<eot
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//ono yuuki/Code For Kanazawa//EN
CALSCALE:GREGORIAN
X-WR-CALNAME:$value地区のゴミの日
BEGIN:VTIMEZONE
TZID:Japan
BEGIN:STANDARD
DTSTART:19390101T000000
TZOFFSETFROM:+0900
TZOFFSETTO:+0900
TZNAME:JST
END:STANDARD
END:VTIMEZONE

eot;
fwrite($fp, $ical);

			fwrite($mdfile, "-$value地区".PHP_EOL);
			fwrite($mdfile, "[$value](https://www.google.com/calendar/render?cid=http://raw.github.com/yuki2006/gomi_kanazawa_csv/master/ical/$value.ical)");
			fwrite($mdfile, PHP_EOL.PHP_EOL);
		}else{
			if ($cell[0]=="Subject"){
				continue;
			}

			$tmp=explode("/", $cell[1]);
$date1=sprintf("%04d",$tmp[0]).	sprintf("%02d",$tmp[1]).sprintf("%02d",$tmp[2]);	
$date2=sprintf("%04d",$tmp[0]).	sprintf("%02d",$tmp[1]).sprintf("%02d",$tmp[2]+1);	

$daylabel=$cell[0]."ゴミの日";
$ical=<<<eot
BEGIN:VEVENT
DTSTART;VALUE=DATE:$date1
SUMMARY:$daylabel
DTEND;VALUE=DATE:$date2
END:VEVENT

eot;

			fwrite($fp, $ical);
		}
	}
	fclose($mdfile);

?>
