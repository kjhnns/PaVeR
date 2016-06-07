<?php
require("lib/_init.php");
if(LOGIN):
$ctrl = new Reserve();
$stations = $ctrl->getStations();

$start = new DateTime($_POST['start']);
$end = new DateTime($_POST['end']);
$start = $start->format("d.m.Y H:i");
$end = $end->format("d.m.Y H:i");
?>
<div class="container-fluid" style="background: #eee;border-radius:10px; padding:20px; margin-bottom: 20px;">
	<form action="saveBooking.php" method="POST" class="form-inline" />
		<div class="row-fluid">
			<div class="span12"><h1>Buchungsanfrage speichern?</h1></div>
		</div>
		<div class="row-fluid">
			<div class="span2">
				<h4>Startzeit</h4>
				<p><?=$start?></p>
				<input type="hidden" name="st" value="<?=$start?>" />
			</div>
			<div class="span2">
				<h4>Endzeit</h4>
				<p><?=$end?></p>
				<input type="hidden" name="et" value="<?=$end?>" />
			</div>
			<div class="span3">
				<h4>Startstation</h4>
				<p><?=Station::load($_POST['startstation'])->getTitle()?></p>
				<input type="hidden" name="ss" value="<?=$_POST['startstation']?>" />
			</div>
			<div class="span3">
				<h4>Endstation</h4>
				<p><?=Station::load($_POST['endstation'])->getTitle()?></p>
				<input type="hidden" name="es" value="<?=$_POST['endstation']?>" />
			</div>
			<div class="span2">
				<h4>&nbsp;</h4>
				<input type="submit" class="btn btn-primary btn-large span12" value="Speichern"/>
			</div>
		</div>
		<div class="row-fluid">
			<a class="btn btn-small" href="javascript:history.back()">zur&uuml;ck</a>
		</div>
	</form>
</div>

<?php endif; ?>