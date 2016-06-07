<?php
require("lib/_init.php");
if(Rights::hasRight("accessories")):
include(LIVECTRLW.	"Access.class.php");


if($_POST['do'] == 'editCat') {
	Access::editCat(	$_POST['cid'],
	$_POST['title'],
	$_POST['attr1'],
	$_POST['attr2'],
	$_POST['attr3'],
	$_POST['attr4'],
	$_POST['attr5']
	);
	header("location: _accessories.php");
}

if($_POST['do'] == 'editAccess') {
	Access::editAccess(	$_POST['title'],
						$_POST['id'],
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

if($_GET['edit'] == 'cat'):
$cat = Accessorie::getCat($_GET['cid']);
?>

<div class="containter">
	<div class="well well-small">
	<form action="./_editAccess.php" method="post" >
	<input type="hidden" name="do" value="editCat" />
	<input type="hidden" name="cid" value="<?=$cat['ID']?>" />
	<div class="row-fluid">
		<h3>Kategorie bearbeiten</h3>
	</div>
	<div class="row-fluid">
		<div class="span5">
			<h4>Bezeichnung</h4>
			<input type="text" class="span12" name="title" value="<?=$cat['title']?>" />
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
			<input type="text" class="span12" name="attr1" value="<?=$cat['attr1']?>"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.2</h4>
			<input type="text" class="span12" name="attr2" value="<?=$cat['attr2']?>"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.3</h4>
			<input type="text" class="span12" name="attr3" value="<?=$cat['attr3']?>"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.4</h4>
			<input type="text" class="span12" name="attr4" value="<?=$cat['attr4']?>"  />
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Bezeichnung Attribut Nr.5</h4>
			<input type="text" class="span12" name="attr5" value="<?=$cat['attr5']?>"  />
		</div>
	</div>
	<div class="row-fluid">
	<input type="submit" class="btn" value="speichern" />
	</div>
	</form>
	</div>
</div>
<?php endif; ?>

<?php if($_GET['edit'] == 'access'): 
$acc = Accessorie::load($_GET['id']);
?>
<div class="container">
	<div class="well well-small">
	<form action="_editAccess.php" method="post" >
	<input type="hidden" name="do" value="editAccess" />
	<input type="hidden" name="id" value="<?=$acc->getId()?>" />
	<div class="row-fluid">
		<h3>Zubehör Bearbeiten</h3>
	</div>
	<div class="row-fluid">
		<div class="span3">
			<h4>Kategorie</h4>
			<?php $cat = $acc->getCategory();?>
			<select disabled>
			<option value=""><?=$cat['title']?></option>
			</select>
			<input type="hidden" name="cat" value="<?=$cat['ID']?>" />
		</div>
		<div class="span3">
		<h4>Station</h4>
		<select name="station">
			<?php foreach(Station::getAll() as $s): ?>
			<option value="<?=$s->getId()?>" <?=$acc->getStation()->getId() == $s->getId()?'selected':''?>><?=$s->getTitle()?></option>
			<?php endforeach; ?>
		</select>
		</div>
		<div class="span3">
		<h4>An Pedelec binden</h4>
		<select name="bike">
			<option value="null">Kein Pedelec</option>
			<?php foreach(Access::bikes() as $s): ?>
			<option value="<?=$s->getId()?>" <?=$acc->getBike()== null?'':$acc->getBike()->getId() == $s->getId()?'selected':''?>><?=$s->getId()?> - <?=$s->getType()?></option>
			<?php endforeach; ?>
		</select>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5">
			<h4>Bezeichnung</h4>
			<input type="text" class="span12" name="title" value="<?=$acc->getTitle()?>" />
		</div>
	</div>
	<?php if($cat['attr1'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr1']?></h4>
			<input type="text" class="span12" name="attr1" value="<?=$acc->getAttr1()?>"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr2'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr2']?></h4>
			<input type="text" class="span12" name="attr2" value="<?=$acc->getAttr2()?>"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr3'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr3']?></h4>
			<input type="text" class="span12" name="attr3" value="<?=$acc->getAttr3()?>"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr4'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr4']?></h4>
			<input type="text" class="span12" name="attr4" value="<?=$acc->getAttr4()?>"  />
		</div>
	</div>
	<?php endif; ?>
	<?php if($cat['attr5'] !== null): ?>
	<div class="row-fluid">
		<div class="span4">
			<h4><?=$cat['attr5']?></h4>
			<input type="text" class="span12" name="attr5" value="<?=$acc->getAttr5()?>"  />
		</div>
	</div>
	<?php endif; ?>
	<div class="row-fluid">
	<input type="submit" class="btn" value="bearbeiten"/>
	</div>
	</form>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>