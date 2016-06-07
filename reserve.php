<?php
require("lib/_init.php");
if(Rights::customer()):
$ctrl = new Reserve();

// Index Site
$stations = $ctrl->getStations();

// Save 
if($_REQUEST['do'] == 'save'): 
$res = $ctrl->save($_REQUEST['sstation'],$_REQUEST['estation'],
			$_REQUEST['hr'],$_REQUEST['mm']);
?><div class="container"><?php
if($res):
?>
<h1>Gespeichert</h1>
<div class="well">Reservierung erfolgreich gespeichert!</div>
<?php else: ?>
<h1>Nicht Gespeichert</h1>
<div class="well">Es ist ein Fehler aufgetreten beim speichern!</div>
<?php endif; ?>
</div>
<?php endif;


// Validate Back n Forth Neeeds improvement Badly
if($_REQUEST['do'] == 'validateBacknForth'):
if(	$_pq = $ctrl->validatePQ(	$_REQUEST['sstation'],$_REQUEST['estation'],
		$_REQUEST['hr'],$_REQUEST['mm'],$_REQUEST['sstation2'],$_REQUEST['estation2'],
		$_REQUEST['hr2'],$_REQUEST['mm2']) ||
		$_q = $ctrl->validateQ(	$_REQUEST['sstation'],$_REQUEST['estation'],
		$_REQUEST['hr'],$_REQUEST['mm'],$_REQUEST['sstation2'],$_REQUEST['estation2'],
		$_REQUEST['hr2'],$_REQUEST['mm2']) ):
?>
<div class="container">
	<div class="hero-unit">
	<form action="reserve.php" method="POST" class="form-inline" />
		<div class="row">
			<div class="span9"><h1>Reservierung möglich</h1></div>
		</div>
		<div class="row">
			<div class="span2">
				<h4>Startzeit</h4>
				<p><?=$_REQUEST['hr']?>:<?=$_REQUEST['mm']?></p>
			</div>
			<div class="span2">
				<h4>Start Station</h4>
				<p><?=$stations[$_REQUEST['sstation']]['title']?></p>
			</div>
			<div class="span2">
				<h4>End Station</h4>
				<p><?=$stations[$_REQUEST['estation']]['title']?></p>
			</div>
			<div class="span2 offset1">
				<h4>&nbsp;</h4>
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm']?>" />
				<input type="hidden" name="do" value="save" />
			</div>
		</div>
		<div class="row">
			<div class="span2">
				<h4>Startzeit</h4>
				<p><?=$_REQUEST['hr2']?>:<?=$_REQUEST['mm2']?></p>
			</div>
			<div class="span2">
				<h4>Start Station</h4>
				<p><?=$stations[$_REQUEST['sstation2']]['title']?></p>
			</div>
			<div class="span2">
				<h4>End Station</h4>
				<p><?=$stations[$_REQUEST['estation2']]['title']?></p>
			</div>
			<div class="span2 offset1">
				<h4>&nbsp;</h4>
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation2']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation2']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr2']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm2']?>" />
				<input type="hidden" name="do" value="save" />
				<input type="submit" disabled class="btn btn-primary btn-large" value="verbindlich zusagen"/>
			</div>
		</div>
	</form>
	</div>
</div>
<?php 
else:
?>
<div class="container">
	<div class="hero-unit">
	<!--  <form action="reserve.php" method="POST" class="form-inline" />  -->
		<div class="row">
			<div class="span9"><h1>Reservierung nicht möglich</h1></div>
		</div>
		<div class="row">
			<div class="span2">
				<h4>Hinfahrt</h4>
				<p><?=$_REQUEST['hr']?>:<?=$_REQUEST['mm']?></p>
			</div>
			<div class="span2">
				<h4>Start</h4>
				<p><?=$stations[$_REQUEST['sstation']]['title']?></p>
			</div>
			<div class="span2">
				<h4>End</h4>
				<p><?=$stations[$_REQUEST['estation']]['title']?></p>
			</div>
			<div class="span2 offset1">
				<h4>&nbsp;</h4>
				<!--  
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm']?>" />
				<input type="hidden" name="do" value="save" />
				-->
				<input type="submit" disabled class="btn btn-primary btn-large" value="auf die Warteliste"/>
			</div>
		</div>
		<div class="row">
			<div class="span2">
				<h4>Rückfahrt</h4>
				<p><?=$_REQUEST['hr2']?>:<?=$_REQUEST['mm2']?></p>
			</div>
			<div class="span2">
				<h4>Start</h4>
				<p><?=$stations[$_REQUEST['sstation2']]['title']?></p>
			</div>
			<div class="span2">
				<h4>Ende</h4>
				<p><?=$stations[$_REQUEST['estation2']]['title']?></p>
			</div>
			<div class="span2 offset1">
				<h4>&nbsp;</h4>
				<!-- 
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation2']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation2']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr2']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm2']?>" />
				<input type="hidden" name="do" value="save" />
				 -->
				</div>
		</div>
		<div class="row">
			<div class="span6">
			<h2>Was ist die Warteliste?</h2>
			<p>Auf der Warteliste...</p>
			</div>
		</div>
	<!-- </form> -->
	</div>
</div>
<?php
endif;
endif;

// Validate Site
if($_REQUEST['do'] == 'validate'):
if(	$_pq = $ctrl->validatePQ(	$_REQUEST['sstation'],$_REQUEST['estation'],
	$_REQUEST['hr'],$_REQUEST['mm']) ||
	$_q = $ctrl->validateQ(	$_REQUEST['sstation'],$_REQUEST['estation'],
	$_REQUEST['hr'],$_REQUEST['mm']) ):
?>
<div class="container">
	<div class="hero-unit">
	<form action="reserve.php" method="POST" class="form-inline" />
		<div class="row">
			<div class="span9"><h1>Reservierung möglich</h1></div>
		</div>
		<div class="row">
			<div class="span2">
				<h4>Startzeit</h4>
				<p><?=$_REQUEST['hr']?>:<?=$_REQUEST['mm']?></p>
			</div>
			<div class="span2">
				<h4>Start Station</h4>
				<p><?=$stations[$_REQUEST['sstation']]['title']?></p>
			</div>
			<div class="span2">
				<h4>End Station</h4>
				<p><?=$stations[$_REQUEST['estation']]['title']?></p>
			</div>
			<div class="span2 offset1">
				<h4>&nbsp;</h4>
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm']?>" />
				<input type="hidden" name="do" value="save" />
				<input type="submit" class="btn btn-primary btn-large" value="verbindlich zusagen"/>
			</div>
		</div>
	</form>
	</div>
</div>
<?php
else:
?>
<div class="container">
	<div class="hero-unit">
	<form action="reserve.php" method="POST" class="form-inline" />
		<div class="row">
			<div class="span9"><h1>Reservierung nicht möglich</h1></div>
		</div>
		<div class="row">
			<div class="span2">
				<h4>Startzeit</h4>
				<p><?=$_REQUEST['hr']?>:<?=$_REQUEST['mm']?></p>
			</div>
			<div class="span2">
				<h4>Start Station</h4>
				<p><?=$stations[$_REQUEST['sstation']]['title']?></p>
			</div>
			<div class="span2">
				<h4>End Station</h4>
				<p><?=$stations[$_REQUEST['estation']]['title']?></p>
			</div>
			<div class="span2 offset1">
				<h4>&nbsp;</h4>
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm']?>" />
				<input type="hidden" name="do" value="save" />
				<input type="submit" class="btn btn-primary btn-large" value="auf die Warteliste"/>
			</div>
		</div>
		<div class="row">
			<div class="span6">
			<h2>Was ist die Warteliste?</h2>
			<p>Auf der Warteliste...</p>
			</div>
		</div>
	</form>
	</div>
</div>
<?php if($_REQUEST['sstation'] != $_REQUEST['estation']): ?>
<div class="container">
	<div class="hero-unit">
	<form action="reserve.php" method="GET" class="form-inline" />
		<div class="row">
			<div class="span9"><h1>Rückfahrt hinzufügen</h1></div>
		</div>
		<div class="row">
			<div class="span3">
				<h4>Hinfahrt</h4>
				<select name ="hr" style="width: 70px;" disabled><?=$ctrl->hrsSelect();?></select>
				<select name ="mm" style="width: 70px;" disabled><?=$ctrl->minSelect();?></select>
			</div>
			<div class="span3">
				<h4>Start</h4>
				<select name ="sstation" disabled>
				<?='<option value="'.$stations[$_REQUEST['sstation']]['ID'].'">'.
				$stations[$_REQUEST['sstation']]['title'].'</option>'?>
				</select>
			</div>
			<div class="span3">
				<h4>Ende</h4>
				<select name ="estation" disabled>
				<?='<option value="'.$stations[$_REQUEST['estation']]['ID'].'">'.
				$stations[$_REQUEST['estation']]['title'].'</option>'?>
				</select>
			</div>
			<div class="span1">
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="hr" value="<?=$_REQUEST['hr']?>" />
				<input type="hidden" name="mm" value="<?=$_REQUEST['mm']?>" />
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<h4>Rückfahrt</h4>
				<select name ="hr2" style="width: 70px;"><?=$ctrl->hrsSelect(true);?></select>
				<select name ="mm2" style="width: 70px;"><?=$ctrl->minSelect(true);?></select>
			</div>
			<div class="span3">
				<h4>Start</h4>
				<select name ="sstation2" disabled>
				<?='<option value="'.$stations[$_REQUEST['estation']]['ID'].'">'.
				$stations[$_REQUEST['estation']]['title'].'</option>'?>
				</select>
			</div>
			<div class="span3">
				<h4>Ende</h4>
				<select name ="estation2">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'"'.
						($_REQUEST['estation'] == $st['ID']?' disabled':'').'>'.$st['title'].'</option>'; ?>	
				</select>
			</div>
			<div class="span1">
				<input type="hidden" name="sstation2" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="do" value="validateBacknForth" />
				<input data-loading-text="prüfen..." type="submit" class="btn btn-primary btn-large" value="Prüfen"/>
			</div>
		</div>
		<div class="row">
			<div class="span6"><br/>
			<h2>Rückfahrten können helfen</h2>
			<p>Bei angabe einer Rückfahrt können sich inkonsistenzen auflösen.</p>
			</div>
		</div>
	</form>
	</div>
</div>
<?php
endif;
endif;
endif;
?>


<?php if($_REQUEST['do'] == ''): ?>
<div class="container">
	<div class="hero-unit">
	<form action="reserve.php" method="GET" class="form-inline" />
		<div class="row">
			<div class="span9"><h1>Reservierung prüfen</h1></div>
		</div>
		<div class="row">
			<div class="span3">
				<h4>Startzeit</h4>
				<select name ="hr" style="width: 70px;"><?=$ctrl->hrsSelect();?></select>
				<select name ="mm" style="width: 70px;"><?=$ctrl->minSelect();?></select>
			</div>
			<div class="span3">
				<h4>Start Station</h4>
				<select name ="sstation" disabled>
				<?='<option value="'.$stations[$_REQUEST['sstation']]['ID'].'">'.
				$stations[$_REQUEST['sstation']]['title'].'</option>'?>
				</select>
			</div>
			<div class="span3">
				<h4>End Station</h4>
				<select name ="estation">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'"'.
						($_REQUEST['estation'] == $st['ID']?' selected':'').'>'.$st['title'].'</option>'; ?>	
				</select>
			</div>
			<div class="span1">
				<h4>&nbsp;</h4>
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="do" value="validate" />
				<input data-loading-text="prüfen..." type="submit" class="btn btn-primary btn-large" value="Prüfen"/>
			</div>
		</div>
	</form>
	</div>
</div>
<?php endif; ?>
<?php else: header('location: index.php'); endif; ?>
