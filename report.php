<?php
require("lib/_init.php");
if(Rights::customer()):

if(User::load()->getBooking()):
$ctrl = new MyBookings();

if($_POST['do'] == 'save'):
$ctrl->report($_POST['comment']);
?>
<div class="alert alert-success">
<b>Erfolg!</b> Meldung wurde gespeichert!
</div>
<?php endif; ?>
<form action="report.php" method="post">
<div class="container">
	<h1>Meldung</h1>
	<div class="row-fluid">
		<div class="span10 offset1">
			<h4>Buchung</h4>
			# <?=User::load()->getBooking()->getId()?>
			<h4>Pedelec</h4>
			<?=User::load()->getBooking()->getBike()->getName()?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10 offset1">
			<h4>Beschreibung</h4>
			<textarea name="comment" class="span12" style="height: 30%"></textarea>
			<small>Falls ein Schaden am Pedelec entstanden ist können Sie diesen hier melden.</small>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		  <button type="submit" class="btn btn-primary">Speichern</button>
		  <button type="button" class="btn">Abbrechen</button>
		</div>
	</div>
</div>
<input type="hidden" name="do" value="save" />
</form>
<?php else: ?>

<div class="well">
<b>Achtung!</b> Meldungen können nur gemacht werden während einer Entleihe!
</div>
<?php endif; ?>

<?php else: header('location: index.php'); endif; ?>