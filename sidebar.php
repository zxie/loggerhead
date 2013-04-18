
<a href="javascript: playerComparison()" style="display: block;">Player Comparison</a>
<br />
<b>? Category: </b><select id="select">
<option value="biol">Biology</option>
<option value="chem">Chemistry</option>
<option value="curr">Current Events</option>
<option value="geog">Geography</option>
<option value="geol">Geology</option>
<option value="mpol">Marine Policy</option>
<option value="phys">Physics</option>
<option value="ssci">Social Sciences</option>
<option value="tech">Technology</option></select>
<br />
<br />
<?php
require_once('settings.php');
require_once('database.php');

$sql = $query->select('osb','nick')->result();

while($row = mysql_fetch_assoc($sql)){
?>

<div class="player"><?= $row['nick'] ?>
<input value="i" onclick="updateLog('<?= $row['nick'] ?>', document.getElementById('select').value, 'i')" type="button"><input value="n" onclick="updateLog('<?= $row['nick'] ?>', document.getElementById('select').value, 'n')" type="button"><input value="+" onclick="updateLog('<?= $row['nick'] ?>', document.getElementById('select').value, 'p')" type="button"><input value="-" onclick="updateLog('<?= $row['nick'] ?>', document.getElementById('select').value, 'm')" type="button"><input style="font-size:7pt; padding: 2px 0;" value="STATS" onclick="displayPlayerStats('<?= $row['nick'] ?>')" type="button">
</div>

<?php } ?>
<br />
<input type="button" onclick="loadPlayers();" value="Refresh Player List" />
<input type="button" onclick="lastFunction();" value="Refresh Display" />
<?php ?>