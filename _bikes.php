<?php
require("lib/_init.php");
if(Rights::hasRight('pedelecs')):

require(LIVECTRLW."Bikes.class.php");

if($_POST['do'] == 'changeBike') {
	Report::bike(Bike::load($_POST['bike']), $_POST['battery'], $_POST['status']);
	header("location: ./_bikes.php");
}
?>
<h1>Pedelec Übersicht</h1>


<!-- Bike overview -->
<div class="container">
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Nummer</th>
				<th>Typ</th>
				<th>Station</th>
				<th>Restreichweite</th>
				<th>Zustand (1-5)</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach(Bikes::all() as $bike): ?>
		<form action="./_bikes.php" method="post">
		<tr>
			<td><?=$bike->getId()?></td>
			<td><?=$bike->getType()?></td>
			<td><?php if($bike->getStation() !== null): ?>
			<select name="bike" <?=($bike->getStatus()==0?'':'disabled')?>>
			<?=(Bikes::options($bike->getStation()))?>
			</select>
			<?php else: ?>entliehen<?php endif; ?>
			</td>
			<td><input class="span2" type="text" name="battery" value="<?=$bike->getBattery()?>" />km</td>
			<td><select name="status"><?php for($i = 5; $i >= 0; $i--): ?>
			<option value="<?=$i?>" <?=($bike->getStatus()==$i?"selected":"")?>
			/><?=Bike::statusToString($i)?></option>
			<?php endfor; ?></select></td>
			<td class="span2">
				<a href="_bikes.php?bid=<?=$bike->getId()?>" class="btn btn-primary btn-small">Protokoll</a>
			<input type="submit" 
				onclick="return confirm('Speichern?')" 
				class="btn btn-small" value="Speichern">
			</td>
		</tr>
		<input type="hidden" name="do" value="changeBike" />
		<input type="hidden" name="bike" value="<?=$bike->getId()?>" />
		</form>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php 
if(!empty($_GET['bid'])): 
?>
<h3>Protokoll für Pedelec Nummer <?=intval($_GET['bid'])?></h3>
<div class="container">
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Zeitpunkt</th>
				<th>Typ</th>
				<th>Mitarbeiter</th>
				<th>Kunde</th>
				<th>Restreichweite</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach(Report::getBikeReports($_GET['bid']) as $report): ?>
		<tr>
			<td><?=date("H:i d.m.Y",strtotime($report->getTime()))?></td>
			<td><?=Report::subToString($report->getSubject())?></td>
			<td><?=($report->getService()?$report->getService()->getHtml(): '-')?></td>
			<td><?=($report->getUser()?$report->getUser()->getHtml(): '-')?></td>
			<td><?=($report->getBattery() > 0?$report->getBattery()."km": '-')?></td>
			<td><?=($report->getStatus()?Bike::statusToString($report->getStatus()): '-')?></td>
			<td><a href="#" class="btn <?=($report->getCom()?'btn-primary':'')?>" data-toggle="popover" data-placement="left" title="Kommentar/Beschreibung"
			data-content="<?=($report->getCom()?htmlspecialchars($report->getCom()): '-')?>">Kommentar</a></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php endif; ?>

<?php
else: echo "Keine Berechtigung"; endif;
?>