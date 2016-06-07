<?php
require("lib/_init.php");

if(Rights::hasRight('moderate')):

if($_POST['do'] == 'end') {
	$access =  array();
	foreach($_POST['access'] as $id => $val)
		if($val == '1') $access['ok'][] =  Accessorie::load($id);
	else $access['broke'][] =  Accessorie::load($id);
	Moderator::endBooking($_POST['userId'], $_POST['comment'],
	$_POST['battery'], $_POST['status'], $access);
	header("location: stationService.php");
}

if($_POST['do'] == 'crash') {
	$access =  array();
	foreach($_POST['access'] as $id => $val)
		if($val == '1') $access['ok'][] =  Accessorie::load($id);
		else $access['broke'][] =  Accessorie::load($id);
	Moderator::crash($_POST['userId'], $_POST['comment'], $access);
	header("location: stationService.php");
}


$_crash = (isset($_GET['crash'])?
			$_GET['crash']=='true':false);

$user = User::load($_GET['uid']);
$booking = $user->getBooking();
?>

<h1><?=($_crash?'Unfall melden':'Rückgabe')?></h1>
	<form action="./_endbooking.php" method="post">
		  <div class="well">
			<input type="hidden" name="do" value="<?=($_crash?'crash':'end')?>" />
			<input type="hidden" name="userId" id="userId" value="<?=$user->getId()?>" />
			
			
			<h2>Pedelec 
					 <small>#<?=$booking->getBike()->getId()?>
					 <?=$booking->getBike()->getType()?></small></h2>
			<?php if($_crash): ?>
				wird in den Wartungs Zustand versetzt
			<?php else: ?>
					  <label for="battery">
					  Restreichweite:
					  </label>
					  <input type="battery" name="battery" id="battery" />km<br/>
					  
					  <label for="status">
					  Status:
					  </label>
					  <select name="status" id="status">
					  <?php for($j = 5; $j>=0; $j--): ?>
					  <option value="<?=$j?>"><?=Bike::statusToString($j)?></option>
					  <?php endfor; ?>
					  </select>
			<?php endif; ?>
			
			<h2>Zubehör <small>zurückgegeben?</small></h2>
			<?php foreach($booking->getAccess() as $access): ?>
			<?=$access->getCheckBox()?><br/>
			<?php endforeach; ?>
			
			
		    <h2>Bericht</h2>
		    <textarea name="comment" class="span4"></textarea>
		  </div>
		  <div class="container">
		    <a class="btn" href="stationService.php">Abbruch</a>
		    <input type="submit" onclick="return confirm('Zurückgegebenes Zubehör makiert?')" 
		    class="btn btn-primary" value="Pedelec zurücknehmen" />
		  </div>
	  </form>


<?php endif; ?>