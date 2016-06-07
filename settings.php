<?php
require_once("./lib/_init.php");
$_ctrl = new Index();

// pw
if($_POST['do'] == 'pw')
	if($r = $_ctrl->changePw($_POST['apw'], $_POST['pw'], $_POST['pww'])):
	?><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Erfolg!</strong> Passwort wurde erfolgreich geändert!
</div><?php
else:
?><div class="alert alert-failure"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Achtung!</strong> Bitte achten Sie darauf, dass ihr Passwort länger als 6 Zeichen ist.
</div><?php
endif;

if($_POST['do'] == 'phone'){
User::load()->changePhone($_POST['phone']);
header("location: settings.php");
}

// email
if($_POST['do'] == 'mail')
if($r = $_ctrl->changeMail($_POST['mail'], $_POST['mailw'])):
?><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Erfolg!</strong> E-Mail wurde erfolgreich geändert!
</div><?php
else:
?><div class="alert alert-failure"><button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Achtung!</strong> Bitte achten Sie darauf, dass ihre E-Mail Adresse valide ist.
</div><?php
endif;
?>

<h1>Mein Konto</h1>
<div class="row-fluid">
<div class="span5">
	<h4>Name</h4>
	<input type="text" value="<?=User::load()->getName()?> <?=User::load()->getSurName()?>" disabled/>
</div>
</div>
<?php if(Rights::customer()): ?>
<div class="row-fluid">
<div class="span5">
	<h4>Matrikel Nummer</h4>
	<input type="text" value="<?=User::load()->getMatrikel()?>" disabled/>
</div>
</div>
<div class="row-fluid">
<div class="span5">
	<h4>Studiengang</h4>
	<input type="text" value="<?=User::load()->getMajor()?>" disabled/>
</div>
</div>
<div class="row-fluid">
<div class="span5">
	<h4>Geburtstag</h4>
	<input type="text" value="<?=User::load()->getBirth()->format("d.m.Y")?>" disabled/>
</div>
</div>
<div class="row-fluid">
<div class="span5">
	<h4>Straße, Nr</h4>
	<input type="text" value="<?=User::load()->getStreet()?>" disabled/>
</div>
</div>
<div class="row-fluid">
<div class="span5">
	<h4>PLZ, Wohnort</h4>
	<input type="text" value="<?=User::load()->getZip()?>, <?=User::load()->getHome()?>" disabled/>
</div>
</div>
<?php endif; ?>
<form action="settings.php" method="post">
<input type="hidden" name="do" value="phone" />
<div class="row-fluid">
<div class="span3">
	<h4>Telefonnummer</h4>
	<input type="text" name="phone" value="<?=User::load()->getPhone()?>"/>
</div>
<div class="span2"><br/><br/><input type="submit" value="ändern" class="btn" /></div>
</div>
</form>



<!--  EINSTELLUNGEN -->
<h1>Passwort ändern</h1>
<form action="settings.php" method="post">
<input type="hidden" name="do" value="pw" />
<div class="row-fluid">
<div class="span3">
	<h4>Aktuelles Passwort</h4>
	<input type="password" name="apw" />
</div>
<div class="span3">
	<h4>Neues Passwort</h4>
	<input type="password" name="pw" />
</div>
<div class="span3">
	<h4>Passwort Wiederholung</h4>
	<input type="password" name="pww" />
</div>
<div class="span2"><br/><br/><input type="submit" value="Passwort ändern" class="btn" /></div>
</div>
</form>

<h1>Email Adresse</h1>
<form action="settings.php" method="post">
<input type="hidden" name="do" value="mail" />
<div class="row-fluid">
<div class="span3">
	<h4>Aktuelle E-Mail Adresse</h4>
	<input type="text" value="<?=User::load()->getMail()?>" disabled/>
</div>
<div class="span3">
	<h4>Neue E-Mail Adresse</h4>
	<input type="text" name="mail" />
</div>
<div class="span3">
	<h4>E-Mail Wiederholung</h4>
	<input type="text" name="mailw" />
</div>
<div class="span2"><br/><br/><input type="submit" value="E-Mail Adresse ändern" class="btn" /></div>
</div>
</form>

