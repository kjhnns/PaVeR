<?php
require("lib/_init.php");

if(Rights::hasRight('moderate')):

$_bikes = Moderator::getBikes();

$reservation = Reservation::load($_GET['rid']);

$pedelec = empty($_GET['pedelec'])?null:Bike::load($_GET['pedelec']);

if(!cmplt($reservation->getStartTime()) ||
	$reservation->getStatus() != 'queued' ) die("Nicht zur Entleihe vorgesehen!");


// START BOOKING
if($_POST['do'] == 'startBooking') {
	$access =  array();
	foreach($_POST['access'] as $cat => $acc) 
	if($acc != 'null') $access[] =  Accessorie::load($acc);
	Moderator::startBooking($_POST['booking'], $_POST['bike'], $access);
	header("location: stationService.php");
}

?>
<h1>Entleihe starten</h1>
<form action="./_startbooking.php?rid=<?=$reservation->getId()?>" method="post">
		  <div class="well">
			<input type="hidden" name="do" value="startBooking" />
			<input type="hidden" name="booking" value="<?=$reservation->getId()?>" />
		    
		    <!-- PEDELEC AUSWAHL START -->
			<script>
			function chPedSel() {
				location.href="_startbooking.php?rid=<?=$reservation->getId()?>&pedelec="+ $('#pedSel').val();
			}
			</script>
		    <h3>Pedelec</h3>
		    <?php if(count($_bikes) > 0): ?>
		    	<?php if($pedelec === null): ?>
				    <select name="bike" style="width: 120px;" id="pedSel" onchange="chPedSel()">
					<option value="">Pedelec auswählen</option>
					<?php foreach($_bikes as $bike):?>
						<option value="<?=$bike['ID']?>" 
						<?=(Bike::load($bike['ID'])->getDefect()?'disabled':'')?>><?=Bike::load($bike['ID'])->getName()?></option>
					<?php endforeach; ?></select>
				<?php else: ?>
				<?=$pedelec->getName()?> - <a href="_startbooking.php?rid=<?=$reservation->getId()?>">zurücksetzen</a>
				<input type="hidden" name="bike" value="<?=$pedelec->getId()?>" />
				<?php endif; ?>
			<?php else: ?>
			<i>kein Pedelec vorhanden!</i>
			<?php endif; ?>
			<br/>
			<!-- PEDELEC AUSWAHL ENDE -->
			
			<?php if($pedelec !== null): ?>
			<h3>Zubehör</h3>
			<?php foreach(Accessorie::getCats() as $cat): ?>
			<h5><?=$cat['title']?></h5>
			<!-- <select <?=($cat['limit']>1?'multiple="multiple"':'')?>> -->
			<select name="access[<?=$cat['ID']?>]">
			<option value="null">kein Zubehör</option>
			<?php foreach(Accessorie::getAccess($cat['ID'], 
					User::workerGetStation()) as $ac) echo $ac->getSelOption($pedelec); ?>
			</select>
			<?php endforeach; ?>
			<?php endif; ?>
		  </div>
		  <div class="container">
		    <a class="btn" href="stationService.php">Abbruch</a>
			<?php if($pedelec !== null): ?>
		    <input type="submit" class="btn btn-primary" 
		    	value="<?=Moderator::bikesAvail()?
				'Pedelec entleihen':'Kein Pedelec zur Verfügung'?>" 
		    	<?=Moderator::bikesAvail()?'':'disabled'?>/>
			<?php endif; ?>
		  </div>
</form>

<?php endif; ?>