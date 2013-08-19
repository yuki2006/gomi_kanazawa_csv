<?php
	$template=file_get_contents("template.html");
	$file=file_get_contents("source.dat");

$inData="<table style='border : 1px' ><tbody>";

	$mdfile=fopen("index.html","w+");

	$row=explode(PHP_EOL, $file);
	foreach ($row as $key => $value) {
		$cell=explode(",", $value);
		if (count($cell)==1){
			if ($fp!==null){
				fwrite($fp, "END:VCALENDAR");	
				fclose($fp);				
			}
			$fp=fopen("ics/".$value.".ics", "w+");
$ical=<<<eot
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//ono yuuki/Code For Kanazawa//EN
CALSCALE:GREGORIAN
X-WR-CALNAME:{$value}地区のゴミの日
X-WR-CALDESC:石川県金沢市の{$value}地区に関する、ゴミの日のカレンダーです。
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

$inData.=<<<eot
<tr>
<th>
<span style="font-size:1.2em">{$value}地区</span></th>
<td><a href='https://www.google.com/calendar/render?cid=http://raw.github.com/yuki2006/gomi_kanazawa_csv/master/ics/$value.ics'>Googleカレンダーへ追加</a>
</td>
<td>
 <a href='webcal://raw.github.com/yuki2006/gomi_kanazawa_csv/master/ics/$value.ics'>
 iCalファイル</a>
</td>
</tr>
eot;
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
	$inData.="</tbody></table>";
	$template=str_replace("%DATA%" ,$inData, $template);

	file_put_contents("index.html", $template);


?>
