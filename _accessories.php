<?php
require("lib/_init.php");
if(Rights::hasRight("accessories")):
include(LIVECTRLW.	"Access.class.php");

if($_POST['do'] == 'addCat') {
	Access::addCat(	$_POST['title'],
					$_POST['limit'],
					$_POST['attr1'],
					$_POST['attr2'],
					$_POST['attr3'],
					$_POST['attr4'],
					$_POST['attr5']
	);
	header("location: _accessories.php");
}

if($_GET['do'] == 'delCat') {
	if(Access::delCat($_GET['cid'])): ?>
	<div class="alert"><b>Erfolg!</b> Kategorie erfolgreich gelöscht!</div>
	<?php else: ?>
	<div class="alert"><b>Warnung!</b> Kategorie konnte nicht gelöscht werden. 
	Bitte entfernen Sie zunächst jegliches Zubehör</div>
	<?php endif;
}

if($_GET['do'] == 'delA') {
	if(Access::delAccess($_GET['id'])): ?>
	<div class="alert"><b>Erfolg!</b> Kategorie erfolgreich gelöscht!</div>
	<?php else: ?>
	<div class="alert"><b>Warnung!</b> Kategorie konnte nicht gelöscht werden. 
	Bitte entfernen Sie zunächst jegliches Zubehör</div>
	<?php endif;
}

if($_POST['do'] == 'addAccess') {
	Access::addAccess(	$_POST['title'],
						$_POST['cat'],
						$_POST['bike'] == 'null' ? null: $_POST['bike'],
						$_POST['station'],
						empty($_POST['attr1'])? null: $_POST['attr1'],
						empty($_POST['attr2'])? null: $_POST['attr2'],
						empty($_POST['attr3'])? null: $_POST['attr3'],
						empty($_POST['attr4'])? null: $_POST['attr4'],
						empty($_POST['attr5'])? null: $_POST['attr5']
						);
	header("location: _accessories.php");
}


try {
?>
<h1>Zubehör</h1>

<div class="tabbable tabs-top">
<ul class="nav nav-tabs">
<li <?=(empty($_GET['cat'])?'class="active"':'')?>><a href="#cato" data-toggle="tab">Zubehör</a></li>
<li <?=(!empty($_GET['cat'])?'class="active"':'')?>><a href="#access" data-toggle="tab">Zubehör erstellen</a></li>
<li><a href="#cat" data-toggle="tab">Kategorie erstellen</a></li>
</ul>
</div>

<div class="tab-content">


<div class="tab-pane <?=(!empty($_GET['cat'])?'active':'')?>" id="access">
	<div class="well well-small">
	<form action="_accessories.php" method="post" >
	<input type="hidden" name="do" value="addAccess" />
	<div class="row-fluid">
		<h3>Zubehör hinzufügen</h3>
	</div>
	<script>
	function changeAccessCat() {
		location.href="_accessories.php?cat="+ $('#accessCat').val();
	}
	</script>
	<div class="row-fluid">
		<div class="span3">
			<h4>Kategorie</h4>
			<?php if(empty($_GET['cat'])): ?>
			<select name="cat" id="accessCat" onchange="changeAccessCat()">
				<option value="">bitte auswählen</option>
				<?php foreach(Access::getCats() as $item): ?>
					<option value="<?=$item['ID']?>"><?=$item['title']?></option>
				<?php endforeach; ?>
			</select>
			<?php else: ?>
			<?php $cat = Accessorie::getCat($_GET['cat']);?>
			<select disabled>
			<option value=""><?=$cat['title']?></option>
			</select>
			<a class="btn btn-small" href="_accessories.php">zurücksetzen</a>
			<input type="hidden" name="cat" value="<?=$cat['ID']?>" />
			<?php endif; ?>
		</div>
		<div class="span3">
		<h4>Station</h4>
		<select name="station" <?=(empty($_GET['cat'])?'disabled':'')?>>
			<?php foreach(Station::getAll() as $s): ?>
			<option value="<?=$s->getId()?>"><?=$s->getTitle()?></option>
			<?php endforeach; ?>
		</select>
		</div>
		<div class="span3">
		<h4>An Pedelec binden</h4>
		<select name="bike" <?=(empty($_GET['cat'])?'disabled':'')?>>
			<option value="null">Kein Pedelec</option>
			<?php foreach(Access::bikes() as $s): ?>
			<option value="<?=$s->getId()?>"><?=$s->getId()?> - <?=$s->getType()?></option>
			<?php endforeach; ?>
		</select>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5">
			<h4>Bezeichnung</h4>
			<input type="text" class="span12" name="title"  <?=(empty($_GET['cat'])?'disabled':'')?>/>
		</div>
	</div>
	<?php if(!empty($_GET['cat'])): ?>
	<?php if($cat['attr1'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr1']?></h4>
			<input type="text" class="span12" name="attr1"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr2'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr2']?></h4>
			<input type="text" class="span12" name="attr2"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr3'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr3']?></h4>
			<input type="text" class="span12" name="attr3"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr4'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr4']?></h4>
			<input type="text" class="span12" name="attr4"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr5'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr5']?></h4>
			<input type="text" class="span12" name="attr5"  />
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
	<div class="row-fluid">
	<input type="submit" class="btn" value="hinzufügen" <?=(empty($_GET['cat'])?'disabled':'')?>/>
	</div>
	</form>
	</div>
</div>

<div class="tab-pane" id="cat">
	<div class="well well-small">
	<form action="_accessories.php" method="post" >
	<input type="hidden" name="do" value="addCat" />
	<div class="row-fluid">
		<h3>Kategorie hinzufügen</h3>
	</div>
	<div class="row-fluid">
		<div class="span5">
			<h4>Bezeichnung</h4>
			<input type="text" class="span12" name="title"  />
		</div>
		<!-- <div class="span3">
			<h4 data-toggle="tooltip" title="Wie viele können ausgeliehen werden?">Anzahl pro Entleihe</h4>
			<input class="span4" type="text" name="limit" value="1" />
		</div> -->
		<input class="span4" type="hidden" name="limit" value="1" />
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4 data-toggle="tooltip" title="z.B. Helmgröße">Bezeichnung Attribut Nr.1</h4>
			<input type="text" class="span12" name="attr1"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.2</h4>
			<input type="text" class="span12" name="attr2"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.3</h4>
			<input type="text" class="span12" name="attr3"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.4</h4>
			<input type="text" class="span12" name="attr4"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.5</h4>
			<input type="text" class="span12" name="attr5"  />
		</div>
	</div>
	<div class="row-fluid">
	<input type="submit" class="btn" value="hinzufügen" />
	</div>
	</form>
	</div>
</div>

<div class="tab-pane  <?=(empty($_GET['cat'])?'active':'')?>" id="cato">
	<h3>Kategorien</h3>
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th style="width: 10px"></th>
				<th>Bezeichnung</th>
				<th>Attribut Nr.1</th>
				<th>Attribut Nr.2</th>
				<th>Attribut Nr.3</th>
				<th>Attribut Nr.4</th>
				<th>Attribut Nr.5</th>
				<th></th>
			</tr>
		</thead>

		<?php foreach(Access::getCats() as $item): ?>
		<tr data-toggle="<?=$item['ID']?>" style="cursor: help;" class="toggletrigger">
			<td><i id='icon<?=$item['ID']?>' class='icon-plus'></i></td>
			<td><?=$item['title']?></td>
			<!-- <td><?=$item['limit']?></td> -->
			<td><?=empty($item['attr1'])?'-':$item['attr1']?></td>
			<td><?=empty($item['attr2'])?'-':$item['attr2']?></td>
			<td><?=empty($item['attr3'])?'-':$item['attr3']?></td>
			<td><?=empty($item['attr4'])?'-':$item['attr4']?></td>
			<td><?=empty($item['attr5'])?'-':$item['attr5']?></td>
			<td>
			<a data-toggle="tooltip" title="Bearbeiten" href="_editAccess.php?edit=cat&cid=<?=$item['ID']?>"><i class="icon-edit"></i></a>
			<a data-toggle="tooltip" onclick="return confirm('Wirklich löschen?')"  title="Löschen" href="_accessories.php?do=delCat&cid=<?=$item['ID']?>"><i class="icon-trash"></i></a>
			
			</td>
		</tr>
		<tr  data-toggle="<?=$item['ID']?>" class="toggle" style="background: #333">
			<td style="background: #fff;"></td><td colspan="8">
		
		<table class="table table-bordered">
					<thead style="background: #eee;">
					<tr><th colspan="10"><u>Zubehör</u></th></tr>
						<tr>
							<th>zID</th>
							<th>Bezeichnung</th>
							<th>Station</th>
							<th>Exklusiv für Pedelec</th>
							<?=empty($item['attr1'])?'':'<th>'.$item['attr1'].'</th>'?>
							<?=empty($item['attr2'])?'':'<th>'.$item['attr2'].'</th>'?>
							<?=empty($item['attr3'])?'':'<th>'.$item['attr3'].'</th>'?>
							<?=empty($item['attr4'])?'':'<th>'.$item['attr4'].'</th>'?>
							<?=empty($item['attr5'])?'':'<th>'.$item['attr5'].'</th>'?>
							<th>Verfügbar</th>
							<th></th>
						</tr>
					</thead>
		<?php foreach(Access::getAccess($item['ID']) as $access): ?>
		<tr>
			<td><?=$access->getId()?></td>
			<td><?=$access->getTitle()?></td>
			<td><?=($access->getBooking()?"entliehen an ".$access->getBooking()->getUser()->getHtml(): 
									$access->getStation()->getTitle())?></td>
			<td><?php if($access->getBike()):?>
			<?=$access->getBike()->getName()?>
			<?php else: ?>Keine Bindung<?php endif; ?></td>
			<?=empty($item['attr1'])?'':'<td>'.$access->getAttr1().'</td>'?>
			<?=empty($item['attr2'])?'':'<td>'.$access->getAttr2().'</td>'?>
			<?=empty($item['attr3'])?'':'<td>'.$access->getAttr3().'</td>'?>
			<?=empty($item['attr4'])?'':'<td>'.$access->getAttr4().'</td>'?>
			<?=empty($item['attr5'])?'':'<td>'.$access->getAttr5().'</td>'?>
			<td><?=($access->isAvail()?'Verfügbar':'nicht verfügbar, '.$access->getBrokeBooking()->getHtml())?></td>
			<td>
			<a data-toggle="tooltip" title="Bearbeiten" href="_editAccess.php?edit=access&id=<?=$access->getId()?>"><i class="icon-edit"></i></a>
			<a data-toggle="tooltip" onclick="return confirm('Wirklich löschen?')" title="Löschen" href="_accessories.php?do=delA&id=<?=$access->getId()?>"><i class="icon-trash"></i></a></td>
		</tr>
		<?php endforeach; ?>
		</table>
		
		</td></tr>
		<?php endforeach; ?>
	</table>
</div>

</div>


<?php
}catch(Exception $e) {
	echo $e->getMessage()."<br>";
	echo nl2br($e->getTraceAsString())."<br>";
}

else: echo "Berechtigung fehlt!"; endif;
?>