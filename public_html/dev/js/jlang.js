/*

Author: DwiZZel
Date: 15-03-2016
Notes:	
		
*/

//----------------------------------------------------------------------------------------------------------------------

function JLang(){

	this.className = 'JLang';
	this.tx = [];

	//-----------------------------------------------------------------------------------------*		
	this.init = function(){
		this.debug('init()');	
		with(this){
			tx['bienvenue'] = 'Bienvenue!';
			//
			tx['_conn_mode'] = 'mode non connecté';
			tx['on_conn_mode'] = 'sauvegarde en cours!';
			tx['saved_conn_mode'] = 'sauvegarde effectuée!';
			tx['notsaved_conn_mode'] = 'erreur de sauvegarde! problême de connection internet';
			//
			tx['fermer'] = 'fermer';
			tx['sauvegarder'] = 'sauvegarder';
			tx['aide'] = 'aide';
			tx['error!'] = 'Erreur!';
			tx['modification'] = 'modification';
			tx['mes parcours'] = 'retour aux parcours';
			tx['parcours:'] = 'parcours:';
			tx['modifier le nom'] = 'modifier le nom';
			tx['modifier la description'] = 'modifier la description';
			tx['grille:'] = 'grille:';
			tx['description:'] = 'description:';
			tx['associer intersection a un troncon:'] = 'associer intersection a un troncon:';
			tx['selectionner un troncon'] = 'sélectionner un tronçon à associer';
			tx['nom de la grille: '] = 'nom de la grille: ';
			tx['description de la grille: '] = 'description de la grille: ';
			tx['vos parcours sauvegardes'] = 'vos parcours sauvegardes';
			tx['cliquer sur un parcours pour l\'ouvrir.'] = 'cliquer sur un parcours pour l\'ouvrir.';
			tx['supprimer'] = 'supprimer';
			tx['aucun parcours sauvegarde'] = 'aucun parcours sauvegarde';
			tx['nouveau parcours'] = 'nouveau parcours';
			tx['pour creer une nouvelle session ecrire un nom.'] = 'pour creer une nouvelle session ecrire un nom.';
			tx['nom du nouveau parcours:'] = 'nom du nouveau parcours:';
			tx['creer le parcours'] = 'creer le parcours';
			tx['vos grilles sauvegardees'] = 'vos grilles sauvegardees';
			tx['cliquer sur une grille pour l\'ouvrir.'] = '<div class="row-fluid"><div class="span12"><p>Les points situés à la droite du nom des grilles vous indiquent l\'état de celle-ci:</p><ul><li><span class="recom-dot red left"></span> : <i>Aucune question n\'a été répondu</i></li><li><span class="recom-dot yellow left"></span> : <i>Il reste des questions sans réponse</i></li><li><span class="recom-dot green left"></span> : <i>toutes les questions sont complétées</i></li></ul><p>Lorsque vous aurez fait vos choix, le point se changera en vert et vous aurez accès aux recommandations.</p><p><b>Vous pouvez cliquer sur une grille pour l\'ouvrir.</b></p></div></div>';
			tx['aucune grille sauvegardee'] = 'aucune grille sauvegardee';
			tx['nouvelle grille'] = 'nouvelle grille';
			tx['pour creer une nouvelle grille ecrire un nom.'] = 'pour creer une nouvelle grille ecrire un nom.';
			tx['format de grille:'] = 'format de grille:';
			tx['selectionner un type'] = 'selectionner un type';
			tx['selectionner un milieu'] = 'selectionner un milieu';
			tx['nom de la nouvelle grille:'] = 'nom de la nouvelle grille:';
			tx['creer la grille'] = 'creer la grille';
			tx['nom du parcours: '] = 'nom du parcours: ';
			tx['description du parcours: '] = 'description du parcours: ';
			tx['mes grilles'] = 'retour aux grilles';
			tx['les questions'] = 'les questions';
			tx['repondre aux questions du formulaire, remplir dans l\'ordre'] = 'repondre aux questions du formulaire, remplir dans l\'ordre';
			tx['parcours'] = 'parcours';
			tx['desole! aucune aide disponible pour cette question.'] = 'desole! aucune aide disponible pour cette question.';
			tx['processing'] = 'analyse';
			tx['mes recommandations'] = 'mes recommandations';
			tx['mes recommandations texte introduction'] = 'mes recommandations texte introduction';
			tx['ouvrir toutes les grilles'] = 'ouvrir toutes les grilles';
			tx['fermer toutes les grilles'] = 'fermer toutes les grilles';
			tx['print all'] = 'tout imprimer';
			tx['print grille'] = 'imprimer';
			tx['questions'] = 'questions';
			tx['recommandations'] = 'recommandations';
			tx['conseils'] = 'conseils';
			tx['vos recommandations'] = 'vos recommandations';
			tx['texte introduction aux recommandations'] = 'texte introduction aux recommandations';
			tx['voir les recommandations'] = 'voir les recommandations';
			tx['vous devez repondre a toutes les questions des grilles avec statut jaune/gris pour acceder aux recommandations.'] = 'vous devez repondre a toutes les questions des grilles avec statut jaune/gris pour acceder aux recommandations.';
			tx['server error on service call:'] = 'server error on service call:';
			tx['service error:'] = 'service error:';
			tx['server error on service call:'] = 'server error on service call:';
			tx['Not connected.\nPlease verify your network connection.'] = 'Not connected.\nPlease verify your network connection.';
			tx['The requested page not found. [404]'] = 'The requested page not found. [404]';
			tx['Internal Server Error [500].'] = 'Internal Server Error [500].';
			tx['Requested JSON parse failed.'] = 'Requested JSON parse failed.';
			tx['Time out error.'] = 'Time out error.';
			tx['Ajax request aborted.'] = 'Ajax request aborted.';
			tx['warning!'] = 'Attention!';
			tx['yes'] = 'oui';
			tx['voulez vous vraiment supprimer les elements selectionnes.'] = 'Voulez-vous vraiment supprimer les élements sélectionnés ?';
			tx['retour au parcours :'] = 'retour au parcours :';
			tx['aucune recommandation'] = ' Si aucune recommandation n\'apparaît après avoir répondu à toutes les questions, la raison en est qu\'un tel scénario a été jugé improbable lors de la conception de l\'outil.';
			}
		}
	
	//-----------------------------------------------------------------------------------------*	
	//get the text by key or return the key with tilde
	this.t = function(key){
		if(typeof(this.tx[key]) == 'string'){
			return this.tx[key];
			}
		return '[' + key + ']';
		}
		
	//-----------------------------------------------------------------------------------------*
	this.debug = function(){
		if(typeof(jDebug) == 'object'){
			if(arguments.length == 1){	
				jDebug.show(this.className + '::' + arguments[0]);
			}else{
				jDebug.showObject(this.className + '::' + arguments[0], arguments[1]);
				}
			}	
		}	
		
	}


//CLASS END