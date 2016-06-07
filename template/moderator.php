<?php
function _shutdown() {
	echo '</div>
	<script type="text/javascript" src="./template/3rd/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./template/3rd/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="./template/client.js"></script>
	<iframe frameborder="0" scrolling="no" src="./cronjob.php"></iframe>
	</body></html>';
	
	
	// debug
	if(DEBUG) {
		function debugSession() {
			foreach($_SESSION as $k => $v) {
				$r.= $k;
				if(gettype($v) == 'object') {
					$r.= ",";
						
				}
				$r.= "<br>";
			}
			return $r;
		}
		
		if($GLOBALS['_DEBUG']) foreach($GLOBALS['_DEBUG'] as $dbg) $debuglog.=$dbg."<br>";
		echo 	'<div id="debugConsole">qrys: '.
				$GLOBALS['_GLOBAL_QRYS'].'<br>'.
				'bench: '.(_microTime()-BENCHSTART).'ms<br/><br/><b>Session</b><br>'.
				debugSession()."<br/>".
				'<b>Memory</b><br>peak: '.intval(memory_get_peak_usage()/1024)."kb<br/>".
				'diff: '.intval((memory_get_peak_usage()-MEMORYSTART)/1024)."kb<br/><br/>".
				"<b>debug log</b><br>".
				$debuglog."<br>".
				'</div>';
	}
}

$sections = array(	
		"pedelecs" 		=> 	array("url" => "_bikes.php", "title" => "Pedelecs"),
		"accessories"	=>	array("url" => "_accessories.php", "title" => "Zubehör"),
		"worker"		=>	array("url" => "_worker.php", "title" => "Mitarbeiter"),
		"customers"		=>	array("url" => "_users.php", "title" => "Kunden")
);

$sections_access = false;
foreach($sections as $k => $v) 
$sections_access = Rights::hasRight($k)?true:$sections_access;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=Preferences::value("pageTitle")?> Service Oberfläche</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<link rel="icon" type="image/png" href="./template/favicon.png" />
	<link rel="apple-touch-icon" href="./template/touch-icon.png" />
    <link href="./template/style.css" rel="stylesheet">
    <link href="./template/3rd/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./template/3rd/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="./template/3rd/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<script type="text/javascript" src="./template/3rd/jquery-1.8.3.min.js"></script>
    
</head>
<body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand"><?=Preferences::value("pageTitle")?> Service</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
           	  <?php if(Rights::hasRight('moderate')): ?>	
              <li><a href="./stationService.php">Stations-Überblick</a></li>
              <?php endif; ?>
              
           	  <?php if(Rights::hasRight('overview')): ?>	
              <li><a href="./_overview.php">Verlauf</a></li>
              <?php endif; ?>
              
              <li><a href="./calendar.php">Öffnungszeiten</a></li>
              
              <!-- CORE DATA -->
              <?php if($sections_access): ?>
              <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Stamm-/Prozesstypdaten <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <?php foreach($sections as $sec => $dat): if(Rights::hasRight($sec)): ?>
							<li><a tabindex="-1" href="./<?=$dat['url']?>"><?=$dat['title']?></a></li>
						<?php endif; endforeach;?>
                        </ul>
              </li>
              <?php endif; ?>
			  <!-- END -->
			  
              <?php if(	Rights::hasRight("prefAllg") ||
              			Rights::hasRight("prefMail") ||
              			Rights::hasRight("prefExc")): ?>
              <li><a href="./_preferences.php">Einstellungen</a></li>
              <?php endif; ?>
              
              <li><a href="./settings.php">Mein Konto</a></li>
              <li><a href="./stationService.php?logout">Abmelden</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="main">
	<?php if(Rights::missin()):?>
	<h1>Sie haben nicht die nötige Berechtigung</h1>
	<?php exit; endif; ?>
    