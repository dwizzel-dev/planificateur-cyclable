<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default contactez-nous view

*/
?>
<?php require_once(DIR_VIEWS.'prepend.php'); ?>
<head>
<?php require_once(DIR_VIEWS.'meta.php'); ?>
<?php require_once(DIR_VIEWS.'css.php'); ?>
<?php require_once(DIR_VIEWS.'script.php'); ?>
<?php require_once(DIR_INC.'jformer-js-css.php'); ?>
</head>
<body class="<?php if(isset($arrOutput['content']['class'])){echo $arrOutput['content']['class'];} ?>">
<div class="row-fluid margin-fill-bottom">
	<div class="span12 padding-lr-20">
		<?php require_once(DIR_VIEWS.'header.php'); ?>
		<!-- title -->	
		<div class="row-fluid margin-t-60">
			<div class="span12" id="row-title">
				<h1><?php echo ucfirst($arrOutput['content']['title']); ?></h1>
			</div>
		</div>
		<!-- text -->		
		<div class="row-fluid bottom-margin-border">
			<div class="span12" id="row-content">
				<?php echo $arrOutput['content']['text'] ;?>
			</div>
		</div>	
		<!-- errors/warning -->
		<?php 
		if(isset($arrOutput['content']['error'])){
		?>
			<div class="row-fluid">
				<div class="span12 alert alert-error">
					<h3><?php echo _T('errors'); ?></h3>
					<li><?php echo safeReverse($arrOutput['content']['error']);?></li>
				</div>
			</div>
		<?php 
			} //enf if errors
		?>
		<!-- errors/warning -->
		<?php 
		if(isset($arrOutput['content']['confirm'])){
		?>
			<div class="row-fluid">
				<div class="span12 alert alert-success">
					<h3><?php echo _T('success'); ?></h3>
					<li><?php echo safeReverse($arrOutput['content']['confirm']);?></li>
				</div>
			</div>
		<?php 
			} //enf if errors
		?>
		<!-- registration form: dwizzel -->		
		<div class="row-fluid">
			<div class="span12">
				<?php echo $arrOutput['content']['contact-form'];?>
			</div>
		</div>
		<?php require_once(DIR_VIEWS.'footer.php'); ?>
	</div>
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
		<span id="modal-alert-link" style="margin-right:10px;"></span>
		<button class="btn" data-dismiss="modal" aria-hidden="true" id="modal-alert-close"></button>
	</div>
</div>


</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>