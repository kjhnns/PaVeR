<?php
require("lib/_init.php");
if(Rights::hasRight("calendar")):

if($_POST['do'] == 'addOpen') {
	Calendar::saveOpen($_POST['stime'], $_POST['etime'],
	$_POST['date'], $_POST['enddate'],
	$_POST['period'], $_POST['duration'], $_POST['station']);
	?>
	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Erfolg!</strong> Öffnungszeitraum erfolgreich hinzugefügt.
</div>
	<?php
}
if($_POST['do'] == 'addClosed') {
	if(Calendar::saveClosed($_POST['start'],
	$_POST['end'],
	$_POST['title'], $_POST['station'])):
	?>
	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Erfolg!</strong> Ausnahmenzeitraum erfolgreich hinzugefügt.
</div>
	<?php
	else:
	?>
	<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Warnung!</strong> Ausnahmenzeitraum konnte nicht hinzugefügt werden, da im gewünschten Zeitraum bereits Anfragen vorhanden sind.
</div>
	<?php
	endif;
}
if($_GET['do'] == 'delOpen') {
	if(Calendar::delOpen($_GET['id'])):
	?>
	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Erfolg!</strong> Öffnungszeitraum erfolgreich gelöscht.
</div>
	<?php
	else:
	?>
	<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Warnung!</strong> Öffnungszeitraum konnte nicht gelöscht werden, da im gewünschten Zeitraum bereits Anfragen vorhanden sind.
</div>
	<?php
	endif;
}
if($_GET['do'] == 'delClose') {
	Calendar::delClose($_GET['id']);
	header("location: _calEdit.php");
}

?>
<h1>Öffnungszeiten bearbeiten</h1>

<div class="tabbable tabs-top">
<ul class="nav nav-tabs">
<li class="active"><a href="#co" data-toggle="tab">Öffnungszeitraum hinzufügen</a></li>
<li><a href="#o" data-toggle="tab">Öffnungszeiträume</a></li>
<li><a href="#ca" data-toggle="tab">Ausnahmezeitraum hinzufügen</a></li>
<li><a href="#a" data-toggle="tab">Ausnahmezeiträume</a></li>
</ul>
</div>

<div class="tab-content">

<div class="tab-pane active" id="co">
	<div class="well well-small">
	<form action="_calEdit.php" method="post" >
	<input type="hidden" name="do" value="addOpen" />
	<div class="row-fluid">
		<h3>Öffnungszeitraum hinzufügen</h3>
	</div>
	<div class="row-fluid">
		<div class="span3">
			<h4>von</h4>
			<div id="picker1" class="input-append">
			    <input class="span10" data-format="hh:mm" value="<?=date("H:i")?>" type="text"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			    <input type="hidden" id="picker1Container" name="stime" value="<?=date("H:i")?>"/>
			</div>
		</div>
		<div class="span3">
			<h4>bis</h4>
			<div id="picker4" class="input-append">
			    <input class="span10" data-format="hh:mm" value="<?=date("H:i")?>" type="text"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			    <input type="hidden" id="picker4Container" name="etime" value="<?=date("H:i")?>"/>
			</div>
		</div>
		<div class="span3">
			<h4>am</h4>
			<div id="picker3" class="input-append">
			    <input class="span10" data-format="dd.MM.yyyy" value="<?=date("d.m.Y")?>" type="text"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			    <input type="hidden" id="picker3Container" name="date" value="<?=date("d.m.Y")?>"/>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row-fluid">
		<div class="span3">
			<h4 data-toggle="tooltip" title="Art der Wiederholung auswählen">Wiederholung</h4>
			<select class="span10" name="period">
				<option value="null">keine</option>
				<option value="days">Täglich</option>
				<option value="weeks">Wöchentlich</option>
				<option value="months">Monatlich</option>
				<option value="years">Jährlich</option>
			</select>
		</div>
		<div class="span3">
			<h4>Ende</h4>
			<div id="picker2" class="input-append">
			    <input class="span10" data-format="dd.MM.yyyy" value="<?=date("d.m.Y")?>" type="text"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			    <input type="hidden" id="picker2Container" name="enddate" value="<?=date("d.m.Y")?>"/>
			</div>
		</div>
		<div class="span3">
			<h4 data-toggle="tooltip" title="Die Frequenz der Wiederholung (z.B. bei täglich: '1' bedeutet jeden Tag, bei wöchentlich: '2' jede 2. Woche)">Frequenz</h4>
			<input type="text" value="1" class="span10" name="duration" />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
		<h4>Station</h4>
		<select name="station">
			<option value="null">Für alle Stationen</option>
			<?php foreach(Station::getAll() as $s): ?>
			<option value="<?=$s->getId()?>"><?=$s->getTitle()?></option>
			<?php endforeach; ?>
		</select>
		</div>
	</div>
	<div class="row-fluid">
	<input type="submit" class="btn" value="hinzufügen" />
	</div>
	</form>
	</div>
</div>

<div class="tab-pane" id="o">
	<h3>Öffnungszeiträume</h3>
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Station(en)</th>
				<th>von</th>
				<th>bis</th>
				<th>am</th>
				<th>Wiederholung</th>
				<th>Ende</th>
				<th>Frequenz</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach(Calendar::getOpen() as $item): ?>
		<tr>
			<td><?=empty($item['station'])?
				'Alle Stationen':Station::load($item['station'])->getTitle()?></td>
			<td><?=$item['stime']?></td>
			<td><?=$item['etime']?></td>
			<td><?=date("d.m.Y", strtotime($item['date']))?></td>
			<?php if(empty($item['period'])): ?>
			<td colspan="3">Keine Wiederholung</td>
			<?php else: ?>
			<td><?php switch($item['period']) {
				case 'days': echo 'Täglich'; break;
				case 'weeks': echo 'Wöchentlich'; break;
				case 'months': echo 'Monatlich'; break;
				case 'years': echo 'Jährlich'; break;
			}	?></td>
			<td><?=date("d.m.Y",strtotime($item['enddate']))?></td>
			<td><?=$item['duration']?></td>
			<?php endif; ?>
			<td><a href="_calEdit.php?do=delOpen&id=<?=$item['ID']?>" 
				class="btn" onclick="return confirm('Wirklich löschen?')" >Löschen</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>

<div class="tab-pane" id="ca">
	<div class="well well-small">
	<form action="_calEdit.php" method="post" >
	<input type="hidden" name="do" value="addClosed" />
	<div class="row-fluid">
		<h3>Ausnahmenzeitraum hinzufügen</h3>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<h4>von</h4>
			<div id="picker5" class="input-append">
			    <input class="span10" data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			    <input type="hidden" id="picker5Container" name="start" value="<?=date("d.m.Y H:i")?>"/>
			</div>
		</div>
		<div class="span2">
			<h4>bis</h4>
			<div id="picker6" class="input-append">
			    <input class="span10" data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			    <input type="hidden" id="picker6Container" name="end" value="<?=date("d.m.Y H:i")?>"/>
			</div>
		</div>
		<div class="span3">
		<h4>Station</h4>
		<select name="station">
			<option value="null">Für alle Stationen</option>
			<?php foreach(Station::getAll() as $s): ?>
			<option value="<?=$s->getId()?>"><?=$s->getTitle()?></option>
			<?php endforeach; ?>
		</select>
		</div>
		<div class="span3">
		<h4>Bezeichner</h4>
			<input type="text" value="" class="span12" name="title" />
		</div>
		<div class="span2" ><br/><br/>
		<input type="submit" class="btn" value="hinzufügen" />
		</div>
	</div>
	</form>
	</div>
</div>

<div class="tab-pane" id="a">
	<h3>Ausnahmezeiträume</h3>
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Station(en)</th>
				<th>von</th>
				<th>bis</th>
				<th>Bezeichner</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach(Calendar::getClose() as $item): ?>
		<tr>
			<td><?=empty($item['station'])?
				'Alle Stationen':Station::load($item['station'])->getTitle()?></td>
			<td><?=date("H:i d.m.Y", strtotime($item['start']))?></td>
			<td><?=date("H:i d.m.Y", strtotime($item['end']))?></td>
			<td class="span6"><?=$item['title']?></td>
			<td><a href="_calEdit.php?do=delClose&id=<?=$item['ID']?>" 
				class="btn" onclick="return confirm('Wirklich löschen?')" >Löschen</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>

</div>

<?php endif; ?>