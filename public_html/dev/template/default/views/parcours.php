<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default parcours view

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
		<div class="row-fluid margin-t-60 bottom-margin-border" id="row-top">
			<h1><?php echo ucfirst($arrOutput['content']['title']); ?></h1>
			<p><?php echo $arrOutput['content']['text'] ;?></p>	
		</div>
		<div class="row-fluid" id="row-bottom">
			<div class="span7" id="col-left"></div>
			<div class="span5 box-blue" id="col-right"></div>
		</div>	
		<?php require_once(DIR_VIEWS.'footer.php'); ?>
	</div>
</div>


<!-- modal alertpopup for messages/warning -->
<div id="modal-alert" class="modal hide fade">
	<div class="modal-bg"></div>
	<div class="modal-header">
		<h3 id="modal-alert-title"></h3>
	</div>
	<div class="modal-body">
		<div id="modal-alert-content"></div>
	</div>
	<div class="modal-footer">
		<span id="modal-alert-link" style="margin-right:10px;"></span>
		<button class="btn" id="modal-alert-save"></button>
		<button class="btn" id="modal-alert-close"></button>
	</div>
</div>

<script>

//---------------------------------------------------------------------
window.location.hash = '#appz-loading';
window.history.pushState(null, '', '#appz-started');
window.onhashchange = function(){
	if(location.hash == '#appz-loading'){
		window.history.pushState(null, '', '#appz-started');
		}
	}

//---------------------------------------------------------------------

var gParcours = <?php echo $arrOutput['content']['javascript-parcours']; ?>;
var gRecommandation = <?php echo $arrOutput['content']['javascript-recommandation']; ?>;
var gTitle = "<?php echo ucfirst($arrOutput['content']['title']); ?>";
var gContent = "<?php echo formatJavascriptContent($arrOutput['content']['text']); ?>";
var gServerPath = "<?php echo PATH_WEB_NORMAL; ?>";
var gData = <?php echo $arrOutput['content']['javascript-grilles']; ?>;

var jDebug;
var jLang;
var jAppz;

//---------------------------------------------------------------------
jQuery(document).ready(function($){
	//bug fix on apple disconnect error for the $.ajax call
	if(window.navigator.standalone){
		$.ajaxSetup({
			isLocal:false,
			});
		}
	//instantiate
	jDebug = new JDebug();
	jLang = new JLang();
	jAppz = new JAppz();
	//debug
	jDebug.showObject('gParcours', gParcours);	
	jDebug.showObject('gData', gData);	
	//init
	jLang.init();
	jAppz.init();
	});
	

</script>
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>