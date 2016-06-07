<?php
require("lib/_init.php");
if(LOGIN):

$year = empty($_GET['y'])?date("Y"):$_GET['y'];

$tabs = Station::getAll();
try {
$_station = Station::load((int)$_GET['station']);
} catch(Exception $e) { $_station = $tabs[0]; }



$cal = new Calendar($_GET['y']); $c = 0;
?>

<?php if(Rights::hasRight("calendar")): ?>
<a href="_calEdit.php" class="btn btn-primary btn-large">Öffnungszeiten bearbeiten</a><br/><br/>
<?php endif;?>

<div class="tabbable tabs-top">
<ul class="nav nav-tabs ">
<?php $f = true; foreach($tabs as $tab): ?>
    <li <?=($_station->getId()==$tab->getId()?'class="active"':'')?>><a href="?station=<?=$tab->getId()?>"><?=$tab->getTitle()?></a></li>
<?php $f = false; endforeach; ?>
</ul>
</div>
	
<h1>Öffnungszeiten für die <span class="text-info">Station <?=$_station->getTitle()?></span> <small>im Jahr <?=$cal->getYear()?></small></h1>
<ul class="pager">
  <li class="previous <?=($_GET['y']=='2012'?'disabled':'')?>">
    <a class="btn" href="?station=<?=$_station->getId()?>&y=<?=($_GET['y']=='2012'?'2012':$cal->getYear()-1)?>">zurück</a>
  </li>
  <li class="next">
    <a class="btn" href="?station=<?=$_station->getId()?>&y=<?=($cal->getYear()+1)?>">vor</a>
  </li>
</ul>
<div class="row-fluid">
<?php foreach($cal->getMatrix() as $month => $mon_matrix): $c++; ?>
<div class="span3">
<table class="table table-bordered">
	<thead style="background: #eee;">
		<tr>
		<th colspan="7"><?=Calendar::month($month)?></th>
		</tr>	
		<tr>
			<th>Mo</th>
			<th>Di</th>
			<th>Mi</th>
			<th>Do</th>
			<th>Fr</th>
			<th>Sa</th>
			<th>So</th>
		</tr>
					
	</thead>
	<tbody>
	<?php foreach($mon_matrix as $row => $week_days): ?>
		<tr>
		<?php for($i = 1; $i <= 7; $i++): 
			$day = $cal->getYear()."-".$month."-".$week_days[$i];
			
			$frames = Service::frames($_station, $day); 
			if($week_days[$i]):
			?>
			
			<?php if(Calendar::today($day) && Service::checkDay($day, $_station)): ?>
			<td style="background: #3a87ad;">
			<?php elseif( Service::checkDay($day, $_station)):?>
			<td style="background: #c09853;">
			<?php elseif(Calendar::today($day)):?>
			<td style="background: #3a87ad;">
			<?php else: ?>
			<td>
			<?php endif; ?>
			<? if(Service::checkDay($day, $_station)): ?>
				<span data-toggle="popover" 
				title="Geöffnet"
				data-content="
				<?php foreach($frames as $frame): 
				echo "von ".$frame['s']->format("H:i")."<br/>".
				"bis ".$frame['e']->format("H:i")."<br/><br/>";
				endforeach; ?>">
				<?=$week_days[$i]?></span>
				<?php else: ?>
				<?=$week_days[$i]?>
			<?php endif; ?>
			</td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
		<?php endfor; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div>

<?php if ($c % 4 == 0 && $c != 12): ?>
</div>
<div class="row-fluid">
<?php endif; ?>

<?php endforeach; ?>
</div>
<?php endif; ?>