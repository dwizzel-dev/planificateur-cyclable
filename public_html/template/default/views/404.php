<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default 404 iew

*/


header('HTTP/1.0 404 Not Found');

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
		<div class="row-fluid margin-t-60">
			<div class="span12" id="row-title">
				<h1><?php echo ucfirst($arrOutput['content']['title']); ?></h1>
			</div>
		</div>
		<div class="row-fluid bottom-margin-border">
			<div class="span12" id="row-content">
				<?php echo $arrOutput['content']['text'] ;?>
			</div>
		</div>	
		<?php require_once(DIR_VIEWS.'footer.php'); ?>
	</div>
</div>
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>