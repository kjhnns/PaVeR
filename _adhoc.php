<?php
require("lib/_init.php");

if(Rights::hasRight('moderate')):


if($station = User::workerGetStation()):



$ctrl = new Reserve();

if($_POST['do'] == 'check'):
try {
	$res = 	Reserve::saveAdhoc($_POST['user'], 
			Station::load($_POST['station']), 
			new DateTime($_POST['end']));
	header("location: _startbooking.php?rid=".$res->getId());
	
} catch(Exception $e) {
?><div class="alert"><b>Nicht möglich!</b> <?=$e->getMessage()?></div><?php 
}
endif; 

$stations = $ctrl->getStations();


?>
	<form action="_adhoc.php" method="POST" class="form-inline" />
<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12"><h1>Adhoc Entleihe</h1></div>
		</div>
		<div class="row-fluid">
			<div class="span12"><h4>Kunde <small>E-Mail Adresse</small></h4>
			<input type="text" name="user" data-provide="typeahead"
			data-source='[<?php foreach(User::getCustomers() as $_c) echo "\"".$_c->getMail()."\","; ?>""]' />
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<h4>Startzeit</h4>
				<?=date("d.m.Y H:i")?> (jetzt)
				</div>

			<div class="span3">
				<h4>Endzeit</h4>
				<div id="picker6" class="input-append">
				    <input class="span10" data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker6Container" name="end" value="<?=date("d.m.Y H:i")?>"/>
				  </div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3">
			<h4>Startstation</h4>
				<?=User::workerGetStation()->getTitle()?>
			</div>
			<div class="span3">
				<h4>Endstation</h4>
				<select name ="station" class="span12">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'"'.
						($_REQUEST['estation'] == $st['ID']?' selected':'').'>'.$st['title'].'</option>'; ?>	
				</select>
			</div>
		</div>
		</div><br/>
			<div class="well">
			<input type="hidden" name="do" value="check" />
				<input class="btn" type="submit" value="speichern" />
			</div>
	</form>
<?php endif;?>

<?php endif;?>