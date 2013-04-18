<?php

require_once('settings.php');
require_once('database.php');

$sql = $query->select('osb')->result();

while($row = mysql_fetch_assoc($sql)){
?>
<tr>
<?php
	foreach($row as $col) {
		echo '<td>'.$col.'</td>';
		if($row['name']==$col){
			$buzzes = $row['p']+$row['i']+$row['m']+$row['n'];
			echo "<td>$buzzes</td>";
		}
	}
	
	echo '<td>'.($row['p'] * 2 + $row['i'] * 3 + $row['m'] * -1 + $row['n'] * -2).'</td>';
?>
</tr>
<?php } ?>