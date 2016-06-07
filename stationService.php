<?php
require("lib/_init.php");

if(Rights::hasRight('moderate')):


if($station = User::workerGetStation()):

if(isset($_GET['changeStation'])) { 
	Report::logout($station, User::load());
	User::workerSetStation(null);
	header("location: stationService.php");
}

$ctrl = new Moderator();

// BIKE CHANGE
if($_POST['do'] == 'changeBike') {
	Report::bike(Bike::load($_POST['bike']), $_POST['battery'],$_POST['status']);
	header("location: stationService.php");
}


// CANCEL 
if(!empty($_GET['cancel'])) {
	$ctrl->cancelReservation($_GET['cancel']);
	header("location: stationService.php");
}

// F2c
if($_POST['do'] == 'f2c') {
	$ctrl->forcedToCancel($_POST['userId'],$_POST['reservation']);
	header("location: stationService.php");
}




$_bikes =Moderator::getBikes();

$bikes_avail = false;
foreach($_bikes as $bi) $bikes_avail = Bike::load($bi['ID'])->getDefect()?$bikes_avail: true;
$res = $ctrl->getReservations();
?>
<h1><span class="text-info">Station <?=$ctrl->getStationName()?></span> <small>am <?=date("d.m.Y")?> um <?=date("H:i")?>Uhr</small></h1>

<?php if(count(Rights::stations()) > 1): ?>
<a href="?changeStation" class="btn btn-small">Station wechseln</a><br/><br/>
<?php endif; ?>

<!-- Bike overview -->
<div class="container">

<h3>Pedelecs<small> an der <span class="text-info">Station <?=$ctrl->getStationName()?></span></small></h3>
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Nummer</th>
				<th>Typ</th>
				<th>Restreichweite</th>
				<th>Zustand (1-5)</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($_bikes as $bike): ?>
		<form action="./stationService.php" method="post">
		<tr>
			<td><?=$bike['ID']?></td>
			<td><?=Bike::load($bike['ID'])->getType()?></td>
			<td><input class="span2" type="text" name="battery" value="<?=$bike['battery']?>" />km</td>
			<td><select name="status"><?php for($i = 5; $i >= 0; $i--): ?>
			<option value="<?=$i?>" <?=($bike['status']==$i?"selected":"")?>
			/><?=Bike::statusToString($i)?></option>
			<?php endfor; ?></select></td>
			<td class="span2">
			<input type="submit" 
				onclick="return confirm('Speichern?')" 
				class="btn btn-small" value="Speichern">
			</td>
		</tr>
		<input type="hidden" name="do" value="changeBike" />
		<input type="hidden" name="bike" value="<?=$bike['ID']?>" />
		</form>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>



<!-- Anstehende Buchungen -->
<div class="container">
<h3>Anstehende Buchungen <small>an der <span class="text-info">Station <?=$ctrl->getStationName()?></span></small></h3>
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Nummer</th>
				<th>Status</th>
				<th>Benutzer</th>
				<th>Startzeit</th>
				<th>Endzeit</th>
				<th>End Station</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($res as $row): ?>
			<tr <?=(false?"class='warning'":"")?>>
				<td class="span1"><?=$row['ID']?></td>
				<td><?=Reservation::statusToString($row['status'])?></td>
				<td><?=User::load($row['user'])->getHtml()?></td>
				<td><?=fdate($row['startTime'])?></td>
				<td><?=fdate($row['endTime'])?></td>
				<td><?=Station::load($row['endstation'])->getTitle()?></td>
				
				<td class="span2">
				<? if($row['status'] == 'queued'): ?>
				<? if(cmplt($row['startTime'])): ?>
					<a 	href="_startbooking.php?rid=<?=$row['ID']?>"
						class="btn btn-primary btn-small" >Entleihe starten</a>
				<?php else: ?>
					<a class="btn btn-small" disabled>Entleihe starten</a>
				<?php endif; ?>
				<?php endif; ?>
				<? if($row['status'] == 'pending' || $row['status'] ='prefered'): ?>
					<a 	href="stationService.php?cancel=<?=$row['ID']?>"
						onclick="return confirm('Anfrage wirklich absagen?')" 
						class="btn btn-small" data-toggle="modal">Anfrage absagen</a>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!-- Bookings Overview -->
<?php $res = $ctrl->getActiveBookings(); ?>
<div class="container">
<h3>Laufende Ausleihen</h3>
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th>Nummer</th>
				<th>Nutzer</th>
				<th>Pedelec</th>
				<th>Startzeit</th>
				<th>Endzeit</th>
				<th>Start Station</th>
				<th>End Station</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($res as $row): $book = Booking::load($row['booking']); ?>
			<tr>
				<td class="span1"><?=$book->getId()?></td>
				<td><?=User::load($row['user'])->getHtml()?></td>
				<td><?=Bike::load($row['bike'])->getName()?></td>
				<td><?=date("d.m.Y H:i", strtotime($row['startTime']))?></td>
				<td><?=date("d.m.Y H:i", strtotime($row['endTime']))?></td>
				<td><?=Station::load($row['startStation'])->getTitle()?></td>
				<td><?=Station::load($row['endstation'])->getTitle()?></td>
				<td class="span2">
				<a 	href="./_endbooking.php?uid=<?=$row['user']?>"
					class="btn btn-primary btn-small">Entleihe beenden</a>
					<a 	href="./_endbooking.php?uid=<?=$row['user']?>&crash=true"
					class="btn btn-danger btn-small" data-toggle="modal">Unfall melden</a>
					<?php if($book->getForcedToCancel() == null && !$bikes_avail): ?>
					<a 	href="#f2c" role="button" onclick="ftoc(<?=$row['user']?>)" 
					class="btn btn-danger btn-small" data-toggle="modal">Absage verschuldet</a>
					<?php endif; ?>
					</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
	
	
	<!-- Modal to end a booking -->
	<div id="f2c" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="f2c" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="f2c">Absage verschuldet</h3>
	  </div>
	  <form action="./stationService.php" method="post" id="f2c">
		  <div class="modal-body">
		  Diese Ausleihe hat die Absage der folgenden Buchung erzwungen.
		  
			<input type="hidden" name="do" value="f2c" />
			<input type="hidden" name="userId" id="userId3" value="null" />
			<h4>Buchung auswählen</h4>
			<select name="reservation" style="width: 300px">
				<?php foreach($ctrl->getReservations() as $reserve): $reserve=Reservation::load($reserve['ID']); ?>
				<option value="<?=$reserve->getId()?>">Nummer <?=$reserve->getId()?> - Benutzer: <?=$reserve->getUser()->getName()?></option>
				<?php endforeach;?>
			</select>
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Abbruch</button>
		    <input type="submit"
		    class="btn btn-primary" value="Buchung absagen" />
		  </div>
	  </form>
	</div>
<!-- ENDE Booking overview -->

	

<?php require(LIVECTRLW."Access.class.php"); ?>
<div class="container">
	<h3>Zubehör <small>an der <span class="text-info">Station <?=$ctrl->getStationName()?></span></small></h3>
	<table class="table table-bordered">
		<?php foreach(Access::getCats() as $item): ?>
		<tr data-toggle="<?=$item['ID']?>" style="cursor: help;background: #eee;" class="toggletrigger">
			<td style="width: 5px"><i id='icon<?=$item['ID']?>' class='icon-plus'></i></td>
			<td><?=$item['title']?></td>
		</tr>
		<tr  data-toggle="<?=$item['ID']?>" class="toggle" style="background: #333">
			<td style="background: #fff;"></td><td colspan="5">
		
		<table class="table table-bordered">
						<tr>
							<th>zID</th>
							<th>Bezeichnung</th>
							<th>Station</th>
							<th>Exklusiv für Pedelec</th>
							<?=empty($item['attr1'])?'':'<th>'.$item['attr1'].'</th>'?>
							<?=empty($item['attr2'])?'':'<th>'.$item['attr2'].'</th>'?>
							<?=empty($item['attr3'])?'':'<th>'.$item['attr3'].'</th>'?>
							<?=empty($item['attr4'])?'':'<th>'.$item['attr4'].'</th>'?>
							<?=empty($item['attr5'])?'':'<th>'.$item['attr5'].'</th>'?>
						</tr>
		<?php foreach(Access::getStationAccess($item['ID'], User::workerGetStation()) as $access): ?>
		<tr>
			<td><?=$access->getId()?></td>
			<td><?=$access->getTitle()?></td>
			<td><?=($access->getBooking()?"entliehen an ".$access->getBooking()->getUser()->getHtml(): 
									$access->getStation()->getTitle())?></td>
			<td><?php if($access->getBike()):?>
			<?=$access->getBike()->getName()?>
			<?php else: ?>Keine Bindung<?php endif; ?></td>
			<?=empty($item['attr1'])?'':'<td>'.$access->getAttr1().'</td>'?>
			<?=empty($item['attr2'])?'':'<td>'.$access->getAttr2().'</td>'?>
			<?=empty($item['attr3'])?'':'<td>'.$access->getAttr3().'</td>'?>
			<?=empty($item['attr4'])?'':'<td>'.$access->getAttr4().'</td>'?>
			<?=empty($item['attr5'])?'':'<td>'.$access->getAttr5().'</td>'?>
		</tr>
		<?php endforeach; ?>
		</table>
		
		</td></tr>
		<?php endforeach; ?>
	</table>
</div>	

			<a href="_adhoc.php" class="btn btn-large">Adhoc Entleihe</a>
<?php else: 
$opts = Rights::stations();
if(count($opts) == 1) {
	User::workerSetStation(Station::load($opts[0]));
	Report::login(Station::load($opts[0]), User::load());
	header("location: stationService.php");
}
if($_POST['action'] == 'selectStation') {
	User::workerSetStation(Station::load($_POST['station']));
	Report::login(Station::load($_POST['station']), User::load());
	header("location: stationService.php");
}
?>

    <div class="container" style="max-width: 300px; margin-top: 80px;">
      <form class="form-signin" action="stationService.php" method="post">
		<input type="hidden" name="action" value="selectStation" />
        <h2 class="form-signin-heading">Station</h2>
        <?=($error?'<p class="text-error">Login überprüfen!</p>':'')?>
        <? if($opts !== null): ?>
        <select class="input-block-level" name="station">
        <? foreach($opts as $opt): $opt = Station::load($opt) ?>
        <option value="<?=$opt->getId()?>"><?=$opt->getTitle()?></option>
        <?php endforeach; ?>
        </select>
        <button class="btn btn-large btn-primary" type="submit">Auswählen</button>
        <?php else: ?>
        Keine Berechtigungen
        <?php endif; ?>
      </form>
    </div> <!-- /container -->
<?php endif; endif; ?>