<?php
require("lib/_init.php");
if(Rights::hasRight("customers")):

require(LIVECTRLW."Customer.class.php");


if($_POST['do'] == 'addUser') {
	try {
	$id = Customer::create($_POST['start'],$_POST['end'],
	$_POST['phone'], $_POST['matrikel'], $_POST['surname'],
	$_POST['name'], $_POST['mail'],
	$_POST['birth'], $_POST['major'], $_POST['street'], $_POST['zip'], $_POST['home']);

	header("location: _print.php?uid=".$id);
	} catch(Exception $e) {
		echo nl2br($e->getTraceAsString());
	}
}

if($_POST['do'] == 'editUser') {
	Customer::edit($_POST['user'], $_POST['start'],$_POST['end'],
	$_POST['phone'],$_POST['matrikel'], $_POST['surname'],
	$_POST['name'], $_POST['mail'],
	$_POST['birth'], $_POST['major'], $_POST['street'], $_POST['zip'], $_POST['home']);
	header("location: _users.php");
}

if($_REQUEST['do'] == 'resetpw') {
	Customer::resetPw($_GET['uid']);
	echo "<div class=\"alert\"><b>Passwort zurückgesetzt!</b> Das Passwort wurde zurückgesetzt. Das neue Passwort wurde an die angegebene E-Mail Adresse geschickt.</div>";
}

?>
<h1>Kunden Übersicht</h1>


<!-- Bike overview -->
<div class="container">
	<table class="table table-bordered">
		<thead style="background: #eee;">
			<tr>
				<th></th>
				<th>Matrikel Nr.</th>
				<th>Name</th>
				<th>Telefonnummer</th>
				<th>E-Mail</th>
				<th>Pedelec</th>
				<th>Gültigkeit</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach(Customer::get() as $user): ?>
		<tr>
			<td class="span1">
				<div class="btn-group dropleft">
				  <a class="btn btn-primary btn-small" data-toggle="dropdown" 
				  href="javascript:$(this).dropdown()">Optionen <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				    <li><a href="_overview.php?do=show&uid=<?=$user->getId()?>">Buchungen und Anfragen</a></li>
				    <li><a href="_users.php?edit=<?=$user->getId()?>" >Konto bearbeiten und Gültigkeit</a></li>
				    <li><a href="_print.php?uid=<?=$user->getId()?>" >Anmeldeformular</a></li>
				    <li><a onclick="return confirm('Passwort zurücksetzen?')" href="_users.php?do=resetpw&uid=<?=$user->getId()?>">Passwort zurücksetzen</a></li>
				  	<li class="divider"></li>
				  	<li>Erstellt von: </li>
				  	<li><?=$user->getCreator()->getHtml()?></li>
				  	<li>Erstellt am: </li>
				  	<li><?=$user->getCreated()->format("H:i d.m.Y")?></li>
				  </ul>
				</div>
			</td>
			<td><?=$user->getMatrikel()?></td>
			<td><?=$user->getSurName()?>, <?=$user->getName()?></td>
			<td><?=$user->getPhone()?></td>
			<td><?=$user->getMail()?></td>
			<td><?=($user->getBike()?$user->getBike()->getId():"-")?></td>
			<td><?=date("d.m.Y H:i", strtotime($user->getStart()))?> - <?=date("d.m.Y H:i", strtotime($user->getEnd()))?></td>
			
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>


<?php if(isset($_GET['edit'])): $u = User::load($_GET['edit']); ?>
<div class="container" id="createBox">
<H3>Kunde bearbeiten</H3>
<form action="./_users.php" method="post">
	<table class="table table-bordered span8">
	<tr><td>Beginn der Gültigkeit:</td><td>
		<div id="picker5" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i", strtotime($u->getStart()))?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker5Container" name="start" value="<?=date("d.m.Y H:i", strtotime($u->getStart()))?>"/>
				  </div>
	</td></tr>
	<tr><td>Ende der Gültigkeit</td><td>
		<div id="picker6" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i", strtotime($u->getEnd()))?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker6Container" name="end" value="<?=date("d.m.Y H:i", strtotime($u->getEnd()))?>"/>
				  </div>
	</td></tr>
	<tr><td>Telefonnummer</td><td><input type="text" name="phone" value="<?=$u->getPhone()?>" /></td></tr>
	<tr><td>Matrikelnummer</td><td><input type="text" name="matrikel" value="<?=$u->getMatrikel()?>" /></td></tr>
	<tr><td>Name</td><td><input type="text" name="surname" value="<?=$u->getSurName()?>" /></td></tr>
	<tr><td>Vorname</td><td><input type="text" name="name" value="<?=$u->getName()?>" /></td></tr>
	<tr><td>E-Mail</td><td><input type="text" name="mail" value="<?=$u->getMail()?>" /></td></tr>
	<tr><td>Straße, Nr</td><td colspan="2"><input type="text" name="street" value="<?=$u->getStreet()?>" /></td></tr>
	<tr><td>Plz</td><td colspan="2"><input type="text" name="zip" value="<?=$u->getZip()?>"/></td></tr>
	<tr><td>Wohnort</td><td colspan="2"><input type="text" name="home" value="<?=$u->getHome()?>" /></td></tr>
	<tr><td>Studiengang</td><td colspan="2"><input type="text" name="major" value="<?=$u->getMajor()?>" /></td></tr>
	<tr><td>Geburtstag</td><td colspan="2">
		<div id="picker2" class="input-append">
				    <input data-format="dd.MM.yyyy" value="<?=$u->getBirth()->format('d.m.Y')?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker2Container" name="birth" value="<?=$u->getBirth()->format('d.m.Y')?>"/>
				  </div>
	</td></tr>
	<td colspan="2"><input type="submit" class="btn" value="Speichern" /></td></tr>
		<input type="hidden" name="do" value="editUser" />
		<input type="hidden" name="user" value="<?=$u->getId()?>" />
	</table>	
</form>
</div>

<?php endif; ?>


<hr/>

<script>
$(function() {
	$('#createToggle').click(function() {
		$('#createBox').toggle();
	});
});
</script>
<p id="createToggle" class="btn" style="cursor: pointer">Kunden erstellen</p><br/><br/>
<div style="display: none;" class="container" id="createBox">
<h3>Kunden erstellen</h3>
<form action="./_users.php" method="post">
	<table class="table table-bordered span8">
	<tr><td>Beginn der Gültigkeit:</td><td colspan="2">
		<div id="picker5" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker5Container" name="start" value="<?=date("d.m.Y H:i")?>"/>
				  </div>
	</td></tr>
	<tr><td>Ende der Gültigkeit</td><td colspan="2">
		<div id="picker6" class="input-append">
				    <input data-format="dd.MM.yyyy hh:mm" value="<?=date("d.m.Y H:i")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker6Container" name="end" value="<?=date("d.m.Y H:i")?>"/>
				  </div>
	</td></tr>
	<tr><td>Telefonnummer</td><td colspan="2"><input type="text" name="phone" /></td></tr>
	<tr><td>Matrikel Nummer</td><td><input type="text" name="matrikel" /></td></tr>
	<tr><td>Name</td><td colspan="2"><input type="text" name="surname" /></td></tr>
	<tr><td>Vorname</td><td colspan="2"><input type="text" name="name" /></td></tr>
	<tr><td>E-Mail</td><td colspan="2"><input type="text" name="mail" /></td></tr>
	<tr><td>Straße, Nr</td><td colspan="2"><input type="text" name="street" /></td></tr>
	<tr><td>Plz</td><td colspan="2"><input type="text" name="zip" /></td></tr>
	<tr><td>Wohnort</td><td colspan="2"><input type="text" name="home" /></td></tr>
	<tr><td>Studiengang</td><td colspan="2"><input type="text" name="major" /></td></tr>
	<tr><td>Geburtstag</td><td colspan="2">
		<div id="picker2" class="input-append">
				    <input data-format="dd.MM.yyyy" value="<?=date("d.m.Y")?>" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker2Container" name="birth" value="<?=date("d.m.Y")?>"/>
				  </div>
	</td></tr>
	<tr><td></td><td><input type="submit" class="btn" value="Speichern" /></td></tr>
		<input type="hidden" name="do" value="addUser" />
	</table>	
</form>
</div>

<?php
else: echo "Keine Berechtigung!"; endif;
?>