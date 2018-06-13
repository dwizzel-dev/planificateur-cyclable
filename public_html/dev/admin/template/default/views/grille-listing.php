<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default grille items listing view

*/
?>
<?php require_once(DIR_VIEWS.'prepend.php'); ?>
<head>
<?php require_once(DIR_VIEWS.'meta.php'); ?>
<?php require_once(DIR_VIEWS.'css.php'); ?>
<?php require_once(DIR_VIEWS.'script.php'); ?>
</head>
<body class="<?php if(isset($arrOutput['content']['class'])){echo $arrOutput['content']['class'];} ?>">
<div class="row-fluid top-color"></div>
<div id="container" >
	<?php require_once(DIR_VIEWS.'header.php'); ?>
	<div class="row-fluid thick-border-t thick-border-b" style="margin-bottom:20px;">
		<div class="span12">
			<h1><?php echo $arrOutput['content']['title'];?></h1>
			<?php echo $arrOutput['content']['text'];?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-hover ">
				<thead>
					<tr>
					<?php
					//table head
					foreach($arrOutput['content']['items']['columns'] as $k=>$v){
						echo '<th>'.ucfirst($v).'</th>';
						}
					?>
					</tr>
				</thead>
				<tbody>
					<?php
					$cbCmpt = -1;
					//level 0
					if(is_array($arrOutput['content']['items']['rows'])){
						foreach($arrOutput['content']['items']['rows'] as $k=>$v){
							$cbCmpt++;
							if($v['status'] == '1'){
								echo '<tr id="tr'.$cbCmpt.'" class="">';
							}else{
								echo '<tr id="tr'.$cbCmpt.'" class="disable">';
								}
							//select
							echo '<td><input type="checkbox" id="cb'.$cbCmpt.'" value="'.$v['id'].'"></td>';
							echo '<td>'.$v['name'].'</td>';
							echo '<td>'.$v['date_modified'].'</td>';
							echo '<td>'.$v['id'].'</td>';
							//butt modify
							echo '<td><a id="buttmodify'.$v['id'].'" href="#"><img src="'.PATH_IMAGE.'glyphicons/glyphicons_030_pencil.png" class="img-pencil"></a><img id="imgloading'.$v['id'].'" src="'.PATH_IMAGE.'loading.gif" style="display:none;" class="img-loading"></td>';
							echo '</tr>'.EOL;
							//script action on butt
							echo '<script type="text/javascript">'.EOL;
							echo 'jQuery(document).ready(function($){'.EOL;
							echo '	$("#buttmodify'.$v['id'].'").click(function(e){'.EOL;
							echo '		e.preventDefault();'.EOL;
							echo '		getItemInfos('.$v['id'].');'.EOL;
							echo '		});'.EOL;
							echo '	});'.EOL;
							echo '</script>'.EOL;
							
							}
						}	
					?>
				</tbody>
			</table>
			<form id="form-process" method="post">
				<input type="hidden" name="cbchecked" id="cbchecked" value="">
			</form>	
		</div>
	</div>
	<?php require_once(DIR_VIEWS.'footer.php'); ?>
</div>
<!-- modal alertpopup for messages/warning -->
<div id="modal-alert" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="modal-alert-title"></h3>
	</div>
	<div class="modal-body">
		<div id="modal-alert-content"></div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true" id="modal-alert-close"></button>
	</div>
</div>
<!-- modal win for messages/warning with save options-->
<div id="modal-win" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="modal-win-title"></h3>
	</div>
	<div class="modal-body">
		<div id="modal-win-content"></div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true" id="modal-win-close"></button>
		<button class="btn btn-primary" id="modal-win-save"></button>
	</div>
</div>
<script type="text/javascript">
//
jQuery(document).ready(function($){
	
	
	});
	
//---------------------------------

function showPencilLoadingImg(strid, status){
	if(status){
		$('#buttmodify' + strid).hide();
		$('#imgloading' + strid).show();
	}else{
		$('#buttmodify' + strid).show();
		$('#imgloading' + strid).hide();
		}
	}
	

//---------------------------------

function getItemInfos(strid){
	window.location.href = '<?php echo $oGlob->getArray('links','grille-items')?>item-' + strid + '/';
	}
	
	
</script>	
</body>
<?php 


require_once(DIR_VIEWS.'append.php'); 





//END



