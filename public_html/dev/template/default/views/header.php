<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	header view


*/
?>
<div class="navbar fixed-top shadow" id="header">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php  echo $oGlob->getArray('links',6); ?>"><?php echo $arrOutput['header']['alt-logo']; ?></a>
			<div class="nav-collapse collapse">
				<?php
				$strTopMenu = '';
				if(isset($arrOutput['header']['logged-in']) && $arrOutput['header']['logged-in']){
					if(isset($arrOutput['header']['menu']) && is_array($arrOutput['header']['menu'])){
						$strTopMenu .= '<ul class="nav pull-right">';
						foreach($arrOutput['header']['menu'] as $k=>$v){ //menu horizontal
							$strTopMenu .= '<li><a href="'.$oGlob->getArray('links',$v['link_id']).$v['anchor'].'" target="'.$v['target'].'">'.ucfirst($v['name']).'</a></li>';
							$strTopMenu .= '<li class="divider-vertical"></li>';
							}
						$strTopMenu .= '<li><a href="'.PATH_FORM_PROCESS.'?&send_logout=1'.'">'.ucfirst(_T('logout')).'</a></li>';	
						$strTopMenu .= '</ul>';
						}
				}else{
					if(isset($arrOutput['header']['menu-login']) && is_array($arrOutput['header']['menu-login'])){
						$strTopMenu .= '<ul class="nav pull-right">';
						foreach($arrOutput['header']['menu-login'] as $k=>$v){ //menu horizontal
							$strTopMenu .= '<li><a href="'.$oGlob->getArray('links',$v['link_id']).$v['anchor'].'" target="'.$v['target'].'">'.ucfirst($v['name']).'</a>';
							$strTopMenu .= '</li>';
							$strTopMenu .= '<li class="divider-vertical"></li>';
							}
						$strTopMenu .= '</ul>';
						}
					}
				echo $strTopMenu;	
				?>	
			</div><!-- /nav-collapse -->
		</div>
	</div><!-- /navbar-inner -->
</div><!-- /navbar -->






