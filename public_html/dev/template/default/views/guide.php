<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default guide view , no header or footer

*/
?>
<?php require_once(DIR_VIEWS.'prepend.php'); ?>
<head>
<?php require_once(DIR_VIEWS.'meta.php'); ?>
<?php require_once(DIR_VIEWS.'css.php'); ?>
</head>
<body class="<?php if(isset($arrOutput['content']['class'])){echo $arrOutput['content']['class'];} ?>">
<div class="row-fluid margin-fill-bottom">
	<div class="span12 padding-lr-20">
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
	</div>
</div>
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>