<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr-fr" lang="fr-fr" > 
<head> 
</head>
<body style="font-size:13px;">
<div id="controle" class="controle">
	<form method="GET">
		<input type="submit" value="clear session">
		<input type="hidden" name="form_clear" value="1">
	</form>
	<form method="GET">
		<input type="submit" value="show session">
		<input type="hidden" name="form_show" value="1">
	</form>
	<form method="GET">
		<input type="submit" value="clear cookie">
		<input type="hidden" name="form_cookie_clear" value="1">
	</form>
	<form method="GET">
		<input type="submit" value="show cookies">
		<input type="hidden" name="form_cookie" value="1">
	</form>
	<form method="GET">
		<input type="submit" value="set session">
		<input type="text" name="name" value="">
		<input type="text" name="value" value="">
		<input type="hidden" name="form_set" value="1">
	</form>
</div>
<div id="liste" class="liste"></div>
<div id="alert" class="alert shadow"></div>
<div id="panier" class="panier"></div>
</body>
</html>
<?php
/**
@auth:	Dwizzel
@date:	01-08-2011
@info:	page clear sessiosns
*/

// required
require_once('define.php');

//required
require_once(DIR_CLASS.'request.php');
$req = new Request($_GET, $_POST);

//check if a send return
if($req->get('form_clear') == '1'){
	//required
	require_once(DIR_CLASS.'session.php');
	$sess = new Session();
	$sess->start();
	$sess->destroy();
	$sess->close();
}else if($req->get('form_show') == '1'){
	//required
	require_once(DIR_CLASS.'session.php');
	$sess = new Session();
	$sess->start();
	$sess->showSession();
	$sess->close();
}else if($req->get('form_set') == '1'){
	//required
	require_once(DIR_CLASS.'session.php');
	$sess = new Session();
	$sess->start();
	$name = $req->get('name');
	$value = $req->get('value');
	$sess->put($name, $value);
	$sess->showSession();
	$sess->close();
}else if($req->get('form_cookie') == '1'){
	//required
	if(isset($_COOKIE)){
		foreach($_COOKIE as $k=>$v){
			echo '<br>'.'['.$k.'] = "'.$v.'"'.'<br>';
			}
		}
}else if($req->get('form_cookie_clear') == '1'){
	//required
	if(isset($_COOKIE)){
		foreach($_COOKIE as $k=>$v){
			setcookie($k,'');
			}
		}
	}
	
		

?>