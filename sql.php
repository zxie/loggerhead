<?php

if(!$_GET['custom'])
	$_GET['keys'] = array(
		"nick","name","p","m","i","n",
		"biol_c","biol_a",
		"chem_c","chem_a",
		"curr_c","curr_a",
		"geog_c","geog_a",
		"geol_c","geol_a",
		"mpol_c","mpol_a",
		"phys_c","phys_a",
		"ssci_c","ssci_a",
		"tech_c","tech_a"
	);
	
require_once('settings.php');
require_once('database.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Player Comparisons</title>

<link rel="stylesheet" type="text/css" href="loggerhead.css" />
<script src="sorttable.js"></script>
</head>
<body>

<form method="get" action="sql.php">
<fieldset>
<legend>Columns:</legend>
<?php
$sql = mysql_query("SELECT * FROM osb");

$keys = array_keys($row = mysql_fetch_assoc($sql));
foreach($keys as $key){
	$k = $settings['shorthand'][substr($key,0,4)];
	if(substr($key,4)=="_a" || substr($key,4)=="_c") $k.=substr($key,5);
	$check = isset($_GET['keys']) && in_array($key, $_GET['keys']) ? 'checked="checked"' : '';
	echo '<input type="checkbox" name="keys[]" ' . $check . ' value="' . $key . '">'.$k;
	
	if($key=='n') echo '<br />';
}
?>
</fieldset>
<fieldset>
<legend>Players:</legend>
<?php
do{
	$check = (!$_GET['custom'] || ($_GET['nicks'] && in_array($row['nick'], $_GET['nicks']))) ? 'checked="checked"' : '';
	echo '<input type="checkbox" name="nicks[]" ' . $check . ' value="' . $row['nick'] . '">'.$row['nick'];
}while($row = mysql_fetch_assoc($sql));
?>
</fieldset>
<input type="hidden" name="custom" value="true"/>
<input type="submit" value="GO" /><br /><br />
</form>

<table id="comparisonTable" onload="sorttable.init()" class="sortable">
<thead><tr>
<?php 
if(!$_GET['custom'] || $_GET['keys'])
	foreach($_GET['keys'] as $key){
		$k = $settings['shorthand'][substr($key,0,4)];
		if(substr($key,4)=="_a" || substr($key,4)=="_c") $k.=substr($key,5);
		echo '<th class="sorttable">' . $k . "</th>\n";
	}
?>
<th class="sorttable">TreS</th></tr></thead>
<tbody>
<?php
if(!$_GET['custom'] || ($_GET['nicks'] && $_GET['keys'])){ //skip entirely

	$sql = "SELECT " . mysql_real_escape_string(implode(",", $_GET['keys'])) . " FROM osb ";
	if($_GET['custom']){
		for($i=0; $i<count($_GET['nicks']); $i++) 
			$_GET['nicks'][$i] = mysql_real_escape_string($_GET['nicks'][$i]);
			
		$sql .= "WHERE nick='" . implode("' OR nick='", $_GET['nicks']) . "'";
	}
	$sql = mysql_query($sql);

	while($row = mysql_fetch_assoc($sql)){
		echo "<tr>";
		foreach($row as $col) 
			echo '<td>'.$col.'</td>';
		echo '<td>'.($row['p'] * 2 + $row['i'] * 3 + $row['m'] * -1 + $row['n'] * -2).'</td>';
		echo "</tr>";
	} 
}
?>
</tbody></table>

</body></html>