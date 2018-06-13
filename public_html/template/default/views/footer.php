<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	footer views

*/
?>



<!-- bottom footer view -->
<div class="navbar fixed-bottom" id="footer">
	<div class="navbar-inner">
		<div class="container">
			<?php
			if(isset($arrOutput['footer']['footer-menu']) && is_array($arrOutput['footer']['footer-menu'])){
				//menu footer
				echo '<ul class="nav">';
				foreach($arrOutput['footer']['footer-menu'] as $k=>$v){
					echo '<li><a href="'.$oGlob->getArray('links',$v['link_id']).'">'.ucfirst($v['name']).'</a></li>';
					echo '<li class="divider-vertical"></li>';
					}
				echo '</ul>';	
				}
			//copyright
			echo '<ul class="nav pull-right">';
			echo '<li><a href="http://www.dechod.com">'.$arrOutput['footer']['copyright'].'</a></li>';
			echo '</ul>';	
			?>
		</div>
	</div>
</div>	
		

		
		
		