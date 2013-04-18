<?php

require_once('settings.php');
require_once('database.php');

$data = $query->select('osb')->where('nick="'.mysql_real_escape_string($_GET['nick']).'"')->nextAssoc();
$buzzes = ($data['p'] + $data['i'] + $data['m'] + $data['n']);
?>
<div>
Name: <?=$data['name']?><br />
Trepang Score: <?=($data['p'] * 2 + $data['i'] * 3 + $data['m'] * -1 + $data['n'] * -2) ?><br />
Buzzes: <?=$buzzes?><br />
- # Correct: <?=$data['p']?> (<?= round($data['p']/($buzzes == 0 ? 1 : $buzzes)*100)?>%)<br />
- # Interrupts: <?=$data['i']?> (<?= round($data['i']/($buzzes == 0 ? 1 : $buzzes)*100)?>%)<br />
- # Incorrect: <?=$data['m']?> (<?= round($data['m']/($buzzes == 0 ? 1 : $buzzes)*100)?>%)<br />
- # Negs: <?=$data['n']?> (<?= round($data['n']/($buzzes == 0 ? 1 : $buzzes)*100)?>%)<br />
Breakdown by Subject (Correct/Attempted)<br />
- Biology: <?=$data['biol_c']?>/<?=$data['biol_a']?><br />
- Chemistry: <?=$data['chem_c']?>/<?=$data['chem_a']?><br />
- Geography: <?=$data['geog_c']?>/<?=$data['geog_a']?><br />
- Geology: <?=$data['geol_c']?>/<?=$data['geol_a']?><br />
- Marine Policy: <?=$data['mpol_c']?>/<?=$data['mpol_a']?><br />
- Physics: <?=$data['phys_c']?>/<?=$data['phys_a']?><br />
- Social Sciences: <?=$data['ssci_c']?>/<?=$data['ssci_a']?><br />
- Technology: <?=$data['tech_c']?>/<?=$data['tech_a']?><br /><br />
<input type="button" value="Remove <?=$data['name']?>" onclick="removePlayer('<?=$data['nick']?>')" />
</div>
<div id="charts">Buzzes by Result:<br />
<img src="http://chart.apis.google.com/chart?chs=300x150&amp;chd=t:<?=$data['p']?>,<?=$data['i']?>,<?=$data['m']?>,<?=$data['n']?>&amp;cht=p&amp;chl=Correct|Interrupts|Incorrect|Negs&amp;chco=76A4FB" /><br />
Buzzing %s by Subject:<br />
<img src="http://chart.apis.google.com/chart?chs=300x150&amp;chd=t:
<?= round($data['biol_c']/($data['biol_a']==0 ? 1 : $data['biol_a'])*100);?>,
<?= round($data['chem_c']/($data['chem_a']==0 ? 1 : $data['chem_a'])*100);?>,
<?= round($data['curr_c']/($data['curr_a']==0 ? 1 : $data['curr_a'])*100);?>,
<?= round($data['geog_c']/($data['geog_a']==0 ? 1 : $data['geog_a'])*100);?>,
<?= round($data['geol_c']/($data['geol_a']==0 ? 1 : $data['geol_a'])*100);?>,
<?= round($data['mpol_c']/($data['mpol_a']==0 ? 1 : $data['mpol_a'])*100);?>,
<?= round($data['phys_c']/($data['phys_a']==0 ? 1 : $data['phys_a'])*100);?>,
<?= round($data['ssci_c']/($data['ssci_a']==0 ? 1 : $data['ssci_a'])*100);?>,
<?= round($data['tech_c']/($data['tech_a']==0 ? 1 : $data['tech_a'])*100);?>
&amp;cht=bvs&amp;chl=B|Ch|Cu|Gg|Gl|M|P|S|T|1:20|40|60|80|100&amp;chco=76A4FB&amp;chxt=x,y" />
</div>
