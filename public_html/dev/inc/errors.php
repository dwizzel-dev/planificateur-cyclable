<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	fichier des erreurs avec code_id

*/

// GLOBAL
$gErrors = array();


//-------------------------------------------------
//[100-200] erreur generic
$gErrors['100'] = _T('generic errors');
$gErrors['101'] = _T('user et password non trouve');
$gErrors['102'] = _T('votre session est terminee');
$gErrors['103'] = _T('votre session est invalide, veuiller vous reconnecter');
$gErrors['111'] = _T('tous les champs doivent etre remplis');
$gErrors['112'] = _T('le nouveau mot de passe et sa repetition doivent etre identique');
$gErrors['113'] = _T('password must contain');
$gErrors['114'] = _T('ancien mot de passe non valide');
$gErrors['115'] = _T('adresse courriel deja utilisee');
$gErrors['116'] = _T('adresse courriel n existe pas dans notre base de donnee');
$gErrors['117'] = _T('le mot de pass a ete envoye a votre adresse courriel');
$gErrors['118'] = _T('vous etes deja inscrit');
$gErrors['119'] = _T('le numero de telephone n est pas valide');

//***********************************************************************************************

//[200-300] erreur de code d'acces lors de l'inscription
$gErrors['201'] = _T('code acces invalide');

//***********************************************************************************************

//[300-400] erreur de session ou de variable non defini
$gErrors['301'] = _T('votre session ne pas valide veuiller vous connecter pour reprendre');

//***********************************************************************************************

//[400-500] erreur de session ou de variable non defini
$gErrors['401'] = _T('votre session ne pas valide veuiller vous connecter pour reprendre');
$gErrors['402'] = _T('vous devez fournir une adresse courriel valide');
$gErrors['403'] = _T('votre courriel est pas dans la db infolettre');
$gErrors['404'] = _T('les champs ne peuvent etre vides');

//***********************************************************************************************

//[500-600] erreur du module postal
$gErrors['501'] = _T('une erreur est survenu durant la calcul postal');

//***********************************************************************************************

//[600-700] err/cfrm du panier/recherche
$gErrors['601'] = _T('votre panier est vide');
$gErrors['602'] = _T('merci!');
$gErrors['603'] = _T('aucun resultat pour votre recherche');
$gErrors['604'] = _T('vous devez etre connecte pour effectuer ou visionner une commande');
$gErrors['605'] = _T('votre commande est vide');
$gErrors['606'] = _T('desole, une erreur est survenu lors de recuperation de votre adresse');
$gErrors['607'] = _T('une erreur durant le calcul postal est survenu');
$gErrors['608'] = _T('desole, une erreur est survenu lors de la recuperation de la facture');
$gErrors['609'] = _T('votre liste de favoris est vide');
$gErrors['610'] = _T('votre avez aucun historique de commande');
$gErrors['611'] = _T('les items en rouge neccessitent une modification, car la quantite demande depasse la quantite en inventaire');
$gErrors['612'] = _T('code de promotion non valide');

//***********************************************************************************************

//[1100-1300] erreur de process credit card de base
$gErrors['1100'] = _T('card number not valid');
$gErrors['1101'] = _T('card expiration date not valid');
$gErrors['1102'] = _T('amount is not valid');
$gErrors['1103'] = _T('currency not allowed');
$gErrors['1104'] = _T('curl function not found');

$gErrors['1200'] = _T('vous avez atteint le maximum de tentative de transaction');
$gErrors['1201'] = _T('votre transaction est refuse');
$gErrors['1202'] = _T('votre numero de carte est invalide');
$gErrors['1203'] = _T('la date est invalide');
$gErrors['1204'] = _T('le delai attente est depasse, veuillez recommencer plus tard');
$gErrors['1205'] = _T('le delai attente est depasse [2], veuillez recommencer plus tard');
$gErrors['1206'] = _T('une erreur generique est survenue, la transaction nna pas eu lieu');
$gErrors['1207'] = _T('vous avez atteint le mximum essai verifier le probleme au pres de votre compagnie de carte de cerdit ou passer directement a la boutique');


//***********************************************************************************************

//[2000-2100] confirmarion plutot que des erreurs mais traite de la meme maniere
$gErrors['2000'] = _T('votre demande est envoyee, merci!...');
$gErrors['2001'] = _T('votre mot de passe est modifie, merci!...');
$gErrors['2002'] = _T('votre paiement est effectue');
$gErrors['2003'] = _T('votre demande emploi est effectuee');
$gErrors['2004'] = _T('votre insciption a la liste infolettre est effectuee');
$gErrors['2005'] = _T('votre courriel est retire de la liste infolettre');
$gErrors['2006'] = _T('votre commentaire nous a ete soummis');
$gErrors['2007'] = _T('la modification est effectuee');
$gErrors['2008'] = _T('votre profil est modifie');
$gErrors['2009'] = _T('bienvenue dans votre compte personnel');
$gErrors['2010'] = _T('votre message nous a ete transmis, merci!...');






//END