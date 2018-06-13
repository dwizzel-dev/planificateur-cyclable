﻿/*

Author: DwiZZel
Date: 15-03-2016
Notes:	
		
*/


//----------------------------------------------------------------------------------------------------------------------

function JAppz(){

	this.className = 'JAppz';

	//on set une reference qui sera utilise partout pour le scope des classes
	$(document).data('jappzclass', this);

	//args with other classes
	this.jcomm = new JComm({'mainappz':this}); //dependencies
	
	//version from index.php
	this.version = '1.0';
	
	//les infos du parcours ouvert
	this.arrCurrentParcoursInfos = false;
	this.arrCurrentGrilleInfos = false;

	
	//-----------------------------------------------------------------------------------------*
	this.init = function(){
		this.debug('init()');

		//show main page infos
		this.showParcoursMainPage(true, true, true);
		
		};

		
	//-----------------------------------------------------------------------------------------*
	this.openGrille = function(id){
		this.debug('openGrille(' + id + ')');
		
		this.arrCurrentGrilleInfos = false;
		//on va chercher l'info du parcours
		for(var o in gParcours){
			if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
				this.arrCurrentGrilleInfos = gParcours[o].grille[id];
				this.arrCurrentGrilleInfos.id = id;
				break;
				}
			}
		
		if(this.arrCurrentGrilleInfos !== false){
			this.showGrille(true, true);
			}
				
		}	
		
	
	//-----------------------------------------------------------------------------------------*
	this.showGrille = function(bTop, bBottom){
		this.debug('showGrille()');
		
		var str;
		
		//top
		if(bTop){
			str = ''
			str += '<small><a id="butt-open-parcours-listing">' + jLang.t('mes parcours') + '</a></small>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			str += '<small><a id="butt-open-grille-listing">' + jLang.t('parcours:') + ' ' + this.arrCurrentParcoursInfos.name + '</a></small>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			str += '<small><a id="butt-modify-grille-name">' + jLang.t('modifier le nom') + '</a></small>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			str += '<small><a id="butt-modify-grille-desc">' + jLang.t('modifier la description') + '</a></small>';
			str += '<h3>' + jLang.t('grille:') + ' ' + this.arrCurrentGrilleInfos.name + '</h3>';
			str += '<p>' + jLang.t('description:') + ' ' + this.arrCurrentGrilleInfos.desc + '</p>';
			//check si le type est est une intersection
			var strSelect = '';
			if(this.arrCurrentGrilleInfos.type == '1'){ //une intersection = 1
				//on va chercher le listing des troncon du parcours
				var arrGrille;
				for(var o in gParcours){
					if(gParcours[o].id == this.arrCurrentParcoursInfos.id){			
						arrGrille = gParcours[o].grille;
						break;
						}
					}	
					
				this.debug('arrGrille', arrGrille);	
				this.debug('this.arrCurrentGrilleInfos', this.arrCurrentGrilleInfos);
					
				//le select des troncon
				var strSelect = '<p>' + jLang.t('associer intersection a un troncon:') + '</p>';
				strSelect += '<p><select id="field-association-troncon" class="input-1">';	
				strSelect += '<option value="-1">' + jLang.t('selectionner un troncon') + '</option>';		
				for(var o in arrGrille){
					if(arrGrille[o].type == '2'){ //un troncon = 2
						strSelect += '<option value="' + o + '"';
						//check si etait selected
						if(this.arrCurrentGrilleInfos.ref_id != -1 && arrGrille[o].id == this.arrCurrentGrilleInfos.ref_id){
							strSelect += ' selected ';
							}
						strSelect += '>' + arrGrille[o].name + '</option>';	
						}
					}
				strSelect += '</select></p>';	
				}
			str += strSelect;	
			
			$('#row-top').html(str);
			//select on change
			if(this.arrCurrentGrilleInfos.type == '1'){ //une intersection = 1
				//si cest une intersection on a un select box
				$('#field-association-troncon').unbind();	
				$('#field-association-troncon').change(function(e){
					e.preventDefault();
					//get parent class
					var oTmp = $(document).data('jappzclass');
					if(typeof(oTmp) == 'object'){
						oTmp.changeGrilleRefId($(this).val());
						}
					});
				}
			
			
			//action on link
			$('#butt-open-parcours-listing').unbind();
			$('#butt-open-parcours-listing').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.showParcoursMainPage(true, true, true);
					}
				});
			//action on link
			$('#butt-open-grille-listing').unbind();
			$('#butt-open-grille-listing').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.showParcours(true, true, true);
					}
				});	
			//action on link
			$('#butt-modify-grille-name').unbind();
			$('#butt-modify-grille-name').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.modifyGrilleName();
					}
				});
			//action on link
			$('#butt-modify-grille-desc').unbind();
			$('#butt-modify-grille-desc').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.modifyGrilleDesc();
					}
				});	
			}
		
		//bottom
		if(bBottom){
			str = '';
			}
		
		
		
		
		
		};	
		
		
	//-----------------------------------------------------------------------------------------*
	this.changeGrilleRefId = function(id){	
		this.debug('changeGrilleRefId(' + id + ')');	
		//on chnage la current grille dans le temp et le gparcours aussi
		for(var o in gParcours){
			if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
				this.arrCurrentGrilleInfos.ref_id = id;
				gParcours[o].grille[this.arrCurrentGrilleInfos.id].ref_id = this.arrCurrentGrilleInfos.ref_id;	
				break;
				}
			}
		
		this.debug('this.arrCurrentGrilleInfos', this.arrCurrentGrilleInfos);
		this.debug('gParcours', gParcours);
	
		};
		
	
	//-----------------------------------------------------------------------------------------*
	this.modifyGrilleName = function(){	
		this.debug('modifyGrilleName()');	
		
		var str = '';
		
		//le input
		str += '<p>' + jLang.t('nom de la grille: ') + '</p>';
		str += '<p><input class="input-1" type="text" value="' + formatJavascript(this.arrCurrentGrilleInfos.name) + '" id="modal-input-1"></p>';
		
		var oButts = this.openAlert('save', jLang.t('modification'), str, false);
		
		//le save action
		$(oButts.save).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.saveGrilleNameModif();
				}
			});
		
		};
		
		
	//-----------------------------------------------------------------------------------------*
	this.saveGrilleNameModif = function(){	
		this.debug('saveGrilleNameModif()');

		$('#modal-input-1').removeClass('error');
		
		var strName = $('#modal-input-1').val();	
		//validation
		var arrField = [];
		if(strName == ''){
			arrField.push('#modal-input-1');
			}
			
		if(arrField.length > 0){
			//color the field
			for(var o in arrField){
				$(arrField[o]).addClass('error');
				}
		}else{
			//on chnage le nom dans la classe parcours
			this.arrCurrentGrilleInfos.name = strName;
			for(var o in gParcours){
				if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
					gParcours[o].grille[this.arrCurrentGrilleInfos.id].name = this.arrCurrentGrilleInfos.name;	
					break;
					}
				}
			this.showGrille(true, false);	
			this.closeAlert();
			}
		
		};
		
		
	//-----------------------------------------------------------------------------------------*
	this.modifyGrilleDesc = function(){	
		this.debug('modifyGrilleDesc()');	
		
		var str = '';
		
		//le input
		str += '<p>' + jLang.t('description de la grille: ') + '</p>';
		str += '<p><textarea class="input-1" id="modal-input-1" rows="6">' + formatJavascript(this.arrCurrentGrilleInfos.desc) + '</textarea></p>';
		
		var oButts = this.openAlert('save', jLang.t('modification'), str, false);
		
		//le save action
		$(oButts.save).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.saveGrilleDescModif();
				}
			});
		
		};	

		
	//-----------------------------------------------------------------------------------------*
	this.saveGrilleDescModif = function(){	
		this.debug('saveGrilleDescModif()');

		$('#modal-input-1').removeClass('error');
		
		var strDesc = $('#modal-input-1').val();	
		//validation
		var arrField = [];
		if(strDesc == ''){
			arrField.push('#modal-input-1');
			}
			
		if(arrField.length > 0){
			//color the field
			for(var o in arrField){
				$(arrField[o]).addClass('error');
				}
		}else{
			//on chnage le nom dans la classe parcours
			this.arrCurrentGrilleInfos.desc = strDesc;
			for(var o in gParcours){
				if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
					gParcours[o].grille[this.arrCurrentGrilleInfos.id].desc = this.arrCurrentGrilleInfos.desc;	
					break;
					}
				}
			this.showGrille(true, false);	
			this.closeAlert();
			}
		
		};	
	
	
	//-----------------------------------------------------------------------------------------*
	this.showParcoursMainPage = function(bTop, bLeft, bRight){
		this.debug('showParcoursMainPage()');
		
		this.arrCurrentParcoursInfos = false;
		this.arrCurrentGrilleInfos = false;
		
		var str;
		
		//top
		if(bTop){
			str = ''
			str += '<h1>' + gTitle + '</h1>';
			str += '<p>' + gContent + '</p>';		
			$('#row-top').html(str);
			}
		
		//left
		if(bLeft){
			str = '';
			str += '<h3>' + jLang.t('vos parcours sauvegardes') + '</h3>';	
			str += '<p><small>' + jLang.t('cliquer sur un parcours pour l\'ouvrir.') + '</small></p>';
			if(gParcours.length > 0){
				str += '<ul id="listing-parcours" class="link">';
				for(var o in gParcours){
					str += '<li><input type="checkbox" value="' + gParcours[o].id + '" ><a parcours-id="' + gParcours[o].id + '">' + gParcours[o].name + '</a></li>';
					}
				str += '</ul>';
				str += '<p><button class="btn" id="butt-delete-parcours">' + jLang.t('supprimer') + '</button></p>';		
			}else{
				str += '<p>' + jLang.t('aucun parcours sauvegarde') + '</p>';
				}
			$('#row-bottom > #col-left').html(str);
			
			//action butt delete
			$('#butt-delete-parcours').unbind();
			$('#butt-delete-parcours').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.deleteParcours();
					}
				});
				
			//action sur le LI
			$('#listing-parcours > LI > A').unbind();
			$('#listing-parcours > LI > A').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openParcours(parseInt($(this).attr('parcours-id')));
					}
				});		
				
			}
		
		//right
		if(bRight){
			str = '';
			str += '<h3>' + jLang.t('nouveau parcours') + '</h3>';
			str += '<p><small>' + jLang.t('pour creer une nouvelle session ecrire un nom.') + '</small></p>';
			str += '<p>' + jLang.t('nom du nouveau parcours:') + '</p>';
			str += '<p><input type="text" value="" id="field-parcours-name" class="input-1"></p>'
			str += '<p>' + jLang.t('description:') + '</p>';
			str += '<p><textarea id="field-parcours-desc" rows="6" class="input-1"></textarea></p>';	
			str += '<p><button class="btn" id="butt-create-parcours">' + jLang.t('creer le parcours') + '</button></p>';
			$('#row-bottom > #col-right').html(str);
			
			//action butt add
			$('#butt-create-parcours').unbind();
			$('#butt-create-parcours').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.createParcours();
					}
				});
			}
		
		
		
		};	
		
		
	//-----------------------------------------------------------------------------------------*
	this.openParcours = function(id){
		this.debug('openParcours(' + id + ')');
		
		this.arrCurrentParcoursInfos = false;
		//on va chercher l'info du parcours
		for(var o in gParcours){
			if(gParcours[o].id == id){
				this.arrCurrentParcoursInfos = [];
				this.arrCurrentParcoursInfos['id'] = gParcours[o].id;
				this.arrCurrentParcoursInfos['name'] = gParcours[o].name;
				this.arrCurrentParcoursInfos['desc'] = gParcours[o].desc;
				break;
				}
			}
		
		if(this.arrCurrentParcoursInfos !== false){
			this.showParcours(true, true, true);
			}
				
		}	
		
		
	//-----------------------------------------------------------------------------------------*
	this.showParcours = function(bTop, bLeft, bRight){
		this.debug('showParcours()');

		var str;
		
		//top
		if(bTop){
			str = ''
			str += '<small><a id="butt-open-parcours-listing">' + jLang.t('mes parcours') + '</a></small>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			str += '<small><a id="butt-modify-parcours-name">' + jLang.t('modifier le nom') + '</a></small>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			str += '<small><a id="butt-modify-parcours-desc">' + jLang.t('modifier la description') + '</a></small>';
			str += '<h3>' + jLang.t('parcours:') + ' ' + this.arrCurrentParcoursInfos.name + '</h3>';
			str += '<p>' + jLang.t('description:') + ' ' + this.arrCurrentParcoursInfos.desc + '</p>';		
			$('#row-top').html(str);
			//action on link
			$('#butt-open-parcours-listing').unbind();
			$('#butt-open-parcours-listing').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.showParcoursMainPage(true, true, true);
					}
				});
			//action on link
			$('#butt-modify-parcours-name').unbind();
			$('#butt-modify-parcours-name').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.modifyParcoursName();
					}
				});
			//action on link
			$('#butt-modify-parcours-desc').unbind();
			$('#butt-modify-parcours-desc').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.modifyParcoursDesc();
					}
				});
			
			}
			
		//left
		if(bLeft){
			str = '';
			str += '<h3>' + jLang.t('vos grilles sauvegardees') + '</h3>';	
			str += '<p><small>' + jLang.t('cliquer sur une grille pour l\'ouvrir.') + '</small></p>';
			//checher la parcours et ses grilles
			var strGrille = '';
			for(var o in gParcours){
				if(parseInt(gParcours[o].id) == parseInt(this.arrCurrentParcoursInfos.id)){
					if(gParcours[o].grille != '' && gParcours[o].grille !== false){
						strGrille += '<ul id="listing-grilles" class="link">';
						for(var p in gParcours[o].grille){
							strGrille += '<li><input type="checkbox" value="' + p + '" ><a grille-id="' + p + '">' + gParcours[o].grille[p].name + '</a>';
							//status
							if(gParcours[o].grille[p].status == 1){
								strGrille += '<span class="right green"><small>ok</small></span>';
							}else{
								strGrille += '<span class="right red"><small>not ok</small></span>';
								}
							strGrille += '</li>';
							}
						strGrille += '</ul>';		
						}	
					break;	
					}		
				}
			if(strGrille == ''){
				str += '<p>' + jLang.t('aucune grille sauvegardee') + '</p>';
			}else{
				str += strGrille;
				str += '<p><button class="btn" id="butt-delete-grilles">' + jLang.t('supprimer') + '</button></p>';	
				}
			$('#row-bottom > #col-left').html(str);
			
			//action butt delete
			$('#butt-delete-grilles').unbind();
			$('#butt-delete-grilles').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.deleteGrille();
					}
				});
				
			//action sur le LI
			$('#listing-grilles > LI > A').unbind();
			$('#listing-grilles > LI > A').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openGrille(parseInt($(this).attr('grille-id')));
					}
				});		
				
			}
			
		//right
		if(bRight){
			str = '';
			str += '<h3>' + jLang.t('nouvelle grille') + '</h3>';
			str += '<p><small>' + jLang.t('pour creer une nouvelle grille ecrire un nom.') + '</small></p>';
			//format
			str += '<p>' + jLang.t('format de grille:') + '</p>';
			//options
			str += '<p>';
			//str += '<div class="row-fluid">';
			//str += '<div class="span6">';
			//options de type
			str += '<select id="field-grille-type" class="input-1">';	
			str += '<option value="-1">' + jLang.t('selectionner un type') + '</option>';		
			for(var o in gData.keyvalue.type){
				str += '<option value="' + o + '">' + gData.keyvalue.type[o] + '</option>';	
				}
			str += '</select>';	
			//str += '</div>'; //closes span6 left
			//str += '<div class="span6">';
			//options de milieu
			str += '<select id="field-grille-milieu" class="input-1">';	
			str += '<option value="-1">' + jLang.t('selectionner un milieu') + '</option>';		
			for(var o in gData.keyvalue.milieu){
				str += '<option value="' + o + '">' + gData.keyvalue.milieu[o] + '</option>';	
				}
			str += '</select>';
			//str += '</div>'; //closes span6 right
			//str += '</div>'; //close row-fluid
			str += '</p>';
			//name
			str += '<p>' + jLang.t('nom de la nouvelle grille:') + '</p>';
			str += '<p><input type="text" value="" id="field-grille-name" class="input-1"></p>'
			//desc
			str += '<p>' + jLang.t('description:') + '</p>';
			str += '<p><textarea id="field-grille-desc" rows="6" class="input-1"></textarea></p>';	
			str += '<p><button class="btn" id="butt-create-grille">' + jLang.t('creer la grille') + '</button></p>';
			$('#row-bottom > #col-right').html(str);
			
			//action butt add
			$('#butt-create-grille').unbind();
			$('#butt-create-grille').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.createGrille();
					}
				});
			}	
		
		
		}	
		
	//-----------------------------------------------------------------------------------------*
	this.createGrille = function(){	
		this.debug('createParcours()');
		
		$('#field-grille-type').removeClass('error');
		$('#field-grille-milieu').removeClass('error');
		$('#field-grille-name').removeClass('error');
		$('#field-grille-desc').removeClass('error');
		
		var strType = $('#field-grille-type').val();
		var strMilieu = $('#field-grille-milieu').val();
		var strName = $('#field-grille-name').val();
		var strDesc = $('#field-grille-desc').val();
				
		//validation
		var arrField = [];
		if(strType == '-1'){
			arrField.push('#field-grille-type');
			}
		if(strMilieu == '-1'){
			arrField.push('#field-grille-milieu');
			}
		if(strName == ''){
			arrField.push('#field-grille-name');
			}
		if(strDesc == ''){
			arrField.push('#field-grille-desc');
			}
			
		if(arrField.length > 0){
			//color the field
			for(var o in arrField){
				$(arrField[o]).addClass('error');
				}
		}else{
		
			var objServer = {
				type: strType,
				milieu: strMilieu,
				name: strName,
				desc: strDesc,
				};
			var objLocal = {
				type: strType,
				milieu: strMilieu,
				name: strName,
				desc: strDesc,
				};
			
			$('#butt-create-grille').unbind();
			$('#butt-create-grille').html(jLang.t('processing'));

			this.createGrilleRFS(objServer, objLocal);		
			
			}			
		};		
		
	
	//-----------------------------------------------------------------------------------------*
	this.deleteGrille = function(){	
		this.debug('deleteGrille()');
		
		var arr = [];
		//found the selected ids
		$('#listing-grilles input[type="checkbox"]').each(function(){
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				if($(this).prop('checked') === true){
					arr.push($(this).val());
					}
				}
			});
		if(arr.length > 0){
			this.deleteSelectedGrille(arr);
			}
				
		};	
		
	//-----------------------------------------------------------------------------------------*
	this.deleteSelectedGrille = function(arr){	
		this.debug('deleteSelectedGrille()', arr);	
		
		//on supprime le data du array et on fait un refresh de la section
		for(var o in gParcours){
			if(parseInt(gParcours[o].id) == parseInt(this.arrCurrentParcoursInfos.id)){
				for(var q in arr){
					delete(gParcours[o].grille[arr[q]]);
					}
				break;
				}
			}
		//refresh le listnig des grilles	
		this.showParcours(false, true, false);
		};	
		
			
	//-----------------------------------------------------------------------------------------*
	this.createGrilleRFS = function(data, extraObj){	
		this.debug('createGrilleRFS::data', data);	
		this.debug('createGrilleRFS::extraObj', extraObj);	
		
		//
		if(typeof(data.error) != 'undefined' && typeof(data.errormessage) != 'undefined'){
			if(parseInt(data.error) == 1){
				this.openAlert('alert', jLang.t('warning!'), data.errormessage, false);	
				return;
				}
			return;	
			}
		
		
		var oGrille = false;
		//on cherche le numero de grille real selon le type et milieu
		for(var o in gData.grilles){
			if(parseInt(gData.grilles[o].type) == parseInt(data.type) && parseInt(gData.grilles[o].milieu) == parseInt(data.milieu)){
				oGrille = {
					grille_id: gData.grilles[o].id,
					ref_id: -1, //pour intersection a troncon
					name: data.name,
					desc: data.desc,
					date: Date.now(),
					type: data.type,
					milieu: data.milieu,
					reponse: false,
					status: 0,
					}
				break;
				}
			}
		
		//on rajoute au grille de parcours du user
		if(oGrille !== false){
			for(var o in gParcours){
				if(parseInt(gParcours[o].id) == parseInt(this.arrCurrentParcoursInfos.id)){
					//on push la nouvelle grille
					if(typeof(gParcours[o].grille) != 'object'){
						gParcours[o].grille = [];
						}
					gParcours[o].grille.push(oGrille);	
					break;
					}
				}
			}
		
		this.debug('gParcours', gParcours);	
		
		//on reload le cote droit formulaire
		this.showParcours(false, true, true);	
			
		
		
	
		};
	
	//-----------------------------------------------------------------------------------------*
	this.modifyParcoursName = function(){	
		this.debug('modifyParcoursName()');	
		
		var str = '';
		
		//le input
		str += '<p>' + jLang.t('nom du parcours: ') + '</p>';
		str += '<p><input class="input-1" type="text" value="' + formatJavascript(this.arrCurrentParcoursInfos.name) + '" id="modal-input-1"></p>';
		
		var oButts = this.openAlert('save', jLang.t('modification'), str, false);
		
		//le save action
		$(oButts.save).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.saveParcoursNameModif();
				}
			});
		
		}
		
	//-----------------------------------------------------------------------------------------*
	this.saveParcoursNameModif = function(){	
		this.debug('saveParcoursNameModif()');

		$('#modal-input-1').removeClass('error');
		
		var strName = $('#modal-input-1').val();	
		//validation
		var arrField = [];
		if(strName == ''){
			arrField.push('#modal-input-1');
			}
			
		if(arrField.length > 0){
			//color the field
			for(var o in arrField){
				$(arrField[o]).addClass('error');
				}
		}else{
			//on chnage le nom dans la classe parcours
			this.arrCurrentParcoursInfos.name = strName;
			for(var o in gParcours){
				if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
					gParcours[o].name = this.arrCurrentParcoursInfos.name;	
					break;
					}
				}
			this.showParcours(true, true, true);	
			this.closeAlert();
			}
		
		}	
		

	//-----------------------------------------------------------------------------------------*
	this.modifyParcoursDesc = function(){	
		this.debug('modifyParcoursDesc()');

		var str = '';
		
		//le input
		str += '<p>' + jLang.t('description du parcours: ') + '</p>';
		str += '<p><textarea id="modal-input-1" class="input-1" rows="6">' + formatJavascript(this.arrCurrentParcoursInfos.desc) + '</textarea></p>';
		
		var oButts = this.openAlert('save', jLang.t('modification'), str, false);
		
		//le save action
		$(oButts.save).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.saveParcoursDescModif();
				}
			});
		
		}	

	//-----------------------------------------------------------------------------------------*
	this.saveParcoursDescModif = function(){	
		this.debug('saveParcoursDescModif()');

		$('#modal-input-1').removeClass('error');
		
		var strDesc = $('#modal-input-1').val();	
			
		//on chnage le nom dans la classe parcours
		this.arrCurrentParcoursInfos.desc = strDesc;
		for(var o in gParcours){
			if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
				gParcours[o].desc = this.arrCurrentParcoursInfos.desc;	
				break;
				}
			}
		this.showParcours(true, true, true);	
		this.closeAlert();
		
		}	
		
		
	//-----------------------------------------------------------------------------------------*
	this.createParcours = function(){	
		this.debug('createParcours()');
		
		$('#field-parcours-name').removeClass('error');
		$('#field-parcours-desc').removeClass('error');
		
		var strName = $('#field-parcours-name').val();
		var strDesc = $('#field-parcours-desc').val();
		
		//validation
		var arrField = [];
		if(strName == ''){
			arrField.push('#field-parcours-name');
			}
		if(strDesc == ''){
			arrField.push('#field-parcours-desc');
			}
			
		if(arrField.length > 0){
			//color the field
			for(var o in arrField){
				$(arrField[o]).addClass('error');
				}
		}else{
			var objServer = {
				name: strName,
				desc: strDesc,
				};
			var objLocal = {
				name: strName,
				desc: strDesc,
				};
				
			$('#butt-create-parcours').unbind();
			$('#butt-create-parcours').html(jLang.t('processing'));	
			
			this.jcomm.process(this, 'parcours', 'create', objServer, objLocal);
			}			
		};	
		
	
	//-----------------------------------------------------------------------------------------*
	this.createParcoursRFS = function(data, extraObj){	
		this.debug('createParcoursRFS::data', data);	
		this.debug('createParcoursRFS::extraObj', extraObj);

		//
		if(typeof(data.error) != 'undefined' && typeof(data.errormessage) != 'undefined'){
			if(parseInt(data.error) == 1){
				this.openAlert('alert', jLang.t('warning!'), data.errormessage, false);	
				return;
				}
			return;	
			}
		//on supprime le data du array et on fait un refresh de la section
		if(typeof(data.id) != 'undefined'){
			if(parseInt(data.id) > 0){
				gParcours.push({
					id: parseInt(data.id),
					desc: extraObj.desc,
					name: extraObj.name,		
					});
				//refresh	
				this.showParcoursMainPage(false, true, true);
				}
			}
		
		
		
		};	

		
	//-----------------------------------------------------------------------------------------*
	this.deleteParcours = function(){	
		this.debug('deleteParcours()');
		
		var arr = [];
		//found the selected ids
		$('#listing-parcours input[type="checkbox"]').each(function(){
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				if($(this).prop('checked') === true){
					arr.push($(this).val());
					}
				}
			});
		if(arr.length > 0){
			this.deleteSelectedParcours(arr);
			}
				
		};

		
	//-----------------------------------------------------------------------------------------*
	this.deleteSelectedParcours = function(arr){	
		this.debug('deleteSelectedParcours()', arr);	
		
		var objServer = {
			ids: arr.toString(),
			};
		var objLocal = {
			ids: arr,
			};
		
		$('#butt-delete-parcours').unbind();
		$('#butt-delete-parcours').html(jLang.t('processing'));
			
		this.jcomm.process(this, 'parcours', 'delete', objServer, objLocal);
		
		};
		
		
	//-----------------------------------------------------------------------------------------*
	this.deleteSelectedParcoursRFS = function(data, extraObj){	
		this.debug('deleteSelectedParcoursRFS::data', data);	
		this.debug('deleteSelectedParcoursRFS::extraObj', extraObj);

		//
		if(typeof(data.error) != 'undefined' && typeof(data.errormessage) != 'undefined'){
			if(parseInt(data.error) == 1){
				this.openAlert('alert', jLang.t('warning!'), data.errormessage, false);	
				return;
				}
			return;	
			}
		//on supprime le data du array et on fait un refresh de la section
		if(typeof(data.ok) != 'undefined'){
			if(parseInt(data.ok) == 1){
				for(var o in extraObj.ids){
					for(var p in gParcours){
						if(parseInt(extraObj.ids[o]) == parseInt(gParcours[p].id)){
							delete(gParcours[p]);
							}
						}
					}
				//refresh	
				this.showParcoursMainPage(false, true, false);
				}
			}
		
		
		
		};
			
		
		
	//-----------------------------------------------------------------------------------------*
	this.closeAlert = function(){
		
		$('#modal-alert').addClass('hide fade');
		$('#modal-alert #modal-alert-title').html();
		$('#modal-alert #modal-alert-content').html();
		$('#modal-alert #modal-alert-close').html();
		//action close
		$('#modal-alert #modal-alert-close').unbind();
		$('#modal-alert #modal-alert-save').unbind();
		};
		
		
	//-----------------------------------------------------------------------------------------*
	this.openAlert = function(type, title, content, bAutoHide){
		this.debug('openAlert(' + type + ', ' + title + ', ' + '[content]'+ ', ' + bAutoHide + ')');			
		
		//le type pour l'icone a afficher
		var strSaveButtName = '#modal-alert-save';
		var strCancelButtName = '#modal-alert-close';
		
		//box content
		$('#modal-alert #modal-alert-title').html(title);
		$('#modal-alert #modal-alert-content').html(content);
		$('#modal-alert ' + strCancelButtName).html(jLang.t('fermer'));
				
		//hide
		$('#modal-alert ' + strSaveButtName).hide();
		
		if(type == 'save'){
			$('#modal-alert ' + strSaveButtName).html(jLang.t('sauvegarder'));
			$('#modal-alert ' + strSaveButtName).show();
			//le action on save se fait dans la fonction qiu call le openAlert
			}
		
		//action close
		$('#modal-alert ' + strCancelButtName).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.closeAlert();
				}
			});

		//show
		$('#modal-alert').removeClass('hide fade');
		
		return {save: strSaveButtName, cancel: strCancelButtName};
		};
		
	
	//-----------------------------------------------------------------------------------------*
	this.debug = function(){
		if(typeof(jDebug) == 'object'){
			if(arguments.length == 1){	
				jDebug.show(this.className + '::' + arguments[0]);
			}else{
				jDebug.showObject(this.className + '::' + arguments[0], arguments[1]);
				}
			}	
		};
	
	
	//-----------------------------------------------------------------------------------------*	
	this.commCallBackFunc = function(pid, obj, extraObj){
		this.debug('commCallBackFunc(' + pid + ')');
		this.debug('commCallBackFunc::obj', obj);
		this.debug('commCallBackFunc::obj', extraObj);
		
		//
		if(typeof(obj.msgerrors) != 'undefined' && obj.msgerrors != ''){
			this.debug(obj.msgerrors);
			this.openAlert('error', jLang.t('error!'), obj.msgerrors, false);
		}else{
			if(obj.section == 'parcours'){
				if(obj.service == 'delete'){
					this.deleteSelectedParcoursRFS(obj.data, extraObj);
				}else if(obj.service == 'create'){
					this.createParcoursRFS(obj.data, extraObj);	
				}else{
					//
					}
			}else{
				//
				}
			}
		};	
		

	}



//CLASS END






