<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default bulle/items/item-1/ view

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
	<div class="row-fluid thick-border-t thick-border-b">
		<div class="span12">
			<h1><?php echo $arrOutput['content']['title'];?></h1>
			<?php echo $arrOutput['content']['text'];?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12 inline">
			<a name="page-top" id="page-top"></a>
			<div class="pull-left">
				<?php echo '<h2>'.ucfirst($arrOutput['content']['item']['h-title']).'</h2>'; ?>
			</div>
			<div class="btn-group pull-right">
				<button class="btn" id="buttdelete"><?php echo _T('delete'); ?></button>
				<?php
				if($arrOutput['content']['item']['details']['status'] == '1'){
					echo '<button class="btn btn-success" id="buttchangestatus">'._T('disable').'</button>';
				}else{
					echo '<button class="btn btn-danger" id="buttchangestatus">'._T('enable').'</button>';
					}
				?>
			</div>
		</div>
	</div>
	<div class="row-fluid hide" id="box-alert">
		<div class="span12 inline">
			<div class="alert alert-error">
				<h4><?php echo _T('errors'); ?></h4>
				<p id="box-alert-msg"></p>
			</div>
		</div>
	</div>	
	<div class="row-fluid hide" id="box-success">
		<div class="span12 inline">
			<div class="alert alert-success">
				<h4><?php echo _T('success'); ?></h4>
				<p id="box-success-msg"></p>
			</div>
		</div>
	</div>
	<div class="row-fluid ">
		<div class="span12">
			<ul class="nav nav-pills">
				<li><?php echo '<a href="#specs" onclick="scrollToElement(\'#specs\')">'._T('specs').'</a>'; ?></li>
				<li><?php echo '<a href="#page-content" onclick="scrollToElement(\'#page-content\')">'._T('page content').'</a>'; ?></li>
			</ul>
			<form class="form-vertical" id="form-item">
				<input type="hidden" name="id" value="<?php echo $arrOutput['content']['item-id'];?>">
				<div class="control-group" style="margin-bottom:20px;">
					<fieldset><legend><?php echo _T('informations');?></legend>
					<div><?php echo _T('#id')?>: <?php echo $arrOutput['content']['item']['details']['id']; ?></div>
					<div><?php echo _T('date modified')?>: <?php echo $arrOutput['content']['item']['details']['date_modified']; ?></div>
					</fieldset>
				</div>
				<div class="control-group" >
					<a name="specs" id="specs"></a>
					<h3><?php echo _T('specs'); ?><a onclick="scrollToElement('#page-top');" style="margin-left:20px;opacity:0.3;" href="#page-top"><img src="<?php echo PATH_IMAGE; ?>glyphicons/glyphicons_218_circle_arrow_top.png"></a></h3>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo _T('name')?></label>
					<div class="controls"><input type="text" id="modify-input-name" name="name" class="span6" value="<?php echo $arrOutput['content']['item']['details']['name']; ?>"></div>
				</div>
				<div class="control-group">
					<label><?php echo _T('language'); ?> :</label>
					<select name="language_id" id="modify-input-language_id" <?php echo ($arrOutput['content']['item']['details']['fixed'] == '1' ? 'disabled' : ''); ?>>
					<?php
					foreach($arrOutput['content']['language-dropdown'] as $k=>$v){
						echo '<option value="'.$v['id'].'" ';
						if($v['id'] == $arrOutput['content']['item']['details']['language_id']){
							echo ' selected ';
							}
						echo '>'.$v['text'].'</option>'.EOL;
						}
					?>
					</select>
				</div>
				<div class="control-group" >
					<a name="page-content" id="page-content"></a>
					<h3><?php echo _T('page content'); ?><a onclick="scrollToElement('#page-top');" style="margin-left:20px;opacity:0.3;" href="#page-top"><img src="<?php echo PATH_IMAGE; ?>glyphicons/glyphicons_218_circle_arrow_top.png"></a></h3>
				</div>
				<div class="control-group">
					<input type="hidden" name="content" id="content" value="<?php echo $arrOutput['content']['item']['details']['content'];?>">	
					<div class="controls"><textarea id="content-html" rows="5" class="span6 editable"><?php echo $arrOutput['content']['item']['details']['content']; ?></textarea></div>
				</div>
				<div class="control-group">
					<div class="controls">
						<br><button class="btn btn-primary" id="buttsave-details"><?php echo _T('save changes'); ?></button>
					</div>
				</div>
			</form>	
		</div>
	</div>	
	<?php require_once(DIR_VIEWS.'footer.php'); ?>
</div>
<form id="form-process" method="post">
	<input type="hidden" name="cbchecked" id="cbchecked" value="<?php echo $arrOutput['content']['item-id'];?>">
</form>	
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
		<button class="btn" data-dismiss="modal" aria-hidden="true"  id="modal-win-close"></button>
		<button class="btn btn-primary" id="modal-win-save"></button>
	</div>
</div>
<script type="text/javascript">
//
jQuery(document).ready(function($){
	//delete items
	$('#buttdelete').click(function(e){
		e.preventDefault();
		$('#modal-win-title').text('<?php echo formatJavascript(_T('warning')); ?>');
		$('#modal-win-content').html('<?php echo formatJavascript(_T('the item will be <b>deleted</b>, are you sure?')); ?>');
		$('#modal-win-close').text('<?php echo formatJavascript(_T('close')); ?>');
		$('#modal-win-save').text('<?php echo formatJavascript(_T('save changes')); ?>');
		$('#modal-win').modal('show');
		$('#modal-win-save').unbind('click');
		$('#modal-win-save').click(function(e){
			e.preventDefault();
			showButtLoadingTxt('#buttdelete', '');
			$('#modal-win').modal('hide');
			deleteItem();
			});
		});
	//changes status
	$('#buttchangestatus').click(function(e){
		e.preventDefault();
		showButtLoadingTxt('#buttchangestatus', '');
		<?php
		if($arrOutput['content']['item']['details']['status'] == '1'){
			echo 'disableItem();'.EOL;
		}else{
			echo 'enableItem();'.EOL;
			}
		?>
		});
	//details form butt
	$('#buttsave-details').click(function(e){
		e.preventDefault();
		showButtLoadingTxt('#buttsave-details', '');
		saveDetails();
		});	
	//editor
	//with MOXIECUT image editor
	tinymce.PluginManager.load('moxiecut', '<?php echo PATH_WEB; ?>js/editor.with-moxiecut/plugins/moxiecut/plugin.min.js');
	tinymce.init({
		plugins: 'image table preview media code anchor link lists fullscreen moxiecut',
		image_advtab: true,
		selector: 'textarea.editable',
		content_css : '<?php echo PATH_WEB_CSS; ?>bootstrap.min.css,<?php echo PATH_WEB_CSS; ?>global.css',
		inline: false,
		height : 350,
		});
	
	});
	
//---------------------------------

function deleteItem(){
	$.ajax({
		type: 'POST',
		url: '<?php echo PATH_SERVICE; ?>',
		data: {section:'bulle',service:'delete-item-infos',data:JSON.stringify($('#form-process').serializeArray())},
		success:function(data){
			//parse data
			eval('var obj = ' + data + ';');
			if(typeof(obj.msgerrors) !== "undefined" && obj.msgerrors){
				showButtLoadingTxt('#buttdelete', '<?php echo _T('delete'); ?>');
				$('#modal-alert-title').text('<?php echo formatJavascript(_T('error')); ?>');
				$('#modal-alert-content').html(obj.msgerrors);
				$('#modal-alert-close').text('<?php echo formatJavascript(_T('close')); ?>');
				$('#modal-alert').modal('show');
			}else{
				//pas erreur on retourne au listing avec page et tout et tout
				window.location.href = '<?php echo $oGlob->getArray('links','bulle-listing').'page-'.$arrOutput['content']['bulle-listing-last-page-number'].'/'; ?>';
				}
			},
		error:function(){
			showButtLoadingTxt('#buttdelete', '<?php echo _T('delete'); ?>');
			}		
		});
	}	
	
//---------------------------------

function disableItem(){
	$.ajax({
		type: 'POST',
		url: '<?php echo PATH_SERVICE; ?>',
		data: {section:'bulle',service:'disable-item-infos',data:JSON.stringify($('#form-process').serializeArray())},
		success:function(data){
			//parse data
			eval('var obj = ' + data + ';');
			if(typeof(obj.msgerrors) !== "undefined" && obj.msgerrors){
				showButtLoadingTxt('#buttchangestatus', '<?php echo _T('disable'); ?>');
				$('#modal-alert-title').text('<?php echo formatJavascript(_T('error')); ?>');
				$('#modal-alert-content').html(obj.msgerrors);
				$('#modal-alert-close').text('<?php echo formatJavascript(_T('close')); ?>');
				$('#modal-alert').modal('show');
			}else{
				$('#buttchangestatus').unbind('click');
				$('#buttchangestatus').removeClass('btn-success');
				$('#buttchangestatus').addClass('btn-danger');
				$('#buttchangestatus').click(function(e){
					e.preventDefault();
					showButtLoadingTxt('#buttchangestatus', '');
					enableItem();
					});
				showButtLoadingTxt('#buttchangestatus', '<?php echo _T('enable'); ?>');	
				}	
			},
		error:function(){
			showButtLoadingTxt('#buttchangestatus', '<?php echo _T('disable'); ?>');
			}	
		});
	}		
	
//---------------------------------

function enableItem(){
	$.ajax({
		type: 'POST',
		url: '<?php echo PATH_SERVICE; ?>',
		data: {section:'bulle',service:'enable-item-infos',data:JSON.stringify($('#form-process').serializeArray())},
		success:function(data){
			//parse data
			eval('var obj = ' + data + ';');
			if(typeof(obj.msgerrors) !== "undefined" && obj.msgerrors){
				showButtLoadingTxt('#buttchangestatus', '<?php echo _T('enable'); ?>');
				$('#modal-alert-title').text('<?php echo formatJavascript(_T('error')); ?>');
				$('#modal-alert-content').html(obj.msgerrors);
				$('#modal-alert-close').text('<?php echo formatJavascript(_T('close')); ?>');
				$('#modal-alert').modal('show');
			}else{
				$('#buttchangestatus').unbind('click');
				$('#buttchangestatus').removeClass('btn-danger');
				$('#buttchangestatus').addClass('btn-success');
				$('#buttchangestatus').click(function(e){
					e.preventDefault();
					showButtLoadingTxt('#buttchangestatus', '');
					disableItem();
					});
				showButtLoadingTxt('#buttchangestatus', '<?php echo _T('disable'); ?>');
				}
			},
		error:function(){
			showButtLoadingTxt('#buttchangestatus', '<?php echo _T('enable'); ?>');
			}	
		});
	}	
	
//---------------------------------

function saveDetails(){
	//hide les erreurs precedente
	resetForm();
	//on va chercher le content html de textarea description
	setHtmlContent('content');
	//on send
	$.ajax({
		type: 'POST',
		url: '<?php echo PATH_SERVICE; ?>',
		data: {section:'bulle',service:'set-item-infos',data:JSON.stringify($('#form-item').serializeArray())},
		success:function(data){
			//parse data
			//alert(data);
			eval('var obj = ' + data + ';');
			if(typeof(obj.formerrors) !== "undefined" && obj.formerrors){
				for(var o in obj.formerrors){
					if($('#modify-input-' + obj.formerrors[o])){
						$('#modify-input-' + obj.formerrors[o]).css('border-color', '#b94a48');
						}
					}
				}
			if(typeof(obj.msgerrors) !== "undefined" && obj.msgerrors){
				showButtLoadingTxt('#buttsave-details', '<?php echo _T('save changes'); ?>');
				$('#box-alert-msg').html(obj.msgerrors);
				$('#box-alert').show();
				$(window).scrollTo(150, 500);
			}else{
				//pas erreur reload page
				successAlert(1);
				showButtLoadingTxt('#buttsave-details', '<?php echo _T('save changes'); ?>');
				location.reload();
				}
			},
		error:function(){
			showButtLoadingTxt('#buttsave-details', '<?php echo _T('save changes'); ?>');
			}	
		});
	}	

//---------------------------------

function showButtLoadingTxt(strButt, strText){
	if(strText == ''){
		$(strButt).text('<?php echo formatJavascript(_T('wait!...')); ?>');
	}else{
		$(strButt).text(strText);
		}
	}	
	
//---------------------------------

function setHtmlContent(id){
	var tBox = tinymce.get(id + '-html');
	var tInput = $('#' + id);
	if(tInput){
		tInput.val(tBox.getContent());
		}
	}

//---------------------------------

function resetForm(){
	successAlert(0);
	$('#box-alert').hide();
	$('#box-alert-msg').text();
	var arr = [['name', 'val'], ['language_id', 'val'], ];
	for(var o in arr){
		$('#modify-input-' + arr[o][0]).css('border-color', '');
		}
	}	

//---------------------------------

function successAlert(bOn){
	if(bOn){
		$('#box-success-msg').html('<?php echo _T('modifications are succesfull');?>');
		$('#box-success').show();
		$(window).scrollTo('#page-top', 500);
	}else{
		$('#box-success').hide();
		$('#box-sucess-msg').text();
		}
	}	

//---------------------------------	
function scrollToElement(id){
	$(window).scrollTo(id, 500); 
	};		
	
	
</script>	
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>