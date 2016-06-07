<?php
require("lib/_init.php");
if(Rights::hasRight("overview")):
require(LIVECTRLW."Overview.class.php");

$hidden = true;
if(!empty($_GET['uid']) && $_REQUEST['do'] == 'show') {
	$_reserve = Overview::getReservations($_GET['uid']);
	echo "<h2>Kunde: ".User::load($_GET['uid'])->getName()."</h2>";
} elseif(!empty($_GET['rid']) && $_REQUEST['do'] == 'detail') {
	$_reserve = Overview::getReservation($_GET['rid']);
	$hidden = false;
} else $_reserve = Overview::getReservations();
?>
<h3>Verlauf</h3>
<div class="container">
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr><th colspan="11"><u>Anfragen / Buchungen</u></th></tr>
			<tr>
				<th></th>
				<th>Anfrage</th>
				<th>Kunde</th>
				<th>Entleihe</th>
				<th>Erstellt am</th>
				<th>Erstellt von</th>
				<th>Startzeit</th>
				<th>Endzeit</th>
				<th>Startstation</th>
				<th>Endstation</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($_reserve as $reserve): ?>
			<tr  <?=($reserve->getBooking()?'style="cursor: help"':'')?>
			data-toggle="<?=$reserve->getId()?>" class="toggletrigger <?=($reserve->validate()?'': 'error ').
							($reserve->getBooking()?
($reserve->getBooking()->validate()&&
		$reserve->getBooking()->validAccess()?'': 'error '):'')?>">
			<td><?=($reserve->getBooking()?"<i id='icon".$reserve->getId()."' class='icon-plus'></i>":'')?></td>
				<td><?=$reserve->getId()?></td>
				<td><?=$reserve->getUser()->getHtml()?></td>
				<td><?=($reserve->getBooking()?$reserve->getBooking()->getId():'-')?></td>
				<td><?=date("d.m.Y - H:i",strtotime($reserve->getCreated()))?></td>
				<td><?=$reserve->getCreator()->getHtml()?></td>
				<td><?=date("d.m.Y - H:i",strtotime($reserve->getStartTime()))?></td>
				<td><?=date("d.m.Y - H:i",strtotime($reserve->getEndTime()))?></td>
				<td><?=$reserve->getStart()->getTitle()?></td>
				<td><?=$reserve->getEnd()->getTitle()?></td>
				<td><?=$reserve->statusToString2($reserve->getStatus())?>
				
				<?=($reserve->getStatus()=='canceled'?' ('.date("d.m.Y - H:i",strtotime($reserve->getCanceled())).')':'')?>
				<?=($reserve->getStatus()=='forcedtocancel'?' 
						(durch <a href="_overview.php?do=detail&rid='.$reserve->getForcedToCancel()->getReservation()->getId().'">Buchung #'.$reserve->getForcedToCancel()->getReservation()->getId().'</a> von '.$reserve->getForcedToCancel()->getUser()->getHtml().')':'')?></td>
			</tr>
			<?php if($book = $reserve->getBooking()):?>
			<tr data-toggle="<?=$reserve->getId()?>" class="toggle" style="background: #333">
			<td style="background: #fff;"></td><td colspan="10">
				
				<div class="well">
					<h4>Entleihe</h4>
					<div class="row-fluid">
						<div class="span2"><b>Pedelec</b></div>
						<div class="span4"><?=$book->getBike()->getName()?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Kunde</b></div>
						<div class="span4"><?=$book->getUser()->getHtml()?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Startstation</b></div>
						<div class="span4"><?=$book->getStart()->getTitle()?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Startzeit</b></div>
						<div class="span4"><?=date("d.m.Y - H:i",strtotime($book->getTStart()))?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Mitarbeiter Entleihe</b></div>
						<div class="span4"><?=$book->getSService()->getHtml()?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Endstation</b></div>
						<div class="span4"><?=($book->getEnd()?$book->getEnd()->getTitle():'noch entliehen')?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Endzeit</b></div>
						<div class="span4"><?=($book->getTEnd()?date("d.m.Y - H:i",strtotime($book->getTEnd())):'noch entliehen')?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Mitarbeiter Rückgabe</b></div>
						<div class="span4"><?=($book->getEService()?$book->getEService()->getHtml():'noch entliehen')?></div>
					</div>
					<div class="row-fluid">
						<div class="span2"><b>Anmerkung</b></div>
						<div class="span4"><p class="<?=!$book->validate()?'text-error':''?>"><?=$book->statement()?></div>
					</div>
					
					
				</div>
				
	
		<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr><th colspan="10"><u>Entliehenes Zubehör</u></th></tr>
			<tr>
				<th>Zurückgegeben</th>
				<th>zID</th>
				<th>Bezeichnung</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<?php foreach($book->getAccess() as $access): ?>
			<tr class="<?=($book->gotLost($access)?'error': '')?>">
				<td><?=$book->getEnd()?($book->gotLost($access)?'Nicht zurückgegeben': 'zurückgegeben'):'noch entliehen'?></td>
				<td><?=$access->getId()?></td>
				<td><?=$access->getTitle()?></td>
				<td><?=($access->getA1Title()?$access->getA1Title().": ".$access->getAttr1():"")?></td>
				<td><?=($access->getA2Title()?$access->getA2Title().": ".$access->getAttr2():"")?></td>
				<td><?=($access->getA3Title()?$access->getA3Title().": ".$access->getAttr3():"")?></td>
				<td><?=($access->getA4Title()?$access->getA4Title().": ".$access->getAttr4():"")?></td>
				<td><?=($access->getA5Title()?$access->getA5Title().": ".$access->getAttr5():"")?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr><th colspan="10"><u>Kommentare</u></th></tr>
			<tr>
				<th>Zeitpunkt</th>
				<th>Typ</th>
				<th>Mitarbeiter</th>
				<th>Kunde</th>
				<th>Restreichweite</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($book->getReports() as $report): ?>
		<tr class="<?=($report->validate()?'': 'error ')?><?=($report->getSubject() == 'canceled'?'info':'')?>">
			<td><?=date("H:i d.m.Y",strtotime($report->getTime()))?></td>
			<td><?=Report::subToString($report->getSubject())?></td>
			<td><?=($report->getService()?$report->getService()->getHtml(): '-')?></td>
			<td><?=($report->getUser()?$report->getUser()->getHtml(): '-')?></td>
			<td><?=($report->getBattery() > 0?$report->getBattery()."km": '-')?></td>
			<td><?=($report->getStatus()?Bike::statusToString($report->getStatus()): '-')?></td>
			<td><a href="#" class="btn <?=($report->getCom()?'btn-primary':'')?>" data-toggle="popover" data-placement="left" title="Kommentar/Beschreibung"
			data-content="<?=($report->getCom()?htmlspecialchars($report->getCom()): '-')?>">Kommentar</a></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
				
			</td></tr>
			<?php endif; ?>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php if(!$hidden): ?>
<script>$('.toggle').removeClass('toggle'); $('i.icon-plus').addClass('icon-minus');</script>
<?php endif;endif; ?>