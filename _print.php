<?php
define("CRONJOB", true);
require("lib/_init.php");
if(Rights::hasRight('customers')):
$user = User::load($_GET['uid']);

?>
<html lang="de">
<head>
	<title><?=Preferences::value("pageTitle")?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style>
td {
	font: 16px Arial;
	line-height: 25px;
}

td.line {
	border-bottom: #000 2px solid;
	width: 59%;
}

td.field {
	width: 40%;
	text-align: right;
	padding-right: 10px;
}

td.space {
	height: 16px;
}

#body {
	max-width: 612px;
	position: absolute;
	left: 50%;
	margin-left: -306px;
	margin-top: 20px;
}

#form {
	width: 100%;
}

h1 {
	font-size: 20px;
	margin-top: 20px;
}

.chkbox {
	font-size: 13px;
	
}

.note {
	background: #000;
	min-height: 2px;
	max-height: 2px;
	width: 180px;
}

.footer {
	text-align: right;
	font-size: 13px;
	line-height: 13px;
}

.footer p {
	margin: 2px;
}
</style>

<div id="body">

<div class="header">
	<img src="<?=TEMPLATE?>head.jpg" alt="PaVeR" />
</div>

<h1>Anmeldeformular</h1>
<table id="form">
<tr><td class="field">Name</td><td class="line"><?=$user->getName()?></td></tr>
<tr><td class="field">Vorname</td><td class="line"><?=$user->getSurName()?></td></tr>
<tr><td class="field">Geburtsdatum</td><td class="line"><?=$user->getBirth()->format("d.m.Y")?></td></tr>
<tr><td class="space" colspan="2"></td></tr>
<tr><td class="field">E-Mail Adresse</td><td class="line"><?=$user->getMail()?></td></tr>
<tr><td class="field">Telefonnummer / Mobiltelefon</td><td class="line"><?=$user->getPhone()?></td></tr>
<tr><td class="space" colspan="2"></td></tr>
<tr><td class="field">Stra&szlig;e, Nr.</td><td class="line"><?=$user->getStreet()?></td></tr>
<tr><td class="field">PLZ, Wohnort</td><td class="line"><?=$user->getZip()?>, <?=$user->getHome()?></td></tr>
<tr><td class="space" colspan="2"></td></tr>
<tr><td class="field">Matrikelnummer<sup>1</sup></td><td class="line"><?=$user->getMatrikel()?></td></tr>
<tr><td class="field">Studiengang<sup>1</sup></td><td class="line"><?=$user->getMajor()?></td></tr>

<tr><td class="space" colspan="2"></td></tr>
<tr><td class="space" colspan="2"></td></tr>
<tr><td class="space" colspan="2"></td></tr>

<tr><td class="field">Datum, Ort</td><td class="line"><?=date("d.m.Y")?></td></tr>
<tr><td class="field">Unterschrift</td><td class="line">&#8998;</td></tr>
<tr><td></td><td class="chkbox">
	Ich habe die Allgemeinen Geschäfts- und Nutzungsbedigungen gelesen und erkläre mich mit diesen einverstanden.
	
	</td></tr>

	
<tr><td class="space" colspan="2"></td></tr>
<tr><td class="space" colspan="2"></td></tr>

<tr><td class="space" colspan="2"></td></tr>
<tr><td colspan="2">
<div class="note"></div>
<small><sup>1</sup> Nur für Studenten der Universität Paderborn</small>
</td></tr>

<tr><td class="space" colspan="2"></td></tr>

<tr><td></td><td class="footer">
	<p>Forschungsprojekt des Lehrstuhls Wirtschaftsinformatik 1</p>
	<p>Telefon: (0 52 51) 60 32 56</p>
</td></tr>
<tr><td class="space" colspan="2"></td></tr>
<tr><td class="space" colspan="2"></td></tr>
</table>


</div>

</html>
<?php endif; ?>
