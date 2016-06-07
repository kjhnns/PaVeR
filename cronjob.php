<?php
define("CRONJOB", true);
require_once("./lib/_init.php");

require(LIVECTRL.'Reminder.class.php');

Cronjob::jobs();
?>