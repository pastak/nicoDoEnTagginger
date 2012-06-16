<?php
	exec("cp miss.txt ./misslog/missTmp_".date("Y-m-d-H-i"));
	$t=file_get_contents("miss.txt");
	while($t){
	exec("rm miss.txt");
	$list=split("\n",$t);
	foreach($list as $id){
		if(!$id){continue;}
		echo "php main.php ".$id."\n";
		echo exec("php main.php ".$id);
		echo "\n\n";
		sleep(10);
	}
	$t=file_get_contents("miss.txt");
	file_put_contents("./log".date("Y-m-d").".txt","=======miss.txt==".date("Y/m/d H:i:s")."\n".$t."\n===============\n",FILE_APPEND);
	}
	//print_r($list);
?>
