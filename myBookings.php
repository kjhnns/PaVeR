<?php
require("lib/_init.php");
if(Rights::customer()):

$ctrl = new MyBookings();

if(!empty($_GET['cancel'])) {
	$res = $ctrl->cancelReservation($_GET['cancel']);
	header("location: myBookings.php");
}

$res = $ctrl->getReservations();
?>
<h1>Meine Anfragen</h1>
<?php foreach($res as $row): ?>
<div class="container-fluid" >
<div class="<?=($row['status'] == 'queued'?"info ":"").
						($row['status'] == 'failed'?"error ":"").
						($row['status'] == 'progress'?"warning ":"").
						($row['status'] == ''?"success ":"").
						($row['status'] == 'unattended'?"error ":"").
						($row['status'] == 'canceled'?"error ":"")?> ">
<div class="row-fluid">
	<div class="span1">		
	<h4>Anfrage</h4>	
	<p><?=$row['ID']?></p>
	</div>
	<div class="span2">		
	<h4>Status</h4>	
	<p><?=Reservation::statusToString($row['status'])?></p>
	</div>
	<div class="span2">		
	<h4>Startzeit</h4>	
	<p><?=date("d.m.Y H:i",strtotime($row['startTime']))?></p>
	</div>
	<div class="span2">		
	<h4>Endzeit</h4>	
	<p><?=date("d.m.Y H:i",strtotime($row['endTime']))?></p>
	</div>
	<div class="span2">		
	<h4>Endstation</h4>	
	<p><?=Station::load($row['startstation'])->getTitle()?></p>
	</div>
	<div class="span2">		
	<h4>Endstation</h4>	
	<p><?=Station::load($row['startstation'])->getTitle()?></p>
	</div>
	<div class="span1">	<h4>&nbsp;</h4>
	<p><? if(	$row['status'] == 'pending' || 
						$row['status'] == 'prefered' || 
						$row['status'] == 'queued' 	):?>
				<a href="./myBookings.php?cancel=<?=$row['ID']?>" 
				onclick="return confirm('Möchten Sie diese Anfrage/Buchung wirklich stornieren?')" class="btn btn-small">stornieren</a>
				<?php endif; ?></p>
	</div>
				
</div>
</div></div>
			<?php endforeach; ?>

<br/>

<a class="btn btn-primary btn-large" href="./bookingForm.php">neue Anfrage</a>

<?php else: header('location: index.php'); endif; ?>