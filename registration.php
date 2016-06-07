<?php 
define("GUEST", true);
require("./lib/_init.php");


if($_POST['do'] == '1'):
	$bday = new DateTime($_POST['data']['birth']);
	$now = new DateTime();
	$now->modify("-16 years");
	if(mailCheck($_POST['data']['mail']) && $bday < $now) {
		Session::set("register", $_POST['data']);
	}
	else echo "ERRR";

	
?>
<div class="container-fluid">
<div class="row-fluid"><h1>Allgemeine Geschäftsbedingungen</h1></div>
<div class="row-fluid">
	<div class="span12" style="overflow: scroll; height: 400px; border: #333 1px solid;
							   border-radius: 5px; padding: 10px; background: #eee;">
		<?=Agb::text()?>
	</div>
</div>
<div class="row-fluid"><canvas class="span12" style="border: #333 1px solid;"></canvas></div>
<div class="row-fluid"></div>

</div>
<?php else: ?>
<div class="container-fluid">
<div class="hero-unit">
<h1>Registrierung</h1>
<p>Bitte füllen Sie das folgende Formular vollständig aus. Pflichtfelder sind mit einem * gekennzeichnet.</p>
</div>
<form action="./registration.php" method="post">
	<table class="table table-bordered">
	<tr><td>Telefonnummer</td><td colspan="2"><input class="span6" type="text" name="data[phone]" /></td></tr>
	<tr><td>Matrikel Nummer*</td><td><input class="span6" type="text" name="data[matrikel]" /></td></tr>
	<tr><td>Name*</td><td colspan="2"><input class="span6" type="text" name="data[surname]" /></td></tr>
	<tr><td>Vorname*</td><td colspan="2"><input class="span6" type="text" name="data[name]" /></td></tr>
	<tr><td>E-Mail*</td><td colspan="2"><input class="span6" type="text" name="data[mail]" /></td></tr>
	<tr><td>Straße, Nr*</td><td colspan="2"><input class="span6" type="text" name="data[street]" /></td></tr>
	<tr><td>Postleitzahl*</td><td colspan="2"><input class="span6" type="text" name="data[zip]" /></td></tr>
	<tr><td>Wohnort*</td><td colspan="2"><input class="span6" type="text" name="data[home]" /></td></tr>
	<tr><td>Studiengang</td><td colspan="2"><input class="span6" type="text" name="data[major]" /></td></tr>
	<tr><td>Geburtstag</td><td colspan="2">
		<div id="picker2" class="input-append">
				    <input class=" span5"  data-format="dd.MM.yyyy" value="<?=date("d.m.")?>1990" type="text"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
				    <input type="hidden" id="picker2Container" name="data[birth]" value="<?=date("d.m.")?>1990"/>
				  </div>
	</td></tr>
	<tr><td></td><td><input type="submit" class="btn" value="weiter" /></td></tr>
		<input type="hidden" name="do" value="1" />
	</table>	
</form>
</div>
<?php endif; ?>