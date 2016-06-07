<?php
require("lib/_init.php");
if(Rights::hasRight("worker")):

require(LIVECTRLW."Worker.class.php");

$_users = Worker::getWorker();


if($_POST['do'] == 'addUser') {
	Worker::create($_POST['start'],$_POST['end'],
	$_POST['phone'], $_POST['surname'],
	$_POST['name'], $_POST['mail'], $_POST['rs']);
	header("location: _worker.php");
}

if($_POST['do'] == 'editUser') {
	Worker::edit($_POST['user'], $_POST['start'],$_POST['end'],
	$_POST['phone'], $_POST['surname'],
	$_POST['name'], $_POST['mail']);
	header("location: _worker.php");
}

if($_POST['do'] == 'changeRights') {
	Worker::changeRights($_POST['rs'],$_POST['sr'], User::load($_POST['user']));
	header("location: _worker.php");
}

if($_REQUEST['do'] == 'resetpw') {
	Worker::resetPw($_GET['uid']);
	echo "<div class=\"alert\"><b>Passwort zurückgesetzt!</b> Das Passwort wurde zurückgesetzt. Das neue Passwort wurde an die angegebene E-Mail Adresse geschickt.</div>";
}
	
?>
<h1>Mitarbeiter Übersicht</h1>


<!-- Bike overview -->
<div class="container">
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th></th>
				<th>Mitarbeiter</th>
				<th>Telefonnummer</th>
				<th>Name</th>
				<th>E-Mail</th>
				<th>Gültigkeit</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($_users as $user): ?>
		<tr>
			<td class="span1">
				<div class="btn-group dropleft">
				  <a class="btn btn-primary btn-small" data-toggle="dropdown" 
				  href="javascript:$(this).dropdown()">Optionen <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				    <li><a href="_worker.php?wid=<?=$user->getId()?>">Protokoll</a></li>
				    <li><a href="_worker.php?edit=<?=$user->getId()?>" >Konto bearbeiten und Gültigkeit</a></li>
				    <li><a href="_worker.php?rights=<?=$user->getId()?>" >Rechte und Stationen</a></li>
				    <li><a onclick="return confirm('Passwort zurücksetzen?')" href="_worker.php?do=resetpw&uid=<?=$user->getId()?>">Passwort zurücksetzen</a> </li>
				 	<li class="divider"></li>
				  	<li>Erstellt von: </li>
				  	<li><?=$user->getCreator()->getHtml()?></li>
				  	<li>Erstellt am: </li>
				  	<li><?=$user->getCreated()->format("H:i d.m.Y")?></li>
				  </ul>
				</div>
			</td>
		
			<td><?=$user->getId()?></td>
			<td><?=$user->getPhone()?></td>
			<td><?=$user->getSurName()?>, <?=$user->getName()?></td>
			<td><?=$user->getMail()?></td>
			<td><?=date("d.m.Y H:i", strtotime($user->getStart()))?> - <?=date("d.m.Y H:i", strtotime($user->getEnd()))?></td>
			
			
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php if(isset($_GET['edit'])): $u = User::load($_GET['edit']); ?>
<div class="container" id="createBox">
<H3>Mitarbeiter bearbeiten</H3>
<form action="./_worker.php" method="post">
	<table class="table table-bordered span8">
	<tr><td>Beginn der Gültigkeit:</td><td>
		<div id="picker5" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i", strtotime($u->getStart()))?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker5Container" name="start" value="<?=date("d.m.Y H:i", strtotime($u->getStart()))?>"/>
				  </div>
	</td></tr>
	<tr><td>Ende der Gültigkeit</td><td>
		<div id="picker6" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i", strtotime($u->getEnd()))?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker6Container" name="end" value="<?=date("d.m.Y H:i", strtotime($u->getEnd()))?>"/>
				  </div>
	</td></tr>
	<tr><td>Telefonnummer</td><td><input type="text" name="phone" value="<?=$u->getPhone()?>" /></td></tr>
	<tr><td>Name</td><td><input type="text" name="surname" value="<?=$u->getSurName()?>" /></td></tr>
	<tr><td>Vorname</td><td><input type="text" name="name" value="<?=$u->getName()?>" /></td></tr>
	<tr><td>E-Mail</td><td><input type="text" name="mail" value="<?=$u->getMail()?>" /></td></tr>
	<td colspan="2"><input type="submit" class="btn" value="Speichern" /></td></tr>
		<input type="hidden" name="do" value="editUser" />
		<input type="hidden" name="user" value="<?=$u->getId()?>" />
	</table>	
</form>
</div>

<?php endif; ?>

<?php if(isset($_GET['rights'])): $u = User::load($_GET['rights']); ?>
<div class="container">
<form action="_worker.php" method="post">
<h3>Mitarbeiter <?=$u->getfName()?></h3>
		<input type="hidden" name="user" value="<?=$u->getId()?>"  />
<table class="table table-bordered span8">

<tr style="background: #eee;"><th colspan="2">Rechte von Mitarbeiter <?=$u->getfName()?></th></tr>
<?php foreach(Rights::allRights() as $key => $dat): ?>
	<tr>
	<td><label for="rs<?=$key?>" data-toggle="tooltip" title="<?=$dat['desc']?>"><?=$dat['label']?></label></td>
	<td><input id="rs<?=$key?>" type="checkbox" name="rs[<?=$key?>]" value="1" <?=(Rights::hasRight($key, $u)?'checked': '')?>/></td>
	</tr>
<?php endforeach;?>
<tr style="background: #eee;"><th colspan="2">Stationen von Mitarbeiter <?=$u->getfName()?></th></tr>
<?php foreach(Station::getAll() as $s): ?>
	<tr>
	<td><label for="sr<?=$s->getId()?>"><?=$s->getTitle()?></label></td>
	<td><input id="sr<?=$s->getId()?>" type="checkbox" name="sr[<?=$s->getId()?>]" value="1" <?=(Rights::hasStation($s,$u)?'checked': '')?>/></td>
	</tr>
<?php endforeach;?>
<tr><td colspan="2"><input type="submit" class="btn" value="Speichern" /></td></tr>
		<input type="hidden" name="do" value="changeRights" />
</table>
</form>
</div>
<?php endif; ?>

<?php 
if(!empty($_GET['wid'])): 
?>
<h3>Protokoll von Mitarbeiter <?=User::load(intval($_GET['wid']))->getfName()?></h3>
<div class="container">
	<table class="table table-bordered">
			<thead style="background: #eee;">
			<tr>
				<th>Zeitpunkt</th>
				<th>Typ</th>
				<th>Pedelec</th>
				<th>Kunde</th>
				<th>Restreichweite</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach(Report::getWorkerSessions($_GET['wid']) as $report): ?>
		<tr>
			<td><?=date("H:i d.m.Y",strtotime($report->getTime()))?></td>
			<td><?=Report::subToString($report->getSubject())?></td>
			<td><?=($report->getBike()?"Nr. ".$report->getBike()->getId(): '-')?></td>
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

<hr/>
<script>
$(function() {
	$('#createToggle').click(function() {
		$('#createBox').toggle();
	});
});
</script>
<p id="createToggle" class="btn" style="cursor: pointer">Mitarbeiter erstellen</p><br/><br/>
<div style="display: none;" class="container" id="createBox">
<H3>Mitarbeiter erstellen</H3>
<form action="./_worker.php" method="post">
	<table class="table table-bordered span8">
	<tr><td>Beginn der Gültigkeit:</td><td colspan="2">
		<div id="picker5" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker5Container" name="start" value="<?=date("d.m.Y H:i")?>"/>
				  </div>
	</td></tr>
	<tr><td>Ende der Gültigkeit</td><td colspan="2">
		<div id="picker6" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker6Container" name="end" value="<?=date("d.m.Y H:i")?>"/>
				  </div>
	</td></tr>
	<tr><td>Telefonnummer</td><td colspan="2"><input type="text" name="phone" /></td></tr>
	<tr><td>Name</td><td colspan="2"><input type="text" name="surname" /></td></tr>
	<tr><td>Vorname</td><td colspan="2"><input type="text" name="name" /></td></tr>
	<tr><td>E-Mail</td><td colspan="2"><input type="text" name="mail" /></td></tr>
	<tr><td rowspan="<?=count(Rights::allRights())?>">Rechte</td>
	
			<?php foreach(Rights::allRights() as $key => $dat): ?>
			<td><label for="rs<?=$key?>" data-toggle="tooltip" title="<?=$dat['desc']?>"><?=$dat['label']?></label></td>
			<td><input id="rs<?=$key?>" type="checkbox" name="rs[<?=$key?>]" value="1" /></td></tr><tr>
			<?php endforeach;?>
	<td colspan="3"><input type="submit" class="btn" value="Speichern" /></td></tr>
		<input type="hidden" name="do" value="addUser" />
	</table>	
</form>
</div>

<?php
else: echo "Keine Berechtigung!"; endif;
?>