<?php
require("lib/_init.php");
if(!Rights::customer()) exit;
?>
<h1>Anfrage gespeichert</h1>
<div class="well">Buchungsanfrage wurde gespeichert. Wird geprüft...<br/><br/>
<a class="btn btn-primary" href="myBookings.php">Meine Anfrage</a>
</div>