<?php
require("lib/_init.php");
if(LOGIN):
$ctrl = new Reserve();
$stations = $ctrl->getStations();



// date("H").":".(date("i")%5==0?date("i"):(date("i") + 5 - date("i")%5))


?>
<div class="container-fluid" style="background: #eee;border-radius:10px; padding:20px; margin-bottom: 20px;">
	<form action="checkBooking.php" method="GET" class="form-inline" />
		<div class="row-fluid">
			<div class="span12"><h1>Schnelle Buchungsanfrage für heute</h1></div>
		</div>
		<div class="row-fluid">
			<div class="span2">
				<h4>Startzeit</h4>
				<div id="picker1" class="input-append">
				    <input class="span8" data-format="hh:mm" value="<?=date("H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker1Container" name="time" value="<?=date("H:i")?>"/>
				  </div>
			</div>
			<div class="span2">
				<h4>Länge der Entleihe</h4>
				<select name="return" class="span12">
				<?php for($i = 15; $i<=40; $i+=5): ?>
					<option value="<?=$i?>"><?=$i?> Minuten</option>
				<?php endfor; ?>
				</select>
			</div>
			<div class="span3">
				<h4>Startstation</h4>
				<select name="sstation" class="span12" <?=(isset($_REQUEST['sstation'])?'disabled':'')?>>
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'"'.
						($_REQUEST['sstation'] == $st['ID']?' selected':'').'>'.$st['title'].'</option>'; ?>
				</select>
			</div>
			<div class="span3">
				<h4>Endstation</h4>
				<select name ="estation" class="span12">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'"'.
						($_REQUEST['estation'] == $st['ID']?' selected':'').'>'.$st['title'].'</option>'; ?>	
				</select>
			</div>
			<div class="span2">
				<h4>&nbsp;</h4>
				<? if(isset($_REQUEST['sstation'])): ?>
				<input type="hidden" name="sstation" value="<?=$_REQUEST['sstation']?>" />
				<?php endif; ?>
				<input type="submit" class="btn btn-primary btn-large span12" value="Weiter"/>
			</div>
		</div>
	</form>
</div>

<div class="container-fluid" style="background: #eee;border-radius:10px; padding:20px; margin-bottom: 20px;">
	<form action="advCheckBooking.php" method="POST" class="form-inline" />
		<div class="row-fluid">
			<div class="span12"><h1>Erweiterte Buchungsanfrage</h1></div>
		</div>
		<div class="row-fluid">
			<div class="span2">
				<h4>Startzeit</h4>
				<div id="picker5" class="input-append">
				    <input class="span10" data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker5Container" name="start" value="<?=date("d.m.Y H:i")?>"/>
				  </div>
			</div>
			<div class="span2">
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
			<div class="span3">
				<h4>Startstation</h4>
				<select name ="startstation" class="span12">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'">'.$st['title'].'</option>'; ?>	
				</select>
			</div>
			<div class="span3">
				<h4>Endstation</h4>
				<select name ="endstation" class="span12">
				<?php foreach($stations as $st)
				echo 	'<option value="'.$st['ID'].'">'.$st['title'].'</option>'; ?>	
				</select>
			</div>
			<div class="span2">
				<h4>&nbsp;</h4>
				<input type="submit" class="btn btn-primary btn-large span12" value="Weiter"/>
			</div>
		</div>
	</form>
</div>
<?php else: header('location: index.php'); endif; ?>