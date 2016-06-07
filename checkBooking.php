<?php
require("lib/_init.php");
if(LOGIN):
$ctrl = new Reserve();
$stations = $ctrl->getStations();
?>
<div class="container-fluid" style="background: #eee;border-radius:10px; padding:20px; margin-bottom: 20px;">
	<form action="saveBooking.php" method="POST" class="form-inline" />
		<div class="row-fluid">
			<div class="span12"><h1>Buchungsanfrage speichern?</h1></div>
		</div>
		<? if($_REQUEST['do'] === 'twoway'):?>
		<div class="row-fluid">
			<div class="span12"><h3>Hinfahrt</h3></div>
		</div>
		<?php endif;?>
		<div class="row-fluid">
			<div class="span2">
				<h4>Startzeit</h4>
				<?php $tmpD = new DateTime($_REQUEST['time']); ?>
				<p><?=$tmpD->format("d.m.Y H:i")?></p>
			</div>
			<div class="span2">
				<h4>Endzeit</h4>
				<?php $tmpD->modify("+".(int)$_REQUEST['return']." minutes"); ?>
				<p><?=$tmpD->format("d.m.Y H:i")?></p>
			</div>
			<div class="span3">
				<h4>Startstation</h4>
				<p><?=$stations[$_REQUEST['sstation']]['title']?></p>
			</div>
			<div class="span3">
				<h4>Endstation</h4>
				<p><?=$stations[$_REQUEST['estation']]['title']?></p>
			</div>
			<div class="span2">
				<h4>&nbsp;</h4>
				<input type="hidden" name="ss" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="es" value="<?=$_REQUEST['estation']?>" />
				<?php $tmpD = new DateTime($_REQUEST['time']);  ?>
				<input type="hidden" name="st" value="<?=$tmpD->format("d.m.Y H:i")?>" />
				<?php $tmpD->modify("+".(int)$_REQUEST['return']." minutes"); ?>
				<input type="hidden" name="et" value="<?=$tmpD->format("d.m.Y H:i")?>" />
				<?php if($_REQUEST['do'] !== 'twoway'): ?>
				<input type="submit" class="btn btn-primary btn-large span12" value="speichern"/>
				<?php endif; ?>
			</div>
		</div>
		<?php if($_REQUEST['do'] == 'twoway'): ?>
		<div class="row-fluid">
			<div class="span12"><h3>Rückfahrt</h3></div>
		</div>
		<div class="row-fluid">
			<div class="span2">
				<h4>Startzeit</h4>
				<?php $tmpD = new DateTime($_REQUEST['time2']); ?>
				<p><?=$tmpD->format("d.m.Y H:i")?></p>
			</div>
			<div class="span2">
				<h4>Endzeit</h4>
				<?php $tmpD = new DateTime($_REQUEST['time2']); 
				$tmpD->modify("+".(int)$_REQUEST['return2']." minutes"); ?>
				<p><?=$tmpD->format("d.m.Y H:i")?></p>
			</div>
			<div class="span3">
				<h4>Startstation</h4>
				<p><?=$stations[$_REQUEST['sstation2']]['title']?></p>
			</div>
			<div class="span3">
				<h4>Endstation</h4>
				<p><?=$stations[$_REQUEST['estation2']]['title']?></p>
			</div>
			<div class="span2">
				<h4>&nbsp;</h4>
				
				<input type="hidden" name="ss2" value="<?=$_REQUEST['sstation2']?>" />
				<input type="hidden" name="es2" value="<?=$_REQUEST['estation2']?>" />
				<?php $tmpD = new DateTime($_REQUEST['time2']);  ?>
				<input type="hidden" name="st2" value="<?=$tmpD->format("d.m.Y H:i")?>" />
				<?php $tmpD->modify("+".(int)$_REQUEST['return2']." minutes"); ?>
				<input type="hidden" name="et2" value="<?=$tmpD->format("d.m.Y H:i")?>" />
				<input type="hidden" name="oneway" value="false" />
			</div>
		</div><br/>
		<div class="row-fluid"><input type="submit" class="btn btn-primary btn-large span4 offset4" value="speichern"/></div>
		<?php endif; ?>
		<div class="row-fluid">
			<a class="btn btn-small" href="javascript:history.back()">zur&uuml;ck</a>
		</div>
	</form>
</div>


<?php if($_REQUEST['sstation'] != $_REQUEST['estation'] && $_REQUEST['do'] != 'twoway'): ?>
<div class="container-fluid" style="background: #eee;border-radius:10px; padding:20px;">
	<form action="checkBooking.php" method="GET" class="form-inline" />
		<div class="row-fluid">
			<div class="span9"><h1>Rückfahrt hinzufügen</h1></div>
		</div>
		<div class="row-fluid">
			<div class="span2">
				<h4>Startzeit</h4><?php $tmpD = new DateTime($_REQUEST['time']); 
				$tmpD->modify("+".(int)$_REQUEST['return']." minutes"); ?>
				<div id="picker1" class="input-append">
				    <input class="span4" data-format="hh:mm" value="<?=$tmpD->format("H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker1Container" name="time2" value="<?=$tmpD->format("H:i")?>"/>
				  </div>
			</div>
			<div class="span2">
				<h4>Länge der Entleihe</h4>
				<select name="return2" class="span12">
				<?php for($i = 15; $i<=40; $i+=5): ?>
					<option value="<?=$i?>"><?=$i?> Minuten</option>
				<?php endfor; ?>
				</select>
			</div>
			<div class="span3">
				<h4>Start</h4>
				<select class="span12" name ="sstation2" disabled>
				<?='<option value="'.$stations[$_REQUEST['estation']]['ID'].'">'.
				$stations[$_REQUEST['estation']]['title'].'</option>'?>
				</select>
			</div>
			<div class="span3">
				<h4>Ende</h4>
				<select class="span12" name ="estation2">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'"'.
						($_REQUEST['estation'] == $st['ID']?' disabled':'').'>'.$st['title'].'</option>'; ?>	
				</select>
			</div>
			<div class="span2">
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<input type="hidden" name="estation" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="time" value="<?=$_REQUEST['time']?>" />
				<input type="hidden" name="return" value="<?=$_REQUEST['return']?>" />
				<input type="hidden" name="sstation2" value="<?=$_REQUEST['estation']?>" />
				<input type="hidden" name="do" value="twoway" />
				<input type="submit" class="btn btn-primary btn-large span12" value="hinzufügen"/>
			</div>
		</div>
	</form>
</div>
<?php
endif;
?>
				
				
<?php else: header('location: index.php'); endif; ?>