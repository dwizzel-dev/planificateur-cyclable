<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default home view

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
		<div class="row-fluid margin-t-60 bottom-margin-border">
			<div class="span2">
				<img src="<?php echo PATH_IMAGE; ?>piste_cyclable.gif" class="--img-polaroid" style="width:100%;height:auto;margin-top:15px;">
			</div>
			<div class="span10">
				<div class="row-fluid">
					<div class="span12" id="row-title">
						<h1><?php echo ucfirst($arrOutput['content']['title']); ?></h1>
					</div>
				</div>
				<!-- text -->		
				<div class="row-fluid" >
					<div class="span12" id="row-content">
						<?php echo $arrOutput['content']['text'] ;?>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span5">
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
						<?php echo $arrOutput['content']['registration-form'];?>
					</div>
				</div>
			</div>
			<div class="span7" style="border-left:1px solid #aaa;">
				<!-- side text -->		
				<div class="row-fluid">
					<div class="span12  padding-lr-20">
						<p><small><?php echo _T('text helper for lost people.'); ?></small></p>
						<ul>
							<li><a href="<?php echo $oGlob->getArray('links',160); ?>"><?php echo _T('contactez-nous'); ?></a></li>
							<li><a href="<?php echo $oGlob->getArray('links',168); ?>"><?php echo _T('creer un compte'); ?></a></li>
							<li><a href="<?php echo $oGlob->getArray('links',164); ?>"><?php echo _T('mot de passe perdu'); ?></a></li>
						</ul>
						<br /><br />
					</div>
				</div>
			</div>
		</div>	
		<?php require_once(DIR_VIEWS.'footer.php'); ?>
	</div>
</div>
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>