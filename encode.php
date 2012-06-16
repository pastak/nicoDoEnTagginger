<?php

function getArtistName($title){
	$artist="VOCALOID";	
	$i=0;
	$inclideArtist=array();
	$VOCALOID_NAME=array("初音ミク" => "Hatsune Miku(初音ミク)",
						 "鏡音リン" => "Kagamine Rin(鏡音リン)",
						 "鏡音レン" => "Kagamine Ren(鏡音レン)",
						 "巡音ルカ" => "Megurine Ruka(巡音ルカ)",
						 "KAITO" => "Kaito",
						 "MEIKO" => "Meiko",
						 "重音テト" => "Kasane Teto(重音テト)",
						 "GUMI" => "Gumi",
						 "神威がくぽ" => "Kamui Gakupo(神威がくぽ)",
						 "VY1" => "VY1",
						 "歌愛ユキ" => "Kaai Yuki(歌愛ユキ)",
						 "miki" => "miki",
						 "Megpoid" => "GUMI",
						 "めぐっぽいど" => "GUMI",
						 "がくぽ" => "Kamui Gakupo(神威がくぽ)",
						 "がくっぽいど" => "Kamui Gakupo(神威がくぽ)",
						 "megpoid" => "GUMI"
						 );
	foreach($VOCALOID_NAME as $key => $val){
		if(stristr($title,$key)){
			$inclideArtist[$i++]=$val;
		}
	}
	if($i>0){$artist=join(", ",$inclideArtist);}
	return $artist;
}

$videoid=$argv[1];
$VideoDir=""; //download.phpでvideoを保存したディレクトリ
$xml=simplexml_load_file("http://ext.nicovideo.jp/api/getthumbinfo/".$videoid);
//print_r($xml);
$title=$xml->thumb->title;
echo "\n".$title."\n";
exec("notify-send -t 180 encoding ".$title);
exec("ffmpeg -i ".$VideoDir.$videoid." -ab 128 -ar 44100 -metadata album_artist='NicoNico Creaters'  ".$videoid.".mp3"); //metadataオプションはeyeD3でアルバムアーティストをつけられなかったので使用しています。

$artistName=getArtistName($title);
$filetype="mp3";
$filename=$videoid.".".$filetype;
exec("eyeD3 --no-color --set-encoding=utf16-LE -a '".$artistName."' -A VOCALOIDs -G VOCALOID -t '".$title."' ".$filename." >>log".date("Y-m-d").".txt"); //各種オプションはお好みに応じてどうぞ
exec("notify-send -t 30 finish ".$title."/".$filename);
?>
