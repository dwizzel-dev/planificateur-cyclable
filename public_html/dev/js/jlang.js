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
			tx['aide'] = 'Aide';
			tx['error!'] = 'Erreur!';
			tx['modification'] = 'modification';
			tx['mes parcours'] = 'retour aux parcours';
			tx['parcours:'] = 'parcours:';
			tx['modifier le nom'] = 'modifier le nom';
			tx['modifier la description'] = 'modifier la description';
			tx['grille:'] = 'grille:';
			tx['description:'] = 'description:';
			tx['associer intersection a un troncon:'] = 'Associer une intersection à un tronçon:';
			tx['selectionner un troncon'] = 'Sélectionner un tronçon à associer';
			tx['nom de la grille: '] = 'Nom de l\'aménagement: ';
			tx['description de la grille: '] = 'Description de l\'aménagement: ';
			tx['vos parcours sauvegardes'] = 'vos parcours sauvegardés';
			tx['cliquer sur un parcours pour l\'ouvrir.'] = 'cliquer sur un parcours pour l\'ouvrir.';
			tx['supprimer'] = 'supprimer';
			tx['aucun parcours sauvegarde'] = 'Aucun parcours sauvegardé';
			tx['nouveau parcours'] = 'nouveau parcours';
			tx['pour creer une nouvelle session ecrire un nom.'] = 'Pour créer une nouvelle session, écrire un nom.';
			tx['nom du nouveau parcours:'] = 'Nom du nouveau parcours:';
			tx['creer le parcours'] = 'créer le parcours';
			tx['vos grilles sauvegardees'] = 'Vos aménagements (tronçon, intersection ou traversée) sauvegardés';
			tx['cliquer sur une grille pour l\'ouvrir.'] = '<div class="row-fluid"><div class="span12"><p>Les points situés à la droite du nom des aménagements vous indiquent l\'état de celui-ci:</p><ul><li><span class="recom-dot red left"></span> : <i>Aucune question n\'a été répondue</i></li><li><span class="recom-dot yellow left"></span> : <i>Il reste des questions sans réponse</i></li><li><span class="recom-dot green left"></span> : <i>Toutes les questions sont complétées</i></li></ul><p>Lorsque vous aurez fait vos choix, le point se changera en vert et vous aurez accès aux recommandations.</p><p><b>Vous pouvez cliquer sur un aménagement (tronçon, intersection ou traverse) pour l\'ouvrir.</b></p></div></div>';
			tx['aucune grille sauvegardee'] = 'Aucun aménagement sauvegardé';
			tx['nouvelle grille'] = 'Nouvel aménagement';
			tx['pour creer une nouvelle grille ecrire un nom.'] = 'Pour créer un nouvel aménagement (tronçon, intersection ou traverse), écrire un nom.';
			tx['format de grille:'] = 'Type d\'aménagement:';
			tx['selectionner un type'] = 'Sélectionner un type';
			tx['selectionner un milieu'] = 'Sélectionner un milieu';
			tx['nom de la nouvelle grille:'] = 'Nom du nouvel aménagement:';
			tx['creer la grille'] = 'Créer le nouvel aménagement';
			tx['nom du parcours: '] = 'Nom du parcours: ';
			tx['description du parcours: '] = 'Description du parcours: ';
			tx['mes grilles'] = 'retour à l\'aménagement';
			tx['les questions'] = 'les questions';
			tx['repondre aux questions du formulaire, remplir dans l\'ordre'] = 'Répondre à toutes les questions du formulaire. Cliquer sur la question pour afficher la bulle d\'aide';
			tx['parcours'] = 'parcours';
			tx['desole! aucune aide disponible pour cette question.'] = 'Désolé! Aucune aide disponible pour cette question.';
			tx['processing'] = 'analyse';
			tx['mes recommandations'] = 'mes recommandations';
			tx['mes recommandations texte introduction'] = 'Pour consulter les recommandations, cliquer sur l\'aménagement.<br /><br />Si aucune recommandation n\'apparaît pour un de vos aménagements, la raison en est qu\'un tel scénario a été jugé improbable lors de la conception de l\'outil. Vérifiez que toutes les questions ont été bien répondues.';
			tx['ouvrir toutes les grilles'] = 'Ouvrir tous les items';
			tx['fermer toutes les grilles'] = 'Fermer tous les items';
			tx['print all'] = 'tout imprimer';
			tx['print grille'] = 'imprimer';
			tx['questions'] = 'questions';
			tx['recommandations'] = 'recommandations';
			tx['conseils'] = 'conseils';
			tx['vos recommandations'] = 'vos recommandations';
			tx['texte introduction aux recommandations'] = 'Pour consulter les recommandations d’aménagement de chacun des items de ce parcours, cliquer sur le bouton ci-dessous';
			tx['voir les recommandations'] = 'voir les recommandations';
			tx['vous devez repondre a toutes les questions des grilles avec statut jaune/gris pour acceder aux recommandations.'] = 'Vous devez répondre à toutes les questions de chaque aménagement comprenant un statut jaune ou gris pour accéder aux recommandations.';
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
			tx['retour au parcours :'] = 'Retour au parcours :';
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