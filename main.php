<?php
$videoid=$argv[1];
if($argv[1]){
$log=array();
file_put_contents("./log".date("Y-m-d").".txt","==new==".date("Y/m/d H:i:s")."\n".$videoid."\n",FILE_APPEND);
echo "\n".$videoid."\n";
echo "php download.php ".$videoid."\n";
exec("php download.php ".$videoid,$log);
if(!is_array($log)){
	echo $videoid." is missed.(--)\n";
	file_put_contents("./log".date("Y-m-d").".txt","missed!!(--)\n",FILE_APPEND);
}elseif(!$log[0]){
	echo $videoid." is missed(empty)\n";
	//exec("rm ./tmp/".$videoid);
	file_put_contents("./miss.txt",$videoid."\n",FILE_APPEND );
	file_put_contents("./log".date("Y-m-d").".txt","missed!!(empty)\n",FILE_APPEND);
}elseif(preg_match("/403 Forbidden/",$log[0])){
	echo $videoid." is missed(403).\n";
	file_put_contents("./log".date("Y-m-d").".txt","missed!!(403)\n",FILE_APPEND);
}elseif(preg_match("/xml version=/",$log[0])){
	echo $videoid." is missed.(500e)\n";
	file_put_contents("./log".date("Y-m-d").".txt","missed!!(500e)\n",FILE_APPEND);
}elseif($log[0]){
	echo"php encode.php ".$videoid."\n";
exec("php encode.php ".$videoid." >>log".date("Y-m-d").".txt");
}
}
?>
