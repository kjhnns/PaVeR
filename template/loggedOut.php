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
					$r.= ",".$v->size();
	
				}
				$r.= "<br>";
			}
			return $r;
		}
	
		if($GLOBALS['_DEBUG']) foreach($GLOBALS['_DEBUG'] as $dbg) $debuglog.=$dbg."<br>";
		echo 	'<div style="background: #000; color: #fff;position:absolute;min-height: 400px;z-index:-99;padding-bottom: 80px; right: 0px; left:0px; top: 100%;overflow: scroll;">qrys: '.
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
<!DOCTYPE html>
<html lang="de">
<head>
	<title><?=Preferences::value("pageTitle")?> Login</title>
	
  	<meta name="HandheldFriendly" content="True">
  	<meta name="MobileOptimized" content="320">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="icon" type="image/png" href="./template/favicon.png" />
	<link rel="apple-touch-icon" href="./template/touch-icon.png" />
    <link href="./template/style.css" rel="stylesheet">
    <link href="./template/3rd/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./template/3rd/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#"><?=Preferences::value("pageTitle")?></a>
           <div class="nav-collapse collapse">
            <ul class="nav">
            	<!-- class="active" missing --> 
              <li ><a href="./index.php">Anmeldung</a></li>
              <li ><a href="./registration.php">Registrierung</a></li>
            </ul>
           </div>
        </div>
      </div>
    </div>
    
    
    