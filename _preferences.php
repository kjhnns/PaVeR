<?php
require("lib/_init.php");
require(LIVECTRLW."PreferencesCtrl.class.php");

if(	PreferencesCtrl::access() ):

if($_POST['do'] == 'save') {
	PreferencesCtrl::save($_POST['f'],$_POST['group']);
	
	header("location: _preferences.php");
}


$tabs = array();
if(Rights::hasRight("prefAllg")) $tabs[1] = "allg";
if(Rights::hasRight("prefMail")) $tabs[2] = "mail";
if(Rights::hasRight("prefExc")) $tabs[4] = "exc";


?>

<div class="tabbable tabs-left">
<ul class="nav nav-tabs span2">
<?php $f = true; foreach($tabs as $n => $tab): ?>
    <li <?=($f?'class="active"':'')?>><a href="#<?=$tab?>" data-toggle="tab"><?=Preferences::grpName($n)?></a></li>
<?php $f = false; endforeach; ?>
</ul>
<div class="tab-content">
	<?php $f = true; foreach($tabs as $n => $tab): ?>
	<div class="tab-pane<?=($f?' active':'')?>" id="<?=$tab?>">
	<form action="_preferences.php" method="post">
	<input type="hidden" name="do" value="save" />
	<input type="hidden" name="group" value="<?=$n?>" />
	<table class="table table-bordered span8">
		<thead style="background: #eee;">
			<tr>
				<th colspan="2"><?=Preferences::grpName($n)?></th>
			</tr>
			<tr>
				<td class="span4">Einstellung</td>
				<td>Wert</td>
			</tr>
		</thead>
		<?php foreach(Preferences::getGroup($n) as $k => $v): ?>
		<tr>
			<th><?=$v['label']?></th>
			<td <?=($v['desc']==null?'':'rowspan="2"')?>>
				<?php if($v['type'] == 'text'): ?>
				<textarea class="span5" style="height: 120px;" name="f[<?=$k?>]"><?=$v['value']?></textarea>
				<?php elseif($v['type'] == 'bool'): ?>
				<input class="span5" type="checkbox" name="f[<?=$k?>]" value="1" <?=($v['value']?'checked':'')?>/>
				<?php elseif($v['type'] == 'int'): ?>
				<input class="span2" type="text" name="f[<?=$k?>]" value="<?=$v['value']?>" />
				<?php else: ?>
				<input class="span5" type="text" name="f[<?=$k?>]" value="<?=$v['value']?>" />
				<?php endif; ?>
			</td>
		</tr>
		<?php if($v['desc']!==null): ?>
		<tr><td><?=$v['desc']?></td></tr>
		<?php endif; ?>
		
		<?php endforeach; ?>
		<tr><td colspan="2"><input type="submit" class="btn btn-primary" value="Speichern" /></td></tr>
	</table>
	</form>
	</div>
	<?php $f = false; endforeach; ?>
</div>
</div>
<?php else: ?>
Keine Berechtigung!
<?php endif; ?>