<?php
require_once('settings.php');
require_once('database.php');

$nick = "'".mysql_real_escape_string($_GET['nick'])."'";
$query->delete("osb")->where("nick=".$nick)->result();

?>