<?php 
define("google", 1);
require_once("./lib/_init.php");
if(Rights::customer()):

$_ctrl = new Index();
$map = $_ctrl->getMap();
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="./bookingForm.php"><i>neue Anfrage</i></a></li>
				<?php 
					while($item = $_ctrl->getSubNav())
					echo '<li><a id="'.$item['id'].'" href="#">'.$item['title'].'</a></li>';
				?>
			</ul>
		</div>
		<div class="span9">
			<div id="mapCanvas" style="width: 100%; height: 90%;"></div>
		</div>
	</div>
</div>
<?=$map?>

<?php endif; ?>