/*

Author: DwiZZel
Date: 15-03-2016
Notes:	

jLang.t\(\'(.*)'\)
/_T\('([a-z0-9A-Z-~.,=?#%^\"`*:<>!\{\}\|\/\[\]\s]*)'\)/
jLang.t\('(.*)'\)"

	type:
		1: "intersection"
		2: "troncon"
		3: "traverse"

	milieu:
		1: "urbain"
		2: "rural"

	grille:	
		11: "tronçons urbain (grille #1)"
		12: "intersections urbain (grille #2)"
		13: "traversées urbain (grille #3)"
		14: "tronçons rural (grille #4)"
		15: "intersections rural (grille #5)"
		16: "traversées rural (grille #6)"
		
	rid = reference grille id
	gid = global grille id	

		
*/


//----------------------------------------------------------------------------------------------------------------

function JAppz(){

	this.className = 'JAppz';

	//on set une reference qui sera utilise partout pour le scope des classes
	$(document).data('jappzclass', this);

	//args with other classes
	this.jcomm = new JComm({'mainappz':this}); //dependencies
	
	//version from index.php
	this.version = '1.0';
	
	//connection state
	this.connection = false;
	
	//les infos du parcours ouvert
	this.arrCurrentParcoursInfos = false;
	this.arrCurrentGrilleInfos = false;
	this.arrCurrentQuestionsInfos = false;
	this.arrCurrentRecommandationsInfos = false;
	
	this.saved = true;
	
	//thread
	this.thProcessGrille = false;

	
	//-----------------------------------------------------------------------------------------*
	this.init = function(){
		this.debug('init()');

		//on clean le data avant de commencer
		this.cleanParcoursObject();
		
		//show main page infos
		this.showParcoursMainPage(true, true, true);
		
		//ping A REMETTRE
		this.pingService();	
		setInterval(this.pingService.bind(this), 5000);
		
		//autosave A REMETTRE
		setInterval(this.saveParcours.bind(this), 10000);
		
		//click sur la lumiere pour sauver
		$('#connection').click(function(e){
			e.preventDefault();
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				if(oTmp.connection && !oTmp.saved){
					oTmp.saveParcours();
					}
				}
			});
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
	this.openRecommandation = function(oButt){
		this.debug('openRecommandation(' + oButt + ')');
		
		//on met le loader
		this.arrCurrentRecommandationsInfos = false;
		
		//la liste complete de la grille
		for(var o in gParcours){
			if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
				if(gParcours[o].grille !== false && gParcours[o].grille !== null){
					this.arrCurrentRecommandationsInfos = gParcours[o];
					}
				break;	
				}	
			}
		//	
		this.thProcessGrille = new JThread('processGrille', this, 10, {
			parent: this, 
			cmpt: 0,
			grille: this.arrCurrentRecommandationsInfos.grille,
			arrkeys: false,
			ikey: 0,
			butt: oButt,
			rec: [],
			});
		//une fois termine il fera l'affichage	
		this.thProcessGrille.start();	
						
		}	
		
		
	//-----------------------------------------------------------------------------------------*	
	this.processGrille = function(obj){
		this.debug('processGrille', obj);	
		//chechk si on a les keys premiere fois que lone rentre dans le thread
		if(obj.arrkeys === false){
			obj.butt.unbind();
			obj.butt.prop('disabled', true);
			obj.ikey = 0;
			obj.arrkeys = [];
			for(var o in obj.grille){
				obj.arrkeys.push(o);
				}
			}
		//on va chercher les recommandation pour chauq emask de reponse
		//la grille de recommandations
		if(typeof(gData.recommandations[obj.grille[obj.arrkeys[obj.ikey]].gid]) != 'undefined'){
			//va chercher es recommandation pour ce type de grille 11-12-13, etc...
			arrRecommandation = gData.recommandations[obj.grille[obj.arrkeys[obj.ikey]].gid].mask;
			//les reponse pour cette grille
			arrReponse = obj.grille[obj.arrkeys[obj.ikey]].reponse;
			//on check un mask
			var arrRec = false;
			for(var p in arrRecommandation){
				//le nombre de reponse neccessaire
				var iNeeded = arrRecommandation[p].rep.length;
				var iAdded = 0;
				//on split
				for(var q in arrRecommandation[p].rep){
					var arrQR = arrRecommandation[p].rep[q].split('-');
					if(arrQR.length == 2){
						//check si une reponse
						if(typeof(arrReponse[arrQR[0]]) != 'undefined'){
							//chcek si la bonne
							if(arrReponse[arrQR[0]] == arrQR[1]){
								iAdded++;
								}
							}
						}
					}
				//on rajoute la recommandation a la grille	
				if(iAdded > 0 && iAdded == iNeeded){
					//this.debug('MATCH: ' + obj.grille[obj.arrkeys[obj.ikey]].id + '=' + arrRecommandation[p].rec);
					if(arrRec === false){
						arrRec = [];
						}
					arrRec.push(arrRecommandation[p].rec);	
					}
				}
			//la cle par id de grille	
			obj.rec[obj.grille[obj.arrkeys[obj.ikey]].id] = arrRec;
			}
		//
		obj.ikey++;
		if(obj.ikey < obj.arrkeys.length){
			obj.butt.html(jLang.t('processing') + ': ' + obj.ikey);
			return true;
			}
		
		//on set le result de facon global
		if(typeof(gRecommandation) != 'object'){
			gRecommandation = [];
			}
		gRecommandation[this.arrCurrentParcoursInfos.id] = obj.rec;
		//
		if(this.arrCurrentRecommandationsInfos !== false){
			this.showRecommandation(true, true);
			}
		//quitte le thread	
		return false;
		}	
		
	
	//-----------------------------------------------------------------------------------------*
	this.showRecommandation = function(bTop, bBottom){
		this.debug('showRecommandation(' + bTop + ', ' + bBottom + ')');
		
		$(window).scrollTop(0);
		
		var oDiv = $('#col-left');
		if(typeof(oDiv[0]) != 'undefined'){
			$('#row-bottom').html('');
			}
		
		var str;
				
		//top
		if(bTop){
			str = '';
			//menu
			str += '<a id="butt-open-parcours-listing">' + jLang.t('mes parcours') + '</a>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			str += '<a id="butt-open-grille-listing">' + jLang.t('mes grilles') + '</a>';
			str += '<br />';
			//content
			str += '<h4>' + jLang.t('mes recommandations') + '</h4>'
			//str += '<p>' + jLang.t('description:') + ' ' + this.arrCurrentGrilleInfos.desc + '</p>';
			str += '<p><small>' + jLang.t('mes recommandations texte introduction') + '</small></p>';
			
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
			$('#butt-open-grille-listing').unbind();
			$('#butt-open-grille-listing').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.showParcours(true, true, true);
					}
				});	
			
			}
			
		if(bBottom){
			
			
			//nous allons verifier si aucune des grilles a une recommandations
			//pour avertir l'usager, il sera possible plus tard de dire quelles
			//grilles n'a aucune recommandation et faire un lien dessus pour la ramener
			//directement a la question
			var bNoRecommandations = true;
			
			if(typeof(gRecommandation[this.arrCurrentParcoursInfos.id]) != 'undefined'){
				for(var o in gRecommandation[this.arrCurrentParcoursInfos.id]){
					if(gRecommandation[this.arrCurrentParcoursInfos.id][o] != 'undefined' && gRecommandation[this.arrCurrentParcoursInfos.id][o] != false){
						//on en a au moins une alors on peut briser la loop
						bNoRecommandations = false;
						break;
						}
					}
				}
						
			str = '';
			//on va chercher le nom du parcours
			str += '<h3>' + this.arrCurrentRecommandationsInfos.name + '</h3>';
			//strgin des grilles recommandations
			var strGrille = '';
			//on loop pour savoir qui a des recommandation dans les grilles
			if(typeof(gRecommandation[this.arrCurrentParcoursInfos.id]) != 'undefined' && !bNoRecommandations){
				//top menu des grilles pour ouvrir print et autres
				str += '<div class="rec-top-menu"><small><a id="butt-open-all-rows">' + jLang.t('ouvrir toutes les grilles') + '</a>&nbsp;|&nbsp;<a id="butt-close-all-rows">' + jLang.t('fermer toutes les grilles') + '</a><a id="butt-print-all" style="float:right;margin-right:10px;">' + jLang.t('print all') + '</a></small></div>';
				//loop des recherches de parcours 
				for(var o in gParcours){
					if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
						if(gParcours[o].grille !== false && gParcours[o].grille !== null){
							strGrille += '<ul class="all-rows">';
							for(var p in gParcours[o].grille){
								//check si a des recommandation
								if(typeof(gRecommandation[this.arrCurrentParcoursInfos.id][gParcours[o].grille[p].id]) != 'undefined' && gRecommandation[this.arrCurrentParcoursInfos.id][gParcours[o].grille[p].id] !== false){
									strGrille += '<li class="rows" opened="0" grille-id="' + gParcours[o].grille[p].id + '">';
									strGrille += '<span class="rows-dot" grille-id="' + gParcours[o].grille[p].id + '">&#9737;</span>';
									strGrille += '<span class="rows-print" grille-id="' + gParcours[o].grille[p].id + '"><a href="#"><small>' + jLang.t('print grille') + '</small></a></span>';
									strGrille += '<a class="row-action" grille-id="' + gParcours[o].grille[p].id + '">' + gParcours[o].grille[p].name + '</a>';
									strGrille += '<div class="row-display hide">';
									//les questions
									var strQuestion = '';
									var arrQuestion = gData.grilles[gParcours[o].grille[p].gid];
									strQuestion += '<small><ul class="question">';
									strQuestion += '<h6 class="question">' + jLang.t('questions') + '</h6>';
									for(var q in arrQuestion.questions){
										strQuestion += '<li>';
										strQuestion += '<p style="margin-right:40px;"><i>' + gData.keyvalue.questions[arrQuestion.questions[q].id] + '</i><b>&nbsp;' + gData.keyvalue.reponses[gParcours[o].grille[p].reponse[arrQuestion.questions[q].id]] + '</b></p>';
										strQuestion += '</li>';
										}
									strQuestion += '</ul></small>';
									strGrille += strQuestion;
									
									//on split les recommandations
									var strRec = '';
									var arrTmpRec = [];
									for(var q in gRecommandation[this.arrCurrentParcoursInfos.id][gParcours[o].grille[p].id]){
										var arrRec = gRecommandation[this.arrCurrentParcoursInfos.id][gParcours[o].grille[p].id][q].split(',');
										if(arrRec.length > 0){
											for(var r in arrRec){
												arrTmpRec.push(arrRec[r]);
												}
											}
										}
									if(arrTmpRec.length > 0){
										strRec += '<ul class="recommandation">';
										strRec += '<h5 class="recommandation">' + jLang.t('recommandations') + '</h5>';
										for(var q in arrTmpRec){
											strRec += '<li>';
											strRec += '' + gData.keyvalue.recommandations[arrTmpRec[q]] + '';
											//les conseils
											var strConseils = gData.conseils[arrTmpRec[q]].conseils;
											var arrConseils = false;
											if(strConseils != '' && strConseils !== false){
												arrConseils = strConseils.split(',');
												}
											//
											if(arrConseils !== false){
												strRec += '<div class="conseil"><small>';
												//strRec += '<p style="text-transform:uppercase;font-weight:bold;">' + jLang.t('conseils') + '</p>';		
												for(var r in arrConseils){
													strRec += gData.keyvalue.conseils[arrConseils[r]];
													}
												strRec += '</small></div>';	
												}
											//
											strRec += '</li>';
											}
										strRec += '</ul>';	
										}
									//
									strGrille += strRec;
									strGrille += '</div>';
									strGrille += '</li>';
									}
								}
							strGrille += '</ul>';	
							}
						break;	
						}	
					}	
			}else{
				//pas de recommandation alors 
				//on metg un message qui avertit usager
				strGrille = jLang.t('aucune recommandation');
				}
			str += strGrille;
			
			//on met un lien pour revenir au parcours actuel
			str += '<div class="row-fluid row-bottom-link-menu"><a id="butt-open-grille-listing-bottom">' + jLang.t('retour au parcours :') + '"' + this.arrCurrentParcoursInfos.name + '"</a></div>';
			
			//on ecrit
			$('#row-bottom').html(str);
			
			//action du lien bottom
			//retour au parcours actuel
			$('#butt-open-grille-listing-bottom').unbind();
			$('#butt-open-grille-listing-bottom').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.showParcours(true, true, true);
					}
				});
			
			$('#butt-open-all-rows').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openAllRows(true);
					}
				});
				
			$('#butt-close-all-rows').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openAllRows(false);
					}
				});	
				
			$('#butt-print-all').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openAllRows(true);
					window.print();	
					}
				});

			$('.rows-print').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openAllRows(false);
					oTmp.openRow($(this).attr('grille-id'));
					window.print();	
					}
				});			
		
				
			//les actions sur les divs
			//$('.rows').css({'cursor':'pointer'});
			$('.rows > .row-action').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openRow($(this).attr('grille-id'));
					}
				});
			
			
			}	
		
		
		};
	
	
	//-----------------------------------------------------------------------------------------*
	this.openAllRows = function(bOpen){
		this.debug('openAllRows()');
		//
		if(bOpen){
			$('.rows > .row-display').removeClass('hide');
			$('.rows').attr('opened', 1);
			$('.rows').addClass('print');
		}else{
			$('.rows > .row-display').addClass('hide');
			$('.rows').attr('opened', 0);
			$('.rows').removeClass('print');
			}
		};
	
	
	//-----------------------------------------------------------------------------------------*
	this.openRow = function(id){
		this.debug('openRow(' + id + ')');
		//
		if($('.rows[grille-id="' + id + '"]').attr('opened') == 1){
			$('.rows[grille-id="' + id + '"] > .row-display').addClass('hide');
			$('.rows[grille-id="' + id + '"]').attr('opened', 0);
			$('.rows[grille-id="' + id + '"]').removeClass('print');
			
		}else{
			$('.rows[grille-id="' + id + '"] > .row-display').removeClass('hide');
			$('.rows[grille-id="' + id + '"]').attr('opened', 1);
			$('.rows[grille-id="' + id + '"]').addClass('print');
			}
		};

		
	//-----------------------------------------------------------------------------------------*
	this.showGrille = function(bTop, bBottom){
		this.debug('showGrille(' + bTop + ',' + bBottom + ')');
		
		$(window).scrollTop(0);
				
		//on check si a seulementun row-bottom, pas de col-* pour celui-ci
		//on check le row-botttom si divise en deux
		var oDiv = $('#col-left');
		if(typeof(oDiv[0]) != 'undefined'){
			$('#row-bottom').html('');
			}
		
		var str;
				
		//top
		if(bTop){
			str = '';
			//menu
			str += '<a id="butt-open-parcours-listing">' + jLang.t('mes parcours') + '</a>';
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
			//str += '<a id="butt-open-grille-listing">' + jLang.t('parcours:') + ' ' + this.arrCurrentParcoursInfos.name + '</a>';
			str += '<a id="butt-open-grille-listing">' + jLang.t('mes grilles') + '</a>';
			str += '<br />';
			//content
			//str += '<h3>' + jLang.t('grille:') + ' ' + this.arrCurrentGrilleInfos.name + '</h3>';
			str += '<h3>';
			str += this.arrCurrentGrilleInfos.name;
			str += '<br /><small>' + gData.keyvalue.type[this.arrCurrentGrilleInfos.type] + ' / ' + gData.keyvalue.milieu[this.arrCurrentGrilleInfos.milieu] + '</small>';
			str += '</h3>'
			str += '<small class="submenu"><a id="butt-modify-grille-name">' + jLang.t('modifier le nom') + '</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="butt-modify-grille-desc">' + jLang.t('modifier la description') + '</a></small>';
			
			//str += '<p>' + jLang.t('description:') + ' ' + this.arrCurrentGrilleInfos.desc + '</p>';
			str += '<p><small>' + this.arrCurrentGrilleInfos.desc + '</small></p>';
			
			//check si le type est est une intersection
			var strSelect = '';
			//une intersection = 1 ou traverse = 3
			if(this.arrCurrentGrilleInfos.type == '1' || this.arrCurrentGrilleInfos.type == '3'){ 
			//if(this.arrCurrentGrilleInfos.type == '1'){ 
				//on va chercher le listing des troncon du parcours
				var arrGrille;
				for(var o in gParcours){
					if(gParcours[o].id == this.arrCurrentParcoursInfos.id){			
						arrGrille = gParcours[o].grille;
						break;
						}
					}	
					
				//this.debug('arrGrille', arrGrille);	
				//this.debug('this.arrCurrentGrilleInfos', this.arrCurrentGrilleInfos);
					
				//le select des troncon
				var strSelect = '';
				//strSelect += '<p>' + jLang.t('associer intersection a un troncon:') + '</p>';
				strSelect += '<p><select id="field-association-troncon" class="input-1">';	
				strSelect += '<option value="-1">' + jLang.t('selectionner un troncon') + '</option>';		
				for(var o in arrGrille){
					if(arrGrille[o].type == '2'){ //un troncon = 2
						strSelect += '<option value="' + o + '"';
						//check si etait selected
						if(this.arrCurrentGrilleInfos.rid != -1 && arrGrille[o].id == this.arrCurrentGrilleInfos.rid){
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
			//une intersection = 1 ou traverse = 3
			if(this.arrCurrentGrilleInfos.type == '1' || this.arrCurrentGrilleInfos.type == '3'){ 
			//if(this.arrCurrentGrilleInfos.type == '1'){ 
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
			this.arrCurrentQuestionsInfos = [];
			str = '';
			str += '<h4>' + jLang.t('les questions') + '</h4>';
			str += '<p><small>' + jLang.t('repondre aux questions du formulaire, remplir dans l\'ordre') + '</small></p>';
			
			//la liste de question relative au grille_id
			var oGrille = gData.grilles[this.arrCurrentGrilleInfos.gid];	
			
			//on va chercher les reponse si il y a 
			var arrReponse = false;
			for(var o in gParcours){
				if(gParcours[o].id == this.arrCurrentParcoursInfos.id){			
					arrReponse = gParcours[o].grille[this.arrCurrentGrilleInfos.id].reponse;
					break;
					}
				}		
			
			this.debug('oGrille', oGrille);
			this.debug('arrReponse', arrReponse);
			
			var strQuestion = '';
			strQuestion += '<ul id="listing-questions">';
			for(var o in oGrille.questions){
				var iReponse = false;
				strQuestion += '<li>';
				if(arrReponse === false){
					strQuestion += '<span question-id="' + oGrille.questions[o].id + '" class="left red">&#x26AB;</span>';
				}else{
					if(typeof(arrReponse[oGrille.questions[o].id]) != 'undefined'){
						iReponse = arrReponse[oGrille.questions[o].id];
						strQuestion += '<span question-id="' + oGrille.questions[o].id + '" class="left green">&#x26AB;</span>';
					}else{
						strQuestion += '<span question-id="' + oGrille.questions[o].id + '" class="left yellow">&#x26AB;</span>';
						}
					}
				strQuestion += '<a style="display:table-cell;" question-id="' + oGrille.questions[o].id + '">' + gData.keyvalue.questions[oGrille.questions[o].id] + '</a>';
				var strReponse = '';
				var iNumReponse = 0;
				if(typeof(oGrille.questions[o].reponses) != 'undefined'){
					strReponse += '<ul class="listing-reponses" question-id="' + oGrille.questions[o].id + '">';
					for(var p in oGrille.questions[o].reponses){
						strReponse += '<li question-id="' + oGrille.questions[o].id + '" reponse-id="' + oGrille.questions[o].reponses[p].id + '">';
						strReponse += '<input style="float:left;" type="radio" ';
						if(iReponse == oGrille.questions[o].reponses[p].id){
							strReponse += ' checked ';
							}
						strReponse += ' question-id="' + oGrille.questions[o].id + '" reponse-id="' + oGrille.questions[o].reponses[p].id + '" name="q' + oGrille.questions[o].id + '">';
						strReponse += gData.keyvalue.reponses[oGrille.questions[o].reponses[p].id];
						strReponse += '</li>';
						iNumReponse++;
						}	
					strReponse += '</ul>';	
					}
				strQuestion += strReponse + '</li>';
				//infos arr keep for when press the save butt
				this.arrCurrentQuestionsInfos[oGrille.questions[o].id] = {
					id: oGrille.questions[o].id,
					status: 0, 
					choix: oGrille.questions[o].reponses,
					reponse: false,
					bulles: oGrille.questions[o].bulles,
					};
				}
			strQuestion += '</ul>';
			//
			str += strQuestion
			
			//on rajoute un retour au parcours en lien
			//en ajotant le nom du parcours
			str += '<div class="row-fluid row-bottom-link-menu"><a id="butt-open-grille-listing-bottom">' + jLang.t('retour au parcours :') + '"' + this.arrCurrentParcoursInfos.name + '"</a></div>';
						
			//write
			$('#row-bottom').html(str);
			//action sur le LI questions
			$('#listing-questions > LI > A').unbind();
			$('#listing-questions > LI > A').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.openQuestionAide(parseInt($(this).attr('question-id')));
					}
				});
			//action on LI reponse
			$('.listing-reponses > LI, .listing-reponses > LI > INPUT[type=radio]').unbind();
			$('.listing-reponses > LI, .listing-reponses > LI > INPUT[type=radio]').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.clickOnReponse(parseInt($(this).attr('reponse-id')), parseInt($(this).attr('question-id')));
					}
				});
			//retour au parcours actuel
			$('#butt-open-grille-listing-bottom').unbind();
			$('#butt-open-grille-listing-bottom').click(function(e){
				e.preventDefault();
				//get parent class
				var oTmp = $(document).data('jappzclass');
				if(typeof(oTmp) == 'object'){
					oTmp.showParcours(true, true, true);
					}
				});	
			}
	
		
		};	
		
		
	//-----------------------------------------------------------------------------------------*
	this.setSaveState = function(bState){
		this.debug('setSaveState(' + bState + ')');
		
		//
		this.saved = bState;
		
		$('#connection').removeClass('notsaved saved on');
		if(this.saved){
			if(this.connection){
				$('#connection').addClass('saved');	
				}
		}else{
			if(this.connection){
				$('#connection').addClass('on');	
			}else{
				$('#connection').addClass('notsaved');	
				}
			}
		};
	

	//-----------------------------------------------------------------------------------------*
	this.openQuestionAide = function(id){
		this.debug('openQuestionAide(' + id + ')');
		var msg = '';
		if(typeof(this.arrCurrentQuestionsInfos[id]) != 'undefined'){
			var bId = this.arrCurrentQuestionsInfos[id].bulles;
			if(bId !== false){
				if(typeof(gData.keyvalue.bulles[bId.id]) != 'undefined'){
					var str = '';
					str += '<p><b>' + gData.keyvalue.questions[id] + '</b></p>';
					str += '<p>' + gData.keyvalue.bulles[bId.id] + '</p>';
					this.openAlert('alert', jLang.t('aide'), str, false);
				}else{
					msg += '<p><b>' + gData.keyvalue.questions[id] + '</b></p>';
					msg += jLang.t('desole! aucune aide disponible pour cette question.');
					}
			}else{
				msg += '<p><b>' + gData.keyvalue.questions[id] + '</b></p>';
				msg = jLang.t('desole! aucune aide disponible pour cette question.');
				}
			}
		if(msg != ''){
			this.openAlert('alert', jLang.t('aide'), msg, false);
			}
		};	

	//-----------------------------------------------------------------------------------------*
	this.clickOnReponse = function(rId, qId){	
		this.debug('clickOnReponse(' + rId + ', ' + qId + ')');	
		//om chnage le save state
		this.setSaveState(false);
		//on met le input a on
		$('.listing-reponses > LI[reponse-id="' + rId + '"][question-id="' + qId + '"] > input:radio').prop('checked', true);
		//on set la reponse dans le temps object
		this.arrCurrentQuestionsInfos[qId].reponse = rId;
		//on higlight le point
		$('#listing-questions > LI > SPAN[question-id="' + qId + '"]').removeClass('red yellow');	
		$('#listing-questions > LI > SPAN[question-id="' + qId + '"]').addClass('green');
		//on rajoute au gParcours
		for(var o in gParcours){
			if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
				if(gParcours[o].grille[this.arrCurrentGrilleInfos.id].reponse === false){
					gParcours[o].grille[this.arrCurrentGrilleInfos.id].reponse = [];
					}
				gParcours[o].grille[this.arrCurrentGrilleInfos.id].reponse[qId] = rId;	
				//on check si a repondu a toutes les questions
				var iNumReponse = 0; 
				for(var p in gParcours[o].grille[this.arrCurrentGrilleInfos.id].reponse){
					iNumReponse++;
					}
				var iNumQuestion = 0; 	
				for(var p in this.arrCurrentQuestionsInfos){
					iNumQuestion++;
					}
				if(iNumReponse == iNumQuestion){
					//alors on change le statuts de la grille du parcours comme quoi elle est pleine
					this.arrCurrentQuestionsInfos[qId].status = 2;
					gParcours[o].grille[this.arrCurrentGrilleInfos.id].status = 2; 
				}else if(iNumReponse == 0){
					this.arrCurrentQuestionsInfos[qId].status = 0;
					gParcours[o].grille[this.arrCurrentGrilleInfos.id].status = 0; 
				}else{
					this.arrCurrentQuestionsInfos[qId].status = 1;
					gParcours[o].grille[this.arrCurrentGrilleInfos.id].status = 1; 
					}
				break;
				}
			}
		//
		//this.debug('showGrille::arrCurrentQuestionsInfos', this.arrCurrentQuestionsInfos);	
		//this.debug('this.arrCurrentQuestionsInfos', this.arrCurrentQuestionsInfos);
		//this.debug('gParcours', gParcours);	
		/*
		this.arrCurrentQuestionsInfos[oGrille.questions[o].id] = {
			id: oGrille.questions[o].id,
			status: 0, 
			choix: oGrille.questions[o].reponses,
			reponse: false,
			bulles: oGrille.questions[o].bulles,
			};
		*/	
				
		};
		
		
	//-----------------------------------------------------------------------------------------*
	this.changeGrilleRefId = function(id){	
		this.debug('changeGrilleRefId(' + id + ')');	
		//om chnage le save state
		this.setSaveState(false);
		//on chnage la current grille dans le temp et le gparcours aussi
		for(var o in gParcours){
			if(gParcours[o].id == this.arrCurrentParcoursInfos.id){
				this.arrCurrentGrilleInfos.rid = id;
				gParcours[o].grille[this.arrCurrentGrilleInfos.id].rid = this.arrCurrentGrilleInfos.rid;	
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
		
		//om chnage le save state
		this.setSaveState(false);

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
		
		//om chnage le save state
		this.setSaveState(false);

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
		
		//to the top
		$(window).scrollTop(0);
				
		//on check le row-botttom si divise en deux
		var oDiv = $('#col-left');
		if(typeof(oDiv[0]) == 'undefined'){
			$('#row-bottom').html('<div class="span7" id="col-left"></div><div class="span5 box-blue" id="col-right"></div>');
			}
		
		this.arrCurrentParcoursInfos = false;
		this.arrCurrentGrilleInfos = false;
		this.arrCurrentQuestionsInfos = false;
		
		
		var str;
		
		//top
		if(bTop){
			str = '';
			str += '<h1>' + gTitle + '</h1>';
			str += '<p>' + gContent + '</p>';		
			$('#row-top').html(str);
			}
		
		//left
		if(bLeft){
			str = '';
			str += '<h4>' + jLang.t('vos parcours sauvegardes') + '</h4>';	
			str += '<p><small>' + jLang.t('cliquer sur un parcours pour l\'ouvrir.') + '</small></p>';
			if(gParcours.length > 0){
				str += '<ul id="listing-parcours">';
				for(var o in gParcours){
					str += '<li><span style="float: left;"><input type="checkbox" value="' + gParcours[o].id + '" ></span><a style="display:table-cell;" parcours-id="' + gParcours[o].id + '">' + gParcours[o].name + '</a></li>';
					}
				str += '</ul>';
				str += '<p><button class="btn" id="butt-delete-parcours"><small>' + jLang.t('supprimer') + '</small></button></p>';		
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
			str += '<h4>' + jLang.t('nouveau parcours') + '</h4>';
			str += '<p><small>' + jLang.t('pour creer une nouvelle session ecrire un nom.') + '</small></p>';
			str += '<p>' + jLang.t('nom du nouveau parcours:') + '</p>';
			str += '<p><input type="text" value="" id="field-parcours-name" class="input-1"></p>'
			str += '<p>' + jLang.t('description:') + '</p>';
			str += '<p><textarea id="field-parcours-desc" rows="4" class="input-1"></textarea></p>';	
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
		this.arrCurrentRecommandationsInfos = false;
		
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
		
		//to tthe top
		$(window).scrollTop(0);
		
		this.arrCurrentGrilleInfos = false;
		this.arrCurrentQuestionsInfos = false;
		
		//on check le row-botttom si divise en deux
		var oDiv = $('#col-left');
		if(typeof(oDiv[0]) == 'undefined'){
			$('#row-bottom').html('<div class="span7" id="col-left"></div><div class="span5 box-blue" id="col-right"></div>');
			}
		
		var str;
		
		//top
		if(bTop){
			str = '';
			str += '<a id="butt-open-parcours-listing">' + jLang.t('mes parcours') + '</a>';
			str += '<br />';
			//str += '<h3>' + jLang.t('parcours:') + ' ' + this.arrCurrentParcoursInfos.name + '</h3>';
			str += '<h3>' + this.arrCurrentParcoursInfos.name;
			//str += '<p class="verysmall">' + jLang.t('parcours') + '</p>';	
			str += '</h3>';
			str += '<small class="submenu"><a id="butt-modify-parcours-name">' + jLang.t('modifier le nom') + '</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="butt-modify-parcours-desc">' + jLang.t('modifier la description') + '</a></small>';
			//str += '<p>' + jLang.t('description:') + ' ' + this.arrCurrentParcoursInfos.desc + '</p>';		
			str += '<p><small>' + this.arrCurrentParcoursInfos.desc + '</small></p>';		
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
			//checher la parcours et ses grilles
			//avec arbre de troncon-intersection
			var bGrilleFinished = false;
			var arrKeepIntersection = []; //key:troncon id => oGrille
			var arrDisplay = []; //key:increment => oGrille ou key:pos => oGrille
			var strGrille = '';
			
			for(var o in gParcours){
				//le current parcours
				if(parseInt(gParcours[o].id) == parseInt(this.arrCurrentParcoursInfos.id)){
					//si initialise avec data dedans
					this.debug('', gParcours[o].grille);	
					if(gParcours[o].grille != '' && gParcours[o].grille !== false && gParcours[o].grille !== null){
						//on va chercher tout les troncon type = 2 et leurs intersections 
						//ou les intersections avec rid = -1
						var iCountGrille = 0;
						var iCountGrilleFinished = 0;
						for(var p in gParcours[o].grille){
							iCountGrille++;
							if(gParcours[o].grille[p].status == 2){
								iCountGrilleFinished++;
								}
							//si cest une intersection ou une traverse avec un troncon comme ref_id
							if( (gParcours[o].grille[p].type == 1 || gParcours[o].grille[p].type == 3) && 
							//if( gParcours[o].grille[p].type == 1 && 
								gParcours[o].grille[p].rid != -1){
								//init le array avec la key comme troncon id
								if(typeof(arrKeepIntersection[gParcours[o].grille[p].rid]) != 'object'){
									arrKeepIntersection[gParcours[o].grille[p].rid] = [];
									}
								arrKeepIntersection[gParcours[o].grille[p].rid].push(gParcours[o].grille[p]);	
							}else{
								//pour ceux afficher sur le premier niveau de l'arbre
								arrDisplay.push(gParcours[o].grille[p]);
								}
							}
						if(iCountGrilleFinished > 0 && iCountGrilleFinished == iCountGrille){
							bGrilleFinished = true;
							}
						//on loop ceux du arrDisplay en checkant pour les intersection dependante du troncon	
						strGrille += '<ul id="listing-grilles" class="link">';
						for(var p in arrDisplay){
							strGrille += '<li><span style="float: left;"><input type="checkbox" value="' + arrDisplay[p].id + '" ></span>';
							//status
							if(arrDisplay[p].status === 2){
								strGrille += '<span class="right green">&#x26AB;</span>';
							}else if(arrDisplay[p].status === 1){
								strGrille += '<span class="right yellow">&#x26AB;</span>';	
							}else{
								strGrille += '<span class="right red">&#x26AB;</span>';
								}
							strGrille += '<a style="display:table-cell;" grille-id="' + arrDisplay[p].id + '">' + arrDisplay[p].name + '</a>';
							strGrille += '</li>';
							//on check si des intersection ou traverse dependantes
							if(typeof(arrKeepIntersection[arrDisplay[p].id]) == 'object'){
								for(var q in arrKeepIntersection[arrDisplay[p].id]){
									strGrille += '<li style="margin-left:30px;">';
									strGrille += '<div class="arrow-right"></div>';
									strGrille += '<span style="float: left;"><input type="checkbox" value="' + arrKeepIntersection[arrDisplay[p].id][q].id + '" ></span>';
									//status
									if(arrKeepIntersection[arrDisplay[p].id][q].status == 2){
										strGrille += '<span class="right green">&#x26AB;</span>';
									}else if(arrKeepIntersection[arrDisplay[p].id][q].status == 1){
										strGrille += '<span class="right yellow">&#x26AB;</span>';	
									}else{
										strGrille += '<span class="right red">&#x26AB;</span>';
										}
									strGrille += '<a style="display:table-cell;" grille-id="' + arrKeepIntersection[arrDisplay[p].id][q].id + '">' + arrKeepIntersection[arrDisplay[p].id][q].name + '</a>';
									strGrille += '</li>';
									}
								}
							}
						strGrille += '</ul>';		
						}	
					break;	
					}		
				}
			
			/*
			//checsi a termine
			str += '<h4>' + jLang.t('vos recommandations') + '</h4>';	
			str += '<p><small>' + jLang.t('texte introduction aux recommandations') + '</small></p>';
			if(bGrilleFinished){
				str += '<p id="grille-loading-layer"><button class="btn" id="butt-show-recommandation">' + jLang.t('voir les recommandations') + '</button></p>';	
			}else{
				str += '<p>' + jLang.t('vous devez repondre a toutes les questions des grilles avec statut jaune/gris pour acceder aux recommandations.') + '</p>';	
				}
			*/
			
			
			//les grilles sauvegardees
			str += '<div class="row-fluid">';
			str += '<div class="span12">';
			str += '<h4>' + jLang.t('vos grilles sauvegardees') + '</h4>';	
			str += '<p><small>' + jLang.t('cliquer sur une grille pour l\'ouvrir.') + '</small></p>';
			//check si vide		
			if(strGrille == ''){
				str += '<p>' + jLang.t('aucune grille sauvegardee') + '</p>';
			}else{
				str += strGrille;
				str += '<p><button class="btn" id="butt-delete-grilles"><small>' + jLang.t('supprimer') + '</small></button></p>';	
				}
			str += '</div>';	
			str += '</div>';	
				
			//les recommandations	
			//checsi a termine
			str += '<div class="row-fluid">';
			str += '<div class="span12 box-recommandation">';
			str += '<h4>' + jLang.t('vos recommandations') + '</h4>';	
			str += '<p><small>' + jLang.t('texte introduction aux recommandations') + '</small></p>';
			if(bGrilleFinished){
				str += '<p id="grille-loading-layer"><button class="btn" id="butt-show-recommandation">' + jLang.t('voir les recommandations') + '</button></p>';	
			}else{
				str += '<p>' + jLang.t('vous devez repondre a toutes les questions des grilles avec statut jaune/gris pour acceder aux recommandations.') + '</p>';	
				}
			str += '</div>';	
			str += '</div>';	
			
			//on ecrit	
			$('#row-bottom > #col-left').html(str);
			
			//voir
			//checsi a termine
			if(bGrilleFinished){
				//action voir
				$('#butt-show-recommandation').unbind();
				$('#butt-show-recommandation').click(function(e){
					e.preventDefault();
					//get parent class
					var oTmp = $(document).data('jappzclass');
					if(typeof(oTmp) == 'object'){
						oTmp.openRecommandation($(this));
						}
					});
				}
			
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
			str += '<h4>' + jLang.t('nouvelle grille') + '</h4>';
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
			for(var o in gData.keyvalue.typeOrder){
				str += '<option value="' + gData.keyvalue.typeOrder[o] + '">' + gData.keyvalue.type[gData.keyvalue.typeOrder[o]] + '</option>';	
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
			str += '<p><textarea id="field-grille-desc" rows="4" class="input-1"></textarea></p>';	
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
		this.debug('createGrille()');
		
		$('#field-grille-type').removeClass('error');
		$('#field-grille-milieu').removeClass('error');
		$('#field-grille-name').removeClass('error');
		//$('#field-grille-desc').removeClass('error');
		
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
		/*
		if(strDesc == ''){
			arrField.push('#field-grille-desc');
			}
		*/	
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
		
		var oButts = this.openAlert('comfirm', jLang.t('warning!'), jLang.t('voulez vous vraiment supprimer les elements selectionnes.'), false);
		
		//le save action
		$(oButts.save).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.closeAlert();
				oTmp.deleteGrilleComfirm();
				}
			});
		}

	//-----------------------------------------------------------------------------------------*
	this.deleteGrilleComfirm = function(){	
		this.debug('deleteGrilleComfirm()');
	
	
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
		
		//om chnage le save state
		this.setSaveState(false);
		
		var parcoursId = false;
		//on supprime le data du array et on fait un refresh de la section
		for(var o in gParcours){
			if(parseInt(gParcours[o].id) == parseInt(this.arrCurrentParcoursInfos.id)){
				for(var q in arr){
					delete(gParcours[o].grille[arr[q]]);
					}
				parcoursId = o;
				break;
				}
			}
			
		//si cest un troncon qui est supprime, 
		//verifier si il est dans les ref_id dune autre grille et le mettre a -1
		for(var o in gParcours[parcoursId].grille){
			for(var p in arr){
				if(gParcours[parcoursId].grille[o].rid == arr[p]){
					gParcours[parcoursId].grille[o].rid = -1;
					}
				}
			}
				
			
		//refresh le listnig des grilles	
		this.showParcours(false, true, false);
		};	
			
			
	//-----------------------------------------------------------------------------------------*
	this.getGrilleLastId = function(oGrille){
		this.debug('getGrilleLastId::oGrille', oGrille);
		var last = 0;
		for(var o in oGrille){
			last = o;
			}
		return ++last; 	
		};
			

	//-----------------------------------------------------------------------------------------*
	this.createGrilleRFS = function(data, extraObj){	
		this.debug('createGrilleRFS::data', data);	
		this.debug('createGrilleRFS::extraObj', extraObj);

		//om chnage le save state
		this.setSaveState(false);
				
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
					gid: gData.grilles[o].id,
					rid: -1, //pour intersection a troncon
					name: data.name,
					desc: data.desc,
					date: Date.now(),
					type: data.type,
					milieu: data.milieu,
					reponse: false,
					status: 0
					}
				break;
				}
			}
		
		//on rajoute au grille de parcours du user
		var parcoursId = false;
		if(oGrille !== false){
			for(var o in gParcours){
				if(parseInt(gParcours[o].id) == parseInt(this.arrCurrentParcoursInfos.id)){
					//on push la nouvelle grille
					if(typeof(gParcours[o].grille) != 'object' || gParcours[o].grille === null || gParcours[o].grille === ''){
						gParcours[o].grille = {};
						}
					var grilleId = this.getGrilleLastId(gParcours[o].grille);	
					//gParcours[o].grille.push(oGrille);	
					gParcours[o].grille[grilleId] = oGrille;	
					parcoursId = o;
					break;
					}
				}
			}
			
		//on set le id de la grille base sur sa position dans le array	
		if(parcoursId){
			for(var o in gParcours[parcoursId].grille){
				gParcours[parcoursId].grille[o].id = o;
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
		
		//om chnage le save state
		this.setSaveState(false);

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
		
		//om chnage le save state
		this.setSaveState(false);

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
		
		//om chnage le save state
		this.setSaveState(false);

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
		
		if(!this.connection){
			this.openAlert('alert', jLang.t('warning!'), jLang.t('vous devez etre connecte pour creer un parcours'), false);	
			return;
			}
		
		//om chnage le save state
		this.setSaveState(false);			
				
		$('#field-parcours-name').removeClass('error');
		//$('#field-parcours-desc').removeClass('error');
		
		var strName = $('#field-parcours-name').val();
		var strDesc = $('#field-parcours-desc').val();
		
		//validation
		var arrField = [];
		if(strName == ''){
			arrField.push('#field-parcours-name');
			}
		/*
		if(strDesc == ''){
			arrField.push('#field-parcours-desc');
			}
		*/	
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
				if(gParcours === false){
					gParcours = [];	
					}
				gParcours.push({
					id: parseInt(data.id),
					desc: extraObj.desc,
					name: extraObj.name,		
					grille: '',		
					});
				//refresh	
				this.showParcoursMainPage(false, true, true);
				}
			}
		
		
		
		};	

		
	//-----------------------------------------------------------------------------------------*
	this.deleteParcours = function(){
		this.debug('deleteParcours()');
		
		var oButts = this.openAlert('comfirm', jLang.t('warning!'), jLang.t('voulez vous vraiment supprimer les elements selectionnes.'), false);
		
		//le save action
		$(oButts.save).click(function(e){
			e.preventDefault(); 
			//get parent class
			var oTmp = $(document).data('jappzclass');
			if(typeof(oTmp) == 'object'){
				oTmp.closeAlert();
				oTmp.deleteParcoursComfirm();
				}
			});
		}
		
	//-----------------------------------------------------------------------------------------*
	this.deleteParcoursComfirm = function(){	
		this.debug('deleteParcoursComfirm()');
		
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
		
		if(!this.connection){
			this.openAlert('alert', jLang.t('warning!'), jLang.t('vous devez etre connecte pour supprimer un parcours'), false);	
			return;
			}
		
		//om chnage le save state
		this.setSaveState(false);
		
		var objServer = {
			ids: arr.toString(),
			};
		var objLocal = {
			ids: arr,
			};
		
		$('#butt-delete-parcours').unbind();
		$('#butt-delete-parcours').html('<small>' + jLang.t('processing') + '</small>' );
			
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
	this.saveParcoursRFS = function(data, extraObj){	
		this.debug('saveParcoursRFS::data', data);	
		this.debug('saveParcoursRFS::extraObj', extraObj);

		//
		if(typeof(data.error) != 'undefined' && typeof(data.errormessage) != 'undefined'){
			if(parseInt(data.error) == 1){
				this.openAlert('alert', jLang.t('warning!'), data.errormessage, false);	
				return;
				}
			return;	
			}
		
		if(typeof(data.ok) != 'undefined'){
			if(parseInt(data.ok) == 1){
				this.setSaveState(true);	
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
		}else if(type == 'comfirm'){
			$('#modal-alert ' + strSaveButtName).html(jLang.t('yes'));
			$('#modal-alert ' + strSaveButtName).show();
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
	this.pingService = function(){	
		this.debug('pingService()');	
		
		var objLocal = {
			alert: false,
			};
		
		this.jcomm.process(this, 'parcours', 'ping', {}, objLocal);
		};	
	
	
	//-----------------------------------------------------------------------------------------*
	this.saveParcours = function(){	
		this.debug('saveParcours()');	
		//clean object
		this.cleanParcoursObject();
		//save to cokkie
		//this.saveParcoursCookie();
		
		//send data
		if(this.connection && !this.saved){
			var objServer = {
				parcours: gParcours,
				};
			var objLocal = {
				};	
			this.jcomm.process(this, 'parcours', 'save-parcours', objServer, objLocal);
			}
		};
		
		
	//-----------------------------------------------------------------------------------------*
	this.saveParcoursCookie = function(){
		//on en met une copir dans un cookie si jamais pas de connection ou perte de data	
		var str = JSON.stringify(gParcours);
		var iBlockSize = 4000;
		//on split en 4000 bytes max par cookie
		var arr = [];
		var cmpt = 0;
		for(var i=0; i<str.length; i=i+iBlockSize){
			arr[cmpt] = str.substring(i, (i + iBlockSize));
			cmpt++;
			}
		createCookie('numParcours', cmpt);
		for(var o in arr){
			createCookie('gParcours-' + o, arr[o]);
			}
		/*
		this.debug('cookie', JSON.parse(readCookie('gParcours')));
		*/		
				
		};

		
	//-----------------------------------------------------------------------------------------*
	this.cleanParcoursObject = function(){	
		this.debug('cleanParcoursObject()');	
		
		var obj = [];
		
			
		for(var o in gParcours){
			//check le parcours
			if(gParcours[o] === null || gParcours[o] == '' || gParcours[o] == 'null' || gParcours[o] == 'undefined'){
				//this.debug('CLEAN-PARCOURS[' + o + ']');
				delete(gParcours[o]);
			}else{
				//check les grilles a null
				if(typeof(gParcours[o].grille) === 'object'){
					for(var p in gParcours[o].grille){
						if(gParcours[o].grille[p] === null  || gParcours[o].grille[p] == '' || gParcours[o].grille[p] == 'null' || gParcours[o].grille[p] == 'undefined'){
							//this.debug('CLEAN-GRILLE[' + p + ']');
							delete(gParcours[o].grille[p]);
						}else{
							//check les reponses a null
							if(gParcours[o].grille[p].reponse !== false && gParcours[o].grille[p].reponse != ''){
								for(var q in gParcours[o].grille[p].reponse){
									if(gParcours[o].grille[p].reponse[q] === null || gParcours[o].grille[p].reponse[q] == ''  || gParcours[o].grille[p].reponse[q] == 'undefined'){
										//this.debug('CLEAN-REPONSE[' + q + ']');
										delete(gParcours[o].grille[p].reponse[q]);
										}
									}
								}
							}
						}
					}
				}
			}
			
		//on va faire un premier classement de parcours
		//si n'a pas deja ete fait
		/*
		if(!gPosition.length){
			for(var o in gParcours){
				var arrTmp = [];
				var pos = 5;
				for(var p in gParcours[o].grille){
					if(gParcours[o].grille[p].type == 2){
						var newPos = (typeof(gParcours[o].grille[p].pos) == 'undefined')? 50 : gParcours[o].grille[p].pos;
						arrTmp.push({
							grille_id: gParcours[o].grille[p].id,
							pos: newPos,
							child: []
							})		
					}else if(gParcours[o].grille[p].rid == -1){
						//les intersection ou traverse qui n'ont pas encore de troncon assigne
						var newPos = (typeof(gParcours[o].grille[p].pos) == 'undefined')? 100 : gParcours[o].grille[p].pos;
						arrTmp.push({
							grille_id: gParcours[o].grille[p].id,
							pos: newPos,
							child: false
							})
						}
					}
				gPosition[o] = arrTmp;		
				}	
			//on va chercher les intersection et traverse de chaque grille troncon
			for(var o in gPosition){
				for(var p in gPosition[o]){
					var pos = 1;
					//il faut que ce soit un troncon
					if(gPosition[o][p].child !== false){
						for(var q in gParcours[o].grille){
							if(gPosition[o][p].grille_id == gParcours[o].grille[q].rid){
								var newPos = (typeof(gParcours[o].grille[q].pos) == 'undefined')? pos++ : gParcours[o].grille[q].pos;
								gPosition[o][p].child.push({
									id: gParcours[o].grille[q].id,
									pos: newPos
									});		
								}
							}	
						}
					}
				}
			console.warn(gPosition);		
			}
		*/	
		
								
			
			
		this.debug('gParcours(1)', gParcours);	
			
		};	

		
	//-----------------------------------------------------------------------------------------*
	this.pingServiceRFS = function(data, extraObj){
		this.debug('pingServiceRFS::data', data);	
		this.debug('pingServiceRFS::extraObj', extraObj);	
		//
		if(typeof(data.ok) != 'undefined'){
			this.connection = true;
			this.setSaveState(this.saved);
		}else{
			//can be data error ou server connection error
			this.connection = false;
			this.setSaveState(this.saved);
			}
		//			
		};

		
	//-----------------------------------------------------------------------------------------*	
	this.commCallBackFunc = function(pid, obj, extraObj){
		this.debug('commCallBackFunc(' + pid + ')');
		this.debug('commCallBackFunc::obj', obj);
		this.debug('commCallBackFunc::extraObj', extraObj);
		
		//
		if(typeof(obj.msgerrors) != 'undefined' && obj.msgerrors != ''){
			this.debug('obj.msgerrors', obj.msgerrors);
			if(typeof(extraObj.alert) == 'undefined'){
				this.openAlert('error', jLang.t('error!'), obj.msgerrors, false);
				}
			//une maniere ou autre on set la connection
			this.pingServiceRFS(false, false);		
		
		}else{
			if(obj.section == 'parcours'){
				if(obj.service == 'delete'){
					this.deleteSelectedParcoursRFS(obj.data, extraObj);
				}else if(obj.service == 'create'){
					this.createParcoursRFS(obj.data, extraObj);	
				}else if(obj.service == 'ping'){
					this.pingServiceRFS(obj.data, extraObj);	
				}else if(obj.service == 'save-parcours'){
					this.saveParcoursRFS(obj.data, extraObj);	
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






