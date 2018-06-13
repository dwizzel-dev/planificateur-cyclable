<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default grille/items/item-1/ view

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
				<li><?php echo '<a href="#questions" onclick="scrollToElement(\'#questions\')">'._T('questions').'</a>'; ?></li>
			</ul>
			<form class="form-vertical" id="form-item">
				<input type="hidden" name="id" value="<?php echo $arrOutput['content']['item-id'];?>">
				<div class="control-group" style="margin-bottom:20px;">
					<fieldset><legend><?php echo _T('informations');?></legend>
					<div><?php echo _T('#id')?>: <?php echo $arrOutput['content']['item']['details']['id']; ?></div>
					<div><?php echo _T('date modified')?>: <?php echo $arrOutput['content']['item']['details']['date_modified']; ?></div>
					<div><?php echo _T('nom')?>: <?php echo $arrOutput['content']['item']['details']['name']; ?></div>
					</fieldset>
				</div>
				<div class="control-group" >
					<a name="questions" id="questions"></a>
					<h3><?php echo _T('questions'); ?><a onclick="scrollToElement('#page-top');" style="margin-left:20px;opacity:0.3;" href="#page-top"><img src="<?php echo PATH_IMAGE; ?>glyphicons/glyphicons_218_circle_arrow_top.png"></a></h3>
				</div>
				<div class="control-group" >
					<?php
					//les tables aec les questions associe a la grille
					$strTable = '';
					if(is_array($arrOutput['content']['question-table'])){
						
						?>
						<div class="">	
							<div class="input-append">
								<button class="btn btn-small" id="butt-newrow"><?php echo _T('add a new item')?></button>
								<button class="btn btn-small" id="butt-delrow"><?php echo _T('remove selected items')?></button>
							</div>
							<div class="input-append">
								<select id="select-recommandation" style="height:26px;">
								<option value="0">--</option>	
								<?php
								foreach($arrOutput['content']['recommandation-dropdown'] as $k=>$v){
									echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
									}
								?>
								</select>
								<button class="btn btn-small" id="butt-addrecommandation"><?php echo _T('add recommandation to selected items')?></button>
							</div>
						</div>
						<?php
						
						$strTable .= '<table class="table-question">';
						$strTable .= '<thead>';
						$strTable .= '<tr>';
						$strTable .= '<th></th>';	
						$strTable .= '<th><input type="checkbox" id="cball" onChange="checkAll();"></th>';	
						foreach($arrOutput['content']['question-table'] as $k=>$v){
							$strTable .= '<th><a target="_NEW" href="'.$oGlob->getArray('links', 'question-items').'item-'.$v['id'].'/">'.$v['name'].'</a></th>';
							}
						$strTable .= '<th>'._T('recommandation').'</th>';	
						$strTable .= '</tr>';
						$strTable .= '</thead>';
						$strTable .= '<tbody id="tbody-grille">';
						$strTable .= '</tbody>';
						$strTable .= '</table>';
					}else{
						$strTable = sprintf(_T('no question are associated with this grille, %sclick here%s to create new questions and associate it with the grille'),'<a href="'.$oGlob->getArray('links', 'question-listing').'">', '</a>');
						}
					//
					echo $strTable;
					?>
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
<?php

//la association recommandation -> texte
echo 'var gRecommandations = [];'.EOL;
foreach($arrOutput['content']['recommandation-dropdown'] as $k=>$v){
	echo 'gRecommandations['.$v['id'].'] = "'.formatJavascript($v['name']).'";'.EOL;
	}

//la association reponse -> texte
echo EOL.'var gReponses = [];'.EOL;
foreach($arrOutput['content']['reponse-array'] as $k=>$v){
	echo 'gReponses['.$k.'] = "'.formatJavascript($v).'";'.EOL;
	}

//la association question -> reponse multiple
echo EOL.'var gQuestions = [];'.EOL;
foreach($arrOutput['content']['question-table'] as $k=>$v){
	echo 'gQuestions['.$v['id'].'] = ['.$v['reponse_array'].'];'.EOL;
	}
	
echo EOL.'var gRowCounter = 0;'.EOL;

echo EOL.'var gLines = [];'.EOL;

echo EOL.'var gArrOldLines = '.$arrOutput['content']['rows-javascript'].';'.EOL;

?>

var gDuplicateLine = [];

//
jQuery(document).ready(function($){
	//add recommandation
	$('#butt-addrecommandation').click(function(e){
		e.preventDefault();
		insertRecommandation();
		});
	//insert new row
	$('#butt-newrow').click(function(e){
		e.preventDefault();
		insertNewRow();
		});
	//delete row
	$('#butt-delrow').click(function(e){
		e.preventDefault();
		deleteRow();
		});
	//details form butt
	$('#buttsave-details').click(function(e){
		e.preventDefault();
		showButtLoadingTxt('#buttsave-details', '');
		saveGrille();
		});	
	//routine	
	createLines();	
	});

//---------------------------------

function deleteRow(){
	removeTR();
	}
	
//---------------------------------

function createLines(){
	var path = '<?php echo $oGlob->getArray('links','recommandation-items').'item-'; ?>';
	var code = '';
	var id = 1;
	var arrRows = [];
	for(var j in gArrOldLines){
		code += '<tr id="tr' + gRowCounter + '">';
		code += '<td><small>' + (id++) + '</small></td>';
		code += '<td><input type="checkbox" id="cb' + gRowCounter + '" onChange="onSelectRow(' + gRowCounter + ');"></td>';
		//string de duplicate
		var strKeyQuestion = '';
		//loop	
		for(var o in gArrOldLines[j].rep){
			//split 
			var arr = gArrOldLines[j].rep[o].split('-');
			//rows
			code += '<td>';
			code += '<select id="q' + gRowCounter + '-' + arr[0] + '" class="input-medium select-small">';
			code += '<option value="0">--</option>';	
			for(var p in gQuestions[arr[0]]){
				code += '<option value="' + gQuestions[arr[0]][p] + '"';
				if(arr[1] == gQuestions[arr[0]][p]){
					strKeyQuestion += arr[1] + '-';
					code += ' selected ';
					}
				code += '>' + gReponses[gQuestions[arr[0]][p]] + '</option>';
				}
			code += '</select>';
			code += '</td>';
			}
		//check duplicate
		if(strKeyQuestion != ''){
			strKeyQuestion = strKeyQuestion.substring(0, (strKeyQuestion.length - 1));
			if(typeof(arrRows[strKeyQuestion]) != 'undefined'){
				arrRows[strKeyQuestion].push('tr' + gRowCounter);
			}else{
				arrRows[strKeyQuestion] = ['tr' + gRowCounter];
				}
			}
		//les recommandations
		code += '<td id="r-' + gRowCounter + '" r-data="' + gArrOldLines[j].rec + '">';
		if(gArrOldLines[j].rec != ''){
			var arrR = gArrOldLines[j].rec.split(',');
			for(var n in arrR){
				code += '<div id="rc' + gRowCounter + '-' + arrR[n] + '" class="pull-left img-polaroid div-recomm"><a target="_NEW" href="' + path + arrR[n] + '/"><small>' + gRecommandations[arrR[n]] + '</small></a><div style="position:absolute;top:5px;right:5px;"><a onclick="removeRecommandation(\'' + gRowCounter + '\',\'' + arrR[n] + '\')"><i class="icon-remove"></i></a></div></div>';
				}
			}
		code += '</td>';
		code += '</tr>';	
		gRowCounter++;
		}

	$('#tbody-grille').append(code);
	findDuplicate(arrRows);
	}		

//---------------------------------

function findDuplicate(arr){
	//on garde juste ceux qu sont double
	var arrDuplicate = [];
	for(var o in arr){
		if(arr[o].length > 1){
			arrDuplicate.push(arr[o]);
			}
		}
	//si on en a on les affiche	
	if(arrDuplicate.length){	
		showDuplicate(arrDuplicate);	
		}
	}
	
//---------------------------------	
	
function pastelColors(){
	var r = (Math.round(Math.random()* 127) + 127).toString(16);
	var g = (Math.round(Math.random()* 127) + 127).toString(16);
	var b = (Math.round(Math.random()* 127) + 127).toString(16);
	return '#' + r + g + b;
	}	
	
//---------------------------------

function showDuplicate(arr){
	for(var o in arr){
		var strColor = pastelColors();
		for(var p in arr[o]){
			$('#' + arr[o][p]).css({'background-color':strColor});
			}
		}
	}	
	
//---------------------------------

function insertRecommandation(){
	var path = '<?php echo $oGlob->getArray('links','recommandation-items').'item-'; ?>';
	//cheche le value
	var id = parseInt($('#select-recommandation').val());
	if(id != 0){
		var text = $('#select-recommandation').text();
		//cherche les checked items
		eval('var arrChecked = [' + getCheckedTR() + '];');
		if(typeof(arrChecked) != 'undefined'){
			//build la string et le r-data
			for(var o in arrChecked){
				//la string
				eval('var arrData = [' + $('#r-' + arrChecked[o]).attr('r-data') + '];');
				if(typeof(arrData) != 'undefined'){
					var code = '';
					var arrNewData = [];
					for(var p in arrData){
						code += '<div id="rc' + arrChecked[o] + '-' + arrData[p] + '" class="pull-left img-polaroid div-recomm"><a target="_NEW" href="' + path + arrData[p] + '/"><small>' + gRecommandations[arrData[p]] + '</small></a><div style="position:absolute;top:5px;right:5px;"><a onclick="removeRecommandation(\'' + arrChecked[o] + '\',\'' + arrData[p] + '\')"><i class="icon-remove"></i></a></div></div>';
						arrNewData.push(arrData[p]);
						}
					if($.inArray(id, arrNewData) == -1){
						code += '<div id="rc' + arrChecked[o] + '-' + id + '" class="pull-left img-polaroid div-recomm"><a target="_NEW" href="' + path + id + '/"><small>' + gRecommandations[id] + '</small></a><div style="position:absolute;top:5px;right:5px;"><a onclick="removeRecommandation(\'' + arrChecked[o] + '\',\'' + id + '\')"><i class="icon-remove"></i></a></div></div>';
						arrNewData.push(id);
						}	
					$('#r-' + arrChecked[o]).html(code);
					$('#r-' + arrChecked[o]).attr('r-data', arrNewData); 
				
					}
				}
			}
		}
	}

//---------------------------------

function saveGrille(){
	//on build un onbject pour envoyer le data
	for(var i=0;i<=gRowCounter;i++){
		//console.log($('#tr' + i));
		if($_('tr' + i)){
			var arrQR = [];
			var strRecommandation = $('#r-' + i).attr('r-data');
			//on va chercher les reponse ed chauqe question
			for(var o in gQuestions){
				arrQR.push(o + '-' + parseInt($('#q' + i + '-' + o).val()));
				}
			gLines.push({
				rep:arrQR,
				rec:strRecommandation,
				});
			}
		}
	sendGrille();	
	}
	
//---------------------------------

function sendGrille(){
	resetForm();
	//on send
	$.ajax({
		type: 'POST',
		url: '<?php echo PATH_SERVICE; ?>',
		data: {section:'grille',service:'set-grille',id:'<?php echo $arrOutput['content']['item-id']; ?>',data:JSON.stringify(gLines)},
		success:function(data){
			//parse data
			//console.log(data);
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

function removeRecommandation(row, id){	
	eval('var arrData = [' + $('#r-' + row).attr('r-data') + '];');
	if(typeof(arrData) != 'undefined'){
		var arrNewData = [];
		for(var o in arrData){
			if(arrData[o] != id){
				arrNewData.push(arrData[o]);
				}
			}
		$('#r-' + row).attr('r-data', arrNewData); 	
		}			
	$('#rc' + row + '-' + id).remove();
	}

//---------------------------------

function onSelectRow(id){
	if($('#cb'+ id) && $('#cb' + id).is(':checked')){
		$('#tr' + id).css('background-color', '#eeeeee');
	}else{
		$('#tr' + id).css('background-color', '#fff');
		}
		
	}

	
//---------------------------------

function insertNewRow(){
	var cmpt = gRowCounter;
	gRowCounter++;
	var code = '';
	code += '<tr id="tr' + cmpt + '">';
	code += '<td><small>X</small></td>';
	code += '<td><input type="checkbox" id="cb' + cmpt + '" onChange="onSelectRow(' + cmpt + ');"></td>';
	for(var o in gQuestions){
		code += '<td>';
		code += '<select id="q' + cmpt + '-' + o + '" class="input-small select-small">';
		code += '<option value="0">--</option>';	
		for(var p in gQuestions[o]){
			code += '<option value="' + gQuestions[o][p] + '">' + gReponses[gQuestions[o][p]] + '</option>';
			}
		code += '</select>';
		code += '</td>';
		}
	code += '<td id="r-' + cmpt + '" r-data=""></td>';
	code += '</tr>';	
	$('#tbody-grille').append(code);
	
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

function resetForm(){
	successAlert(0);
	$('#box-alert').hide();
	$('#box-alert-msg').text();
	var arr = [['name', 'val'], ];
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

//---------------------------------	

function getCheckedTR(){
	var s = '';
	for(var i=0;i<=gRowCounter;i++){
		if($('#cb'+ i) && $('#cb' + i).is(':checked')){
			s += i + ',';
			}
		}
	if(s != ''){
		s = s.substring(0,(s.length - 1));
		return s;
		}
	return false;
	}	

//---------------------------------	
	
function removeTR(){
	eval('var arrTr = [' + getCheckedTR() + '];');
	if(typeof(arrTr) != 'undefined'){
		for(var o in arrTr){
			//remove row
			$('#tr' + arrTr[o]).remove();
			}
		}
	}

//---------------------------------	
	
function checkAll(){
	var bState = false;
	if($('#cball') && $('#cball').is(':checked')){
		bState = true;
		}
	for(var i=0;i<=gRowCounter;i++){
		if($('#cb'+ i)){
			$('#cb'+ i).attr('checked', bState);
			}
		}
	}
	



	
	
</script>	
</body>
<?php require_once(DIR_VIEWS.'append.php'); ?>