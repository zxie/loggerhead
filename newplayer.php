<?php
require_once('settings.php');
require_once('database.php');

$fields['nick'] = "'".mysql_real_escape_string($_GET['nick'])."'";
$fields['name'] = "'".mysql_real_escape_string($_GET['name'])."'";
$query->insert("osb",$fields)->result();

?>

