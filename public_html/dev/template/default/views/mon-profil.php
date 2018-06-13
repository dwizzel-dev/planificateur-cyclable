<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default mon-profil view

*/
?>
<?php require_once(DIR_VIEWS.'prepend.php'); ?>
<head>
<?php require_once(DIR_VIEWS.'meta.php'); ?>
<?php require_once(DIR_VIEWS.'css.php'); ?>
<?php require_once(DIR_VIEWS.'script.php'); ?>
</head>
<body class="<?php if(isset($arrOutput['content']['class'])){echo $arrOutput['content']['class'];} ?>">
<div class="row-fluid margin-fill-bottom">
	<div class="span12 padding-lr-20">
		<?php require_once(DIR_VIEWS.'header.php'); ?>
		<div class="row-fluid margin-t-60 bottom-margin-border">
			<h1><?php echo ucfirst($arrOutput['content']['title']); ?></h1>
			<p><?php echo $arrOutput['content']['text'] ;?></p>	
		</div>
		<div class="row-fluid">
			<?php 
			$strOutput = '';
			if(isset($arrOutput['content']['menu-options']) && is_array($arrOutput['content']['menu-options'])){
				$strOutput .= '<h3>'._T('vos options').'</h3>';
				$strOutput .= '<ul>';
				foreach($arrOutput['content']['menu-options'] as $k=>$v){ //menu horizontal
					$strOutput .= '<li><a href="'.$oGlob->getArray('links',$v['link_id']).'">'.ucfirst($v['name']).'</a></li>';
					}
				$strOutput .= '</ul>';
				}
			echo $strOutput;
			?>
		</div>
		<?php require_once(DIR_VIEWS.'footer.php'); ?>
	</div>
</div>
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>