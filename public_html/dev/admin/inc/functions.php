<?php
/*

OLD VERSION

*/



//---------------------------------------------------------------------------------------------------------------

	
function createTableForCommandeDisplay($arr, $show_cmd_id = NULL){ //commande->product->items-form
	
	global $gCommandeLivraisonDelai, $gPriorite, $gTransfertStatus;
	//commande
	$strOutput = '';
	$strCmdIDs = '';
	$bShowColsLinkOrder = true;
	$bFirstPass = true;
	$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
	foreach($arr as $k=>$v){
		$strCmdIDs .= $v['id'].',';
		if($show_cmd_id == $v['id']){
			$strRowId = ' style="display:table-row" id="cmd_title_row_'.$v['id'].'" ';
		}else{
			$strRowId = ' style="display:none" id="cmd_title_row_'.$v['id'].'" ';
			}
		
		if($bShowColsLinkOrder){
			$strOutput .= '<tr class="tr_grey_1">'.EOL;
			$strOutput .= '<td class="td_title_big"><a name="anc_'.$v['id'].'"></a><a href="javascript:cmdOrderBy(1);">'._T('cmd #').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:cmdOrderBy(2);">'._T('date').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:cmdOrderBy(3);">'._T('status').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:cmdOrderBy(4);">'._T('livraison').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:cmdOrderBy(5);">'._T('user').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:cmdOrderBy(8);">'._T('priorite').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big">&nbsp;</td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:printCommande();"><img src="'.PATH_IMAGE.'print.png"></a></td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			$bShowColsLinkOrder = false;
			}
		$strOutput .= '<tr class="tr_grey_4" '.$strRowId.'>'.EOL;
		$strOutput .= '<td class="td_title_big"><a name="anc_'.$v['id'].'"></a>'._T('cmd #').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('date').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('status').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('livraison').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('user').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('priorite').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">&nbsp;</td>'.EOL;
		$strOutput .= '<td class="td_title_big">&nbsp;</td>'.EOL;
		$strOutput .= '</tr>'.EOL;

		//commande infos
		//paye ou pas vert ou rouge
		if($v['paye'] == '1'){ //complete paye
			$strStylePaye = ' style="color:green" ';
		}else if($v['paye'] == '2'){ //depot
			$strStylePaye = ' style="color:violet" ';	
		}else{ //reserve sans depot
			$strStylePaye = ' style="color:red" ';
			}
		$strOutput .= '<tr class="tr_height_1">'.EOL;
		//exit(print_r($v));
		$strOutput .= '<td class="td_data_big" style="cursor:pointer;" onclick="showRows(\'row_cmd_'.$v['id'].'\');showRows(\'cmd_title_row_'.$v['id'].'\');"><strong>'.number_pad($v['numero'],6).'</strong></td>'.EOL;
		$strOutput .= '<td class="td_data_big">'.$v['date_modified'].'</td>'.EOL;
		$strOutput .= '<td class="td_data_big"><select name="status_commande_'.$v['id'].'" id="status_commande_'.$v['id'].'">';
		foreach($gTransfertStatus as $k2=>$v2){
			$strOutput .= '<option ';
			if($k2 == $v['status_commande']){
				$strOutput .= ' selected ';
				}
			$strOutput .= ' value="'.$k2.'">'.$v2.'</option>';
			}
		$strOutput .= '</select></td>';
		$strOutput .= '<td class="td_data_big"><select name="status_livraison_'.$v['id'].'" id="status_livraison_'.$v['id'].'">';
		foreach($gCommandeLivraisonDelai as $k2=>$v2){
			$strOutput .= '<option ';
			if($k2 == $v['status_livraison']){
				$strOutput .= ' selected ';
				}
			$strOutput .= ' value="'.$k2.'">'.$v2.'</option>';
			}
		$strOutput .= '</select></td>';
		$strOutput .= '<td class="td_data_big" style="cursor:pointer;" onclick="openInfos(\'user\', \''.$v['user_id'].'\');">'.$v['firstname'].' '.$v['lastname'].'</td>'.EOL;
		$strOutput .= '<td class="td_data_big"><select name="status_priorite_'.$v['id'].'" id="status_priorite_'.$v['id'].'">';
		foreach($gPriorite as $k2=>$v2){
			$strOutput .= '<option ';
			if($k2 == $v['status_priorite']){
				$strOutput .= ' selected ';
				}
			$strOutput .= ' value="'.$k2.'">'.$v2.'</option>';
			}
		$strOutput .= '</select></td>';
		$strOutput .= '<td class="td_data_big"><input type="button" value="modifier" onclick="sendModifyCmd(\''.$v['id'].'\');"></td>'.EOL;
		$strOutput .= '<td class="td_data_big"><input type="checkbox" id="chkprint_'.$v['id'].'" ></td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		//display or not
		if($show_cmd_id == $v['id']){
			$strOutput .= '<tr style="display:table-row" id="row_cmd_'.$v['id'].'">'.EOL;
		}else{
			$strOutput .= '<tr style="display:none" id="row_cmd_'.$v['id'].'">'.EOL;
			}
		//product
		$strOutput .= '<td>&nbsp;</td>'.EOL;
		$strOutput .= '<td colspan="7" style="padding-bottom: 100px;">'.EOL;
		$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
		$bShowColsTitle2 = true;
		foreach($v['product'] as $k2=>$v2){
			if($bShowColsTitle2){
				$strOutput .= '<tr class="tr_grey_1">'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('prd #').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('grandeur').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('couleur').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('coupe').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('qte').'</td>'.EOL;
				$strOutput .= '</tr>'.EOL;
				}
			//product infos	
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['product_id'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['grandeur'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['couleur'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['coupe'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['quantite'].'</td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			//items
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td>&nbsp;</td>'.EOL;
			$strOutput .= '<td colspan="4">'.EOL;
			$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
			$bShowColsTitle3 = true;
			foreach($v2['items'] as $k3=>$v3){
				if($bShowColsTitle3){
					$strOutput .= '<tr class="tr_grey_1">'.EOL;
					$strOutput .= '<td class="td_title_big">'._T('sku').'</td>'.EOL;
					$strOutput .= '<td class="td_title_big">'._T('style').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('from').' -> '._T('to').'</td>'.EOL;
					$strOutput .= '<td class="td_title_big">'._T('qte').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('transfert #').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('status').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">&nbsp;</td>'.EOL;
					$strOutput .= '</tr>'.EOL;
					$bShowColsTitle3 = false;
					}
				//items infos
				$strOutput .= '<tr>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['sku'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['style_id'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_big">'.$v3['from'].' -> '.$v3['to'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['quantite'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_big">'.$v3['transfert_no'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_big">'.$v3['status'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_big"><input type="button" value="modifier" onclick="openModifyItems([\''.$v['id'].'\',\''.$v2['product_id'].'\',\''.$v3['grandeur_id'].'\',\''.$v3['couleur_id'].'\',\''.$v3['coupe_id'].'\',\''.$v3['magasin_id_from'].'\',\''.$v3['magasin_id_to'].'\',\''.$v3['status_transfert'].'\',\''.$v3['sku'].'\'])"></td>'.EOL;
				$strOutput .= '</tr>'.EOL;	
				}
			$strOutput .= '</table>'.EOL;
			$strOutput .= '</td>'.EOL;
			$strOutput .= '</tr>'.EOL;	
			}
		$strOutput .= '</table>'.EOL;
		$strOutput .= '</td>'.EOL;
		$strOutput .= '</tr>'.EOL;		
		}
	$strOutput .= '</table>'.'<br/>'.EOL;	
	if($strCmdIDs != ''){
		$strCmdIDs = substr($strCmdIDs, 0, (strlen($strCmdIDs) - 1));
		}
	$strOutput .= '<input type="hidden" value="'.$strCmdIDs.'" id="cmdListIDs">';	
	return $strOutput;	
	}


//---------------------------------------------------------------------------------------------------------------	
	
function createTableForUserInfos($arr){
	//print_r($arr);exit();
	$strOutput = '<table cellspadding="0" cellspacing="0" border="1">'.EOL;
	$bShowColsTitle = true;
	foreach($arr as $k=>$v){
		if($k == 'adresses'){
			foreach($v as $k2=>$v2){
				$strOutput .= '<tr>'.EOL;
				$strOutput .= '<td class="td_data_big" colspan="2">'._T('adresse').'</td>'.EOL;
				$strOutput .= '</tr>'.EOL;
			
				foreach($v2 as $k3=>$v3){
					if($k3 == 'adresse_id'){
						$strOutput .= '<tr>'.EOL;
						$strOutput .= '<td class="td_data_big" colspan="2">'._T('adresse').'['.$k2.']</td>'.EOL;
						$strOutput .= '</tr>'.EOL;
					}else{
						$strOutput .= '<tr>'.EOL;
						$strOutput .= '<td class="td_data_big">'.$k3.'</td>'.EOL;
						$strOutput .= '<td class="td_data_big"><input type="text" disabled value="'.$v3.'" name="'.$k3.'"></td>'.EOL;
						$strOutput .= '</tr>'.EOL;
						}
					}
				}
		}else{
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$k.'</td>'.EOL;
			$strOutput .= '<td class="td_data_big"><input type="text" disabled value="'.$v.'" name="'.$k.'"></td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			}
		}
	$strOutput .= '</table>'.EOL;
	return $strOutput;
	}		

//---------------------------------------------------------------------------------------------------------------



function createTableForCommandePrint($arr){ //commande->product->items
	/*print_r($arr);
	exit();*/
	global $gPriorite, $gProvince;
	//commande
	$strOutput = '';
	$strCmdIDs = '';
	$bShowColsLinkOrder = true;
	$bFirstPass = true;
	$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="90%" style="border:1px solid #aaaaaa">'.EOL;
	foreach($arr as $k=>$v){
		$strOutput .= '<tr style="background-color:#eee;">'.EOL;
		$strOutput .= '<td class="td_title_big" style="text-align:left" colspan="4><a name="anc_'.$v['id'].'"></a>'._T('cmd #').' '.$v['numero'].'</td>'.EOL;
		$strOutput .= '<td class="td_title_big" style="text-align:right">'._T('priorite').': '.$gPriorite[$v['status_priorite']].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		
		$strOutput .= '<td class="td_data_big" colspan="2" style="text-align:left;padding:20px;">';
		$strOutput .= '<b>'._T('nom').':</b> '.ucfirst(mb_strtolower($v['firstname'], 'UTF-8')).' '.ucfirst(mb_strtolower($v['lastname'], 'UTF-8')).'</br>'.EOL;
		$strOutput .= '<b>'._T('adresse').':</b> '.$v['adresse'].'</br>'.EOL;
		$strOutput .= '<b>'._T('ville').':</b> '.$v['ville'].'</br>'.EOL;
		$strOutput .= '<b>'._T('province').':</b> '.$v['province'].'</br>'.EOL;
		$strOutput .= '<b>'._T('code postal').':</b> '.$v['code_postal'].'</br>'.EOL;
		$strOutput .= '</td>'.EOL;
		
		$strOutput .= '<td class="td_data_big" colspan="3" style="text-align:left;padding:20px;vertical-align: top;">';
		$strOutput .= '<b>'._T('date').':</b> '.$v['date_modified'].'</br>'.EOL;
		$strOutput .= '<b>'._T('priorite').':</b> '.$v['priorite'].'</br>'.EOL;
		$strOutput .= '</td>'.EOL;
		
		$strOutput .= '</tr>'.EOL;

		//commande infos
		$bShowColsTitle2 = true;
		foreach($v['product'] as $k2=>$v2){
			if($bShowColsTitle2){
				$strOutput .= '<tr class="tr_grey_1">'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('prd #').'</td>'.EOL;
				//$strOutput .= '<td class="td_title_big">'._T('sexe').'</td>'.EOL;
				//$strOutput .= '<td class="td_title_big">'._T('niveau').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('grandeur').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('couleur').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('coupe').'</td>'.EOL;
				$strOutput .= '<td class="td_title_big">'._T('qte').'</td>'.EOL;
				$strOutput .= '</tr>'.EOL;
				}
			//product infos	
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['product_id'].'</td>'.EOL;
			//$strOutput .= '<td class="td_data_big">'.$v2['sexe'].'</td>'.EOL;
			//$strOutput .= '<td class="td_data_big">'.$v2['niveau'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['grandeur'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['couleur'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['coupe'].'</td>'.EOL;
			$strOutput .= '<td class="td_data_big">'.$v2['quantite'].'</td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			//items
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td>&nbsp;</td>'.EOL;
			$strOutput .= '<td colspan="4" style="text-align:right;">'.EOL;
			$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
			$bShowColsTitle3 = true;
			foreach($v2['items'] as $k3=>$v3){
				if($bShowColsTitle3){
					$strOutput .= '<tr class="tr_grey_3">'.EOL;
					$strOutput .= '<td class="td_title_big">'._T('sku').'</td>'.EOL;
					$strOutput .= '<td class="td_title_big">'._T('style').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('from').' -> '._T('to').'</td>'.EOL;
					$strOutput .= '<td class="td_title_big">'._T('qte').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('alert').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('transfert #').'</td>'.EOL;
					//$strOutput .= '<td class="td_title_big">'._T('memo').'</td>'.EOL;
					$strOutput .= '</tr>'.EOL;
					$bShowColsTitle3 = false;
					}
				//items infos
				$strOutput .= '<tr>'.EOL;
				$strOutput .= '<td class="td_data_normal">'.$v3['sku'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_normal">'.$v3['style_id'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_normal">'.$v3['from'].' -> '.$v3['to'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_normal">'.$v3['quantite'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_normal">'.$v3['transfert_no'].'</td>'.EOL;
				//$strOutput .= '<td class="td_data_normal">'.$v3['memo'].'</td>'.EOL;
				$strOutput .= '</tr>'.EOL;	
				}
			$strOutput .= '</table>'.EOL;
			$strOutput .= '</td>'.EOL;
			$strOutput .= '</tr>'.EOL;	
			}

		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td class="td_title_big" style="text-align:left;border-bottom:1px solid #aaa;padding-bottom:20px;" colspan="5">&nbsp;</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		}
	$strOutput .= '</table>'.'<br/>'.EOL;	
	return $strOutput;	
	}	

	
//---------------------------------------------------------------------------------------------------------------

	
	
function createTableForFactureDisplay($arr, $bPrintDepot, $show_fact_id = NULL){ //commande->product->items-form

	global $gCommandeLivraisonDelai, $gPriorite, $gTransfertStatus;
	//commande
	$strOutput = '';
	$bShowColsLinkOrder = true;
	$bFirstPass = true;
	$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
	
	foreach($arr as $k=>$v){
		if($show_fact_id == $v['id']){
			$strRowId = ' style="display:table-row" id="fact_title_row_'.$v['id'].'" ';
		}else{
			$strRowId = ' style="display:none" id="fact_title_row_'.$v['id'].'" ';
			}
		
		if($bShowColsLinkOrder){
			$strOutput .= '<tr class="tr_grey_1">'.EOL;
			$strOutput .= '<td class="td_title_big"><a name="anc_'.$v['id'].'"></a><a href="javascript:factOrderBy(1);">'._T('facture #').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:factOrderBy(2);">'._T('date').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:factOrderBy(3);">'._T('nom').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:factOrderBy(4);">'._T('transaction #').'</a></td>'.EOL;
			//$strOutput .= '<td class="td_title_big"><a href="javascript:factOrderBy(6);">'._T('vendeur #').'</a></td>'.EOL;
			$strOutput .= '<td class="td_title_big"><a href="javascript:factOrderBy(5);">'._T('total').'</a></td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			$bShowColsLinkOrder = false;
			}
		$strOutput .= '<tr class="tr_grey_4" '.$strRowId.'>'.EOL;
		$strOutput .= '<td class="td_title_big"><a name="anc_'.$v['id'].'"></a>'._T('facture #').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('date').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('nom').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('transaction #').'</td>'.EOL;
		//$strOutput .= '<td class="td_title_big">'._T('vendeur #').'</td>'.EOL;
		$strOutput .= '<td class="td_title_big">'._T('total').'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;

		//commande infos	
		$strOutput .= '<tr class="tr_height_1">'.EOL;
		$strOutput .= '<td class="td_data_big" style="cursor:pointer;" onclick="showRows(\'row_fact_'.$v['id'].'\');showRows(\'row_fact_cmd_'.$v['id'].'\');showRows(\'fact_title_row_'.$v['id'].'\');showRows(\'row_fact_cmd_tot_'.$v['id'].'\');"><strong>'.number_pad($v['id'],6).'</strong></td>'.EOL;
		$strOutput .= '<td class="td_data_big">'.$v['date_added'].'</td>'.EOL;
		$strOutput .= '<td class="td_data_big">'. mb_strtolower($v['firstname'], 'UTF-8').' '.mb_strtolower($v['lastname'], 'UTF-8').'</td>'.EOL;
		$strOutput .= '<td class="td_data_big">'.$v['transaction_no'].'&nbsp;&nbsp;<input type="button" value="$" onclick="openChargeBack(\''.$v['transaction_id'].'\');"></td>'.EOL;
		//$strOutput .= '<td class="td_data_big">#'.$v['vendeur_employe_id'].' ('.mb_strtolower($v['vendeur_firstname'], 'UTF-8').' '.mb_strtolower($v['vendeur_lastname'], 'UTF-8').')</td>'.EOL;
		$strOutput .= '<td class="td_data_big"><div style="float:left;position:relative;margin-left:20px;margin-top:6px;">'.number_format($v['total'], 2, '.', '').'$</div>'.'<div style="float:right;position:relative;"><a href="javascript:printFacture('.$v['id'].','.$v['user_id'].');"><img src="'.PATH_IMAGE.'print.png"></a></div></td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		
		//display or not
		if($show_fact_id == $v['id']){
			$strOutput .= '<tr style="display:table-row" id="row_fact_'.$v['id'].'">'.EOL;
		}else{
			$strOutput .= '<tr style="display:none" id="row_fact_'.$v['id'].'">'.EOL;
			}
		//informations generale
		$strOutput .= '<td colspan="2" style="vertical-align:top" valign="top">'.EOL;
		$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:0px solid #cccccc">'.EOL;
		$strOutput .= '<tr class="tr_grey_1">'.EOL;
		$strOutput .= '<td colspan="2" style="text-align:center;font-weight:bold;font-size:15px">'._T('informations').'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('nom').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.ucfirst(mb_strtolower($v['firstname'], 'UTF-8')).' '.ucfirst(mb_strtolower($v['lastname'], 'UTF-8')).'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('telephone').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['tel_1'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		/*$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('telephone(2)').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['tel_2'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;*/
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('username').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['username'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td colspan="2">&nbsp;</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td colspan="2">&nbsp;</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '</table>'.EOL;	
		$strOutput .= '</td>'.EOL;
		//paiement carte
		$strOutput .= '<td style="vertical-align:top" valign="top">'.EOL;
		$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:0px solid #cccccc">'.EOL;
		$strOutput .= '<tr class="tr_grey_1">'.EOL;
		$strOutput .= '<td colspan="2" style="text-align:center;font-weight:bold;font-size:15px">'._T('paiement').'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('detenteur').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.ucfirst(mb_strtolower($v['prenom'], 'UTF-8')).' '.ucfirst(mb_strtolower($v['nom'], 'UTF-8')).'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('adresse').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['adresse_tel_concat'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('type de carte').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['method'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('no carte').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.str_pad($v['card_no_first_four'], 16, '*', STR_PAD_RIGHT).'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('date de transaction').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['transaction_date'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('no de transaction').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['transaction_no'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('total').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['transaction_total'], 2, '.', '').'$</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '</table>'.EOL;	
		$strOutput .= '</td>'.EOL;
		//livraison
		$strOutput .= '<td style="vertical-align:top" valign="top">'.EOL;
		$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:0px solid #cccccc">'.EOL;
		$strOutput .= '<tr class="tr_grey_1">'.EOL;
		$strOutput .= '<td colspan="2" style="text-align:center;font-weight:bold;font-size:15px">'._T('livraison').'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('adresse').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['adresse'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('ville').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['ville'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('code postal').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['code_postal'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('method').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['cp_method'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('total').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['cp_rate'], 2, '.', '').' $</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('date de livraison').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.$v['cp_date'].'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '</table>'.EOL;	
		$strOutput .= '</td>'.EOL;

		//totaux
		$strOutput .= '<td colspan="2" style="vertical-align:top" valign="top">'.EOL;
		$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:0px solid #cccccc">'.EOL;
		$strOutput .= '<tr class="tr_grey_1">'.EOL;
		$strOutput .= '<td colspan="2" style="text-align:center;font-weight:bold;font-size:15px">'._T('totaux').'</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('sous-total').': </td>'.EOL;
		if($v['code_special_rabais'] > 0){
			$strOutput .= '<td style="text-align:left">'.number_format(($v['sub_total'] - $v['cp_rate'] + $v['code_special_rabais']), 2, '.', '').'$</td>'.EOL;
		}else{
			$strOutput .= '<td style="text-align:left">'.number_format(($v['sub_total'] - $v['cp_rate']), 2, '.', '').'$</td>'.EOL;
			}
		$strOutput .= '</tr>'.EOL;
		
		if($v['code_special_rabais'] > 0){
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('rabais').': </td>'.EOL;
			$strOutput .= '<td style="text-align:left">- '.number_format(($v['code_special_rabais']), 2, '.', '').'$</td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('sous-total').': </td>'.EOL;
			$strOutput .= '<td style="text-align:left">'.number_format(($v['sub_total'] - $v['cp_rate']), 2, '.', '').'$</td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			}		
		
		
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('livraison').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['cp_rate'], 2, '.', '').'$</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('sous-total').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['sub_total'], 2, '.', '').'$</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('hst').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['hst'], 2, '.', '').'$</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		/*$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('tvq').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['tvq'], 2, '.', '').'$</td>'.EOL;
		$strOutput .= '</tr>'.EOL;*/
		$strOutput .= '<tr>'.EOL;
		$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('total').': </td>'.EOL;
		$strOutput .= '<td style="text-align:left">'.number_format($v['total'], 2, '.', '').'$</td>'.EOL;
		$strOutput .= '</tr>'.EOL;
		$strOutput .= '</table>'.EOL;	
		$strOutput .= '</td>'.EOL;
		
		$strOutput .= '</tr>'.EOL;	
			
		
		//commande
		if($show_fact_id == $v['id']){
			$strOutput .= '<tr style="display:table-row" id="row_fact_cmd_'.$v['id'].'">'.EOL;
		}else{
			$strOutput .= '<tr style="display:none" id="row_fact_cmd_'.$v['id'].'">'.EOL;
			}
		$strOutput .= '<td colspan=6" style="padding-bottom:100px;">'.EOL;
		$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
		//
		foreach($v['commande'] as $k2=>$v2){
			$strOutput .= '<tr class="tr_grey_1">'.EOL;
			//$strOutput .= '<td style="text-align:left;font-weight:bold;font-size:14px">'._T('commande').' #'.$v2['commande_no'].'</td>'.EOL;
			$strOutput .= '<td style="text-align:left;font-weight:bold;font-size:14px"><a href="'.PATH_FILE_COMMANDE.'?&section_id=CD000&show_cmd_id='.$v2['commande_id'].'#anc_'.$v2['commande_id'].'">'._T('commande').' #'.number_pad($v2['commande_no'],6).'</a></td>'.EOL;
			$strOutput .= '<td colspan="4"  style="text-align:right;font-weight:bold;font-size:12px">'._T('TOTAL').': '.number_format($v2['commande_total'], 2, '.', '').'$</td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			//products
			$strOutput .= '<tr>'.EOL;		
			$strOutput .= '<td colspan="5">'.EOL;
			$strOutput .= '<table cellspadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #cccccc">'.EOL;
			$strOutput .= '<tr>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('product #').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('style').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('grandeur').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('couleur').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('code').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('quantite').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('prix regulier').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('prix').'</td>'.EOL;
			$strOutput .= '<td class="td_title_big">'._T('total').'</td>'.EOL;
			$strOutput .= '</tr>'.EOL;
			foreach($v2['product'] as $k3=>$v3){
				//items style
				$strStyle = '';
				foreach($v3['items'] as $k4=>$v4){
					$strStyle .= $v4['style_id'].', ';
					}
				if($strStyle != ''){
					$strStyle = substr($strStyle, 0, (strlen($strStyle) - 2));
					}
				//ens items style
				$strOutput .= '<tr>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['product_id'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$strStyle.'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['grandeur'].'/'.$v3['coupe'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['couleur'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['rabais_code'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['quantite'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['product_prix_retail'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.$v3['product_prix'].'</td>'.EOL;
				$strOutput .= '<td class="td_data_big">'.number_format(($v3['product_prix'] * $v3['quantite']), 2, '.', '').'$</td>'.EOL;
				$strOutput .= '</tr>'.EOL;
				}
			$strOutput .= '</table>'.EOL;	
			$strOutput .= '</td>'.EOL;	
			$strOutput .= '</tr>'.EOL;	
			//end product		
			}
		$strOutput .= '</table>'.EOL;		
		$strOutput .= '</td>'.EOL;		
		$strOutput .= '</tr>'.EOL;	

		}
	$strOutput .= '</table>'.'<br/>'.EOL;	
	//end facture
	return $strOutput;	
	}	

	
//---------------------------------------------------------------------------------------------------------------

		
	
function createTableForChargeBack($arr, $iTotalRefund, $strMemos){ 	
	//number_format($v['total'], 2, '.', '')
	$strOutput = '<form action="'.PATH_FORM_PROCESS.'" method="post" id="form_main_charge_back" name="form_main_charge_back">';
	$strOutput .= '<table cellspadding="0" cellspacing="0" border="1">';
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('nom').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.ucfirst($arr['nom']).'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('prenom').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.ucfirst($arr['prenom']).'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('date de transaction').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.$arr['transaction_date'].'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('no de transaction').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.$arr['transaction_no'].'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('method').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.$arr['method'].'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('no authorisation').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.$arr['auth_code'].'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('total').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.number_format($arr['total'], 2, '.', '').'$</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('deja rembourse').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.number_format($iTotalRefund, 2, '.', '').'$</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('total remboursement').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.'<input type="text" value="0.00" name="total_chargeback" id="total_chargeback">'.'$</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('ancien memo').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left"><textarea class="textarea_300" disabled>'.$strMemos.'</textarea></td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '<tr>'.EOL;
	$strOutput .= '<td style="text-align:right;font-weight:bold">'._T('memo').' : </td>'.EOL;
	$strOutput .= '<td style="text-align:left">'.'<textarea name="memo" class="textarea_300">'._T('remboursement facture #').$arr['facture_id'].'</textarea>'.'</td>'.EOL;
	$strOutput .= '</tr>'.EOL;
	$strOutput .= '</table>';
	$strOutput .= '<input type="hidden" value="'.$arr['transaction_id'].'" name="transaction_id">';
	$strOutput .= '<input type="hidden" value="'.$arr['transaction_no'].'" name="transaction_no">';
	$strOutput .= '<input type="hidden" value="'.$arr['currency_code'].'" name="currency_code">';
	$strOutput .= '<input type="hidden" value="1" name="send_charge_back">';
	$strOutput .= '</br></br><input type="button" onclick="chargeBack();" value="'._T('rembourser').'">';
	$strOutput .= '</form>';

	return $strOutput;
	}		


	
?>