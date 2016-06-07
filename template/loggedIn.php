<?php
function _shutdown() {
	echo '</div>
	<script type="text/javascript" src="./template/3rd/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="./template/3rd/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./template/3rd/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="./template/client.js"></script>
	<iframe frameborder="0" class="hidden" scrolling="no" src="./cronjob.php"></iframe>
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
		echo 	'<div style="background: #000; color: #fff;position:absolute;min-height: 400px;'.
				'z-index:-99;padding-bottom: 80px; right: 0px; left:0px; top: 100%;overflow: scroll;">qrys: '.
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
?>
<?php if(!defined("google")): ?><!DOCTYPE html><?php endif; ?>
<html lang="de">
<head>
	<title><?=Preferences::value("pageTitle")?></title>
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
    
</head>
<body>
    
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand"><?=Preferences::value("pageTitle")?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
            	<!-- class="active" missing --> 
              <li ><a href="./index.php">Karte</a></li>
              <li><a href="./myBookings.php">Meine Anfragen</a></li>
              <?php if(User::load()->getBooking()): ?>
              <li><a style="color: #fff;" class="btn-primary" href="./report.php">Meldung</a></li>
              <!-- 
              <?php //else: ?>
              <li><a href="./report.php">Meldung</a></li>
               -->
              <?php endif; ?>
              <li><a href="./settings.php">Mein Konto</a></li>
              <li><a href="./calendar.php">Öffnungszeiten</a></li>
              <li><a href="?logout">Abmelden</a></li> 
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div id="main">
