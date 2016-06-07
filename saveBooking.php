<?php
require("lib/_init.php");
if(Rights::customer()):
$ctrl = new Reserve();
$stations = $ctrl->getStations();

// Save 
$msg = false;

try {
	if($_REQUEST['oneway'] !== 'false')
		$res = $ctrl->save(Station::load($_POST['ss']), Station::load($_POST['es']),
				new DateTime($_POST['st']), new DateTime($_POST['et']));
	else

		$res = 	$ctrl->save(Station::load($_POST['ss']), Station::load($_POST['es']),
				new DateTime($_POST['st']), new DateTime($_POST['et']))
				&&
				$ctrl->save(Station::load($_POST['ss2']), Station::load($_POST['es2']),
				new DateTime($_POST['st2']), new DateTime($_POST['et2']));

}catch(Exception $e) {
	$res = false;
	$msg = $e->getMessage();
}

if($res) header("location: saveBookingSuccess.php");
?>
<div class="container-fluid">
<h1>Buchungsanfrage kann nicht gespeichert werden</h1>
<div class="well">Begründung:
<?php if($msg): ?>
<br/><br/><?=$msg?>

<br/><br/><a class="btn btn-primary" href="bookingForm.php?sstation=<?=$_REQUEST['ss']?>">neue Anfrage</a>
<?php endif; ?>
</div>

</div>


<?php else: header('location: index.php'); endif; ?>