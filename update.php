
<?php

require_once('settings.php');
require_once('database.php');

$id = mysql_real_escape_string($_GET['nick']);
$btype = mysql_real_escape_string($_GET['btype']);
$qtype = mysql_real_escape_string($_GET['qtype']);

if($btype=='p'){
	echo $query->increment("osb",$btype,1)->where("nick=\"".$id."\"")->result();
	echo $query->increment("osb",$qtype."_c",1)->where("nick=\"".$id."\"")->result();
	echo $query->increment("osb",$qtype."_a",1)->where("nick=\"".$id."\"")->result();
}else if($btype=='m'){
	echo $query->increment("osb",$btype,1)->where("nick=\"".$id."\"")->result();
	echo $query->increment("osb",$qtype."_a",1)->where("nick=\"".$id."\"")->result();
}else if($btype=='i'){
	echo $query->increment("osb",$btype,1)->where("nick=\"".$id."\"")->result();
	echo $query->increment("osb",$qtype."_c",1)->where("nick=\"".$id."\"")->result();
	echo $query->increment("osb",$qtype."_a",1)->where("nick=\"".$id."\"")->result();
}else if($btype=='n'){
	echo $query->increment("osb",$btype,1)->where("nick=\"".$id."\"")->result();
	echo $query->increment("osb",$qtype."_a",1)->where("nick=\"".$id."\"")->result();
}

?>