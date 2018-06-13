<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	service page for ajax admin

*/

// ERROR REPORTING
error_reporting(E_ALL);

// BASE DEFINE
require_once('define.php');

// CHECK IF SITE IS DOWN AND DEV PERMISSION 
if(SITE_IS_DOWN){
	if(isset($_SERVER["REMOTE_ADDR"])){
		if(!in_array($_SERVER["REMOTE_ADDR"],explode(",",REMOTE_ADDR_ACCEPTED))){
			Header('Location: '.PATH_OFFLINE);
			}
	}else{
		Header('Location: '.PATH_OFFLINE);
		}
	}

// BASE REQUIRED
require_once(DIR_INC.'required.php');

//POUR LE RETOUR DU SERVICE
require_once(DIR_CLASS.'json.php');
require_once(DIR_CLASS.'response.php');
$oReg->set('resp', new Response(new Json()));

//logs actions for admin service request by user
$oReg->get('log')->log('service', $oReg->get('req')->showRequestAllText());
		
// ON CHECK LE SERVICE
if($oReg->get('req')->get('service') && $oReg->get('req')->get('section')){
	
	if( $oReg->get('req')->get('section') == 'grille'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'set-grille'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'grille.php');
				$oGrille = new Grille($oReg);
				if(!$oGrille->setGrille($oReg->get('req')->get('id'), json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oGrille->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oGrille->getMsgErrors()));
					}
				}	
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}
	
	
	
	}else if( $oReg->get('req')->get('section') == 'login'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'do-login'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'login.php');
				$oLogin = new Login($oReg);
				if(!$oLogin->doLogin(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oLogin->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oLogin->getMsgErrors()));
					}
				}	
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'do-logout'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'login.php');
				$oLogin = new Login($oReg);
				$oLogin->doLogout();
				}
				
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}
	
	
		
	
	}else if( $oReg->get('req')->get('section') == 'config'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'set-config-site'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'config.php');
				$oConfig = new Config($oReg);
				if(!$oConfig->setSiteConfig(json_decode($oReg->get('req')->get('data'), true))){
					//no form errors on this one
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error occured, no modifications were made')));
					}
				}	

		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	
			
			
			
			
			
			
			

	}else if( $oReg->get('req')->get('section') == 'datafields'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'get-items-from-table'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'datafields.php');
				$oDatafields = new Datafields($oReg);
				$arrItems = $oDatafields->getData($oReg->get('req')->get('data'));
				if(!$arrItems){
					//no form errors on this one
					$oReg->get('resp')->puts(array('msgerrors'=>_T('no items found')));
				}else{
					$oReg->get('resp')->puts(array('msgdata'=>json_encode($arrItems)));
					}
				}	
				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-datafields-infos'){  
			if($oReg->get('req')->get('data') && $oReg->get('req')->get('table')){
				require_once(DIR_CLASS.'datafields.php');
				$oDatafields = new Datafields($oReg);
				$arrItems = $oDatafields->setData($oReg->get('req')->get('table'), json_decode($oReg->get('req')->get('data'), true), json_decode($oReg->get('req')->get('insert'), true));
				if(!$arrItems){
					//no form errors on this one
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error occured, no modifications were made')));
				}else if(is_array($arrItems)){
					//no form errors on this one
					$oReg->get('resp')->puts(array('msgdata'=>$arrItems));
					}
				}

		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'generate-datafields-infos'){  
			require_once(DIR_CLASS.'datafields.php');
			$oDatafields = new Datafields($oReg);
			if(!$oDatafields->generateData()){
				//no form errors on this one
				$oReg->get('resp')->puts(array('msgerrors'=>_T('an error occured, the file was not generated')));
				}		

		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	
			
			
			
			
			
			
			
			
			

			
	}else if( $oReg->get('req')->get('section') == 'translation'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'get-items-from-table'){  
			require_once(DIR_CLASS.'translation.php');
			$oTranslation = new Translation($oReg);
			$arrItems = $oTranslation->getData($oReg->get('req')->get('data'));
			if(!$arrItems){
				//no form errors on this one
				$oReg->get('resp')->puts(array('msgerrors'=>_T('no items found')));
			}else{
				$oReg->get('resp')->puts(array('msgdata'=>json_encode($arrItems)));
				}
				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'get-items-filtered-by-string'){  
			require_once(DIR_CLASS.'translation.php');
			$oTranslation = new Translation($oReg);
			$arrItems = $oTranslation->getDataFromSearch($oReg->get('req')->get('data'));
			if(!$arrItems){
				//no form errors on this one
				$oReg->get('resp')->puts(array('msgerrors'=>_T('no items found')));
			}else{
				$oReg->get('resp')->puts(array('msgdata'=>json_encode($arrItems)));
				}		
				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-translation-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'translation.php');
				$oTranslation = new Translation($oReg);
				if(!$oTranslation->setData(json_decode($oReg->get('req')->get('data'), true))){
					//no form errors on this one
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error occured, no modifications were made')));
					}
				}			

		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'generate-translation-infos'){  
			require_once(DIR_CLASS.'translation.php');
			$oTranslation = new Translation($oReg);
			if(!$oTranslation->generateData()){
				//no form errors on this one
				$oReg->get('resp')->puts(array('msgerrors'=>_T('an error occured, the file was not generated')));
				}
					
				
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	









			
			
	}else if( $oReg->get('req')->get('section') == 'utils'){					
		if($oReg->get('req')->get('service') == 'import-users-email-csv-file'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'utils.php');
				$oUtils = new Utils($oReg);
				$file = $oUtils->importUsersEmailCsvFile();
				if(!$file){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('missing infos please retry')));
				}else{
					$oReg->get('resp')->puts(array('msgdata'=>$file));
					}
				}		
				
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	
			
			
			
			
			
			
			
			
			
		
	}else if( $oReg->get('req')->get('section') == 'links'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'new-links-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'links.php');
				$oLinks = new Links($oReg);
				if(!$oLinks->newLinksInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oLinks->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oLinks->getMsgErrors()));
					}
				}	
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-links-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'links.php');
				$oLinks = new Links($oReg);
				if(!$oLinks->setLinksInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oLinks->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oLinks->getMsgErrors()));
					}
				}			
				
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'get-links-infos'){ //ajax
			//besoin du id 
			if($oReg->get('req')->get('id')){
				require_once(DIR_CLASS.'links.php');
				$oLinks = new Links($oReg);
				$arrLinksInfos = $oLinks->getLinksInfos(intVal($oReg->get('req')->get('id')));
				if($arrLinksInfos){
					$oReg->get('resp')->puts($arrLinksInfos);
				}else{
					$oReg->get('resp')->puts(array('msgerrors'=>_T('could not retrieves infos')));
					}
			}else{
				//fill data with error
				$oReg->get('resp')->puts(array('msgerrors'=>_T('missing id')));
				}		
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'disable-links-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'links.php');
				$oLinks = new Links($oReg);
				if(!$oLinks->disableLinksInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
				
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'enable-links-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'links.php');
				$oLinks = new Links($oReg);
				if(!$oLinks->enableLinksInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}		

		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'delete-links-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'links.php');
				$oLinks = new Links($oReg);
				if(!$oLinks->deleteLinksInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}			
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	
			
			
			
			
			
			
	
	
	}else if( $oReg->get('req')->get('section') == 'menu'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'new-menu-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'menu-client.php');
				$oMenuClient = new MenuClient($oReg);
				if(!$oMenuClient->newMenuClientInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oMenuClient->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oMenuClient->getMsgErrors()));
					}
				}	
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-menu-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'menu-client.php');
				$oMenuClient = new MenuClient($oReg);
				if(!$oMenuClient->setMenuClientInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oMenuClient->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oMenuClient->getMsgErrors()));
					}
				}		
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'disable-menu-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'menu-client.php');
				$oMenuClient = new MenuClient($oReg);
				if(!$oMenuClient->disableMenuClientInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
				
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'enable-menu-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'menu-client.php');
				$oMenuClient = new MenuClient($oReg);
				if(!$oMenuClient->enableMenuClientInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'delete-menu-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'menu-client.php');
				$oMenuClient = new MenuClient($oReg);
				if(!$oMenuClient->deleteMenuClientInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'get-menu-infos'){ //ajax
			//besoin du id 
			if($oReg->get('req')->get('id')){
				require_once(DIR_CLASS.'menu-client.php');
				$oMenuClient = new MenuClient($oReg);
				$arrMenuClientInfos = $oMenuClient->getMenuClientInfos(intVal($oReg->get('req')->get('id')));
				if($arrMenuClientInfos){
					$oReg->get('resp')->puts($arrMenuClientInfos);
				}else{
					$oReg->get('resp')->puts(array('msgerrors'=>_T('could not retrieves infos')));
					}
			}else{
				//fill data with error
				$oReg->get('resp')->puts(array('msgerrors'=>_T('missing id')));
				}		
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}
			
			
			
			
			
			
			
			
			
			
			
	
	
	}else if( $oReg->get('req')->get('section') == 'content'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'new-category-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContentCategory = new Content($oReg);
				if(!$oContentCategory->newContentCategoryInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oContentCategory->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oContentCategory->getMsgErrors()));
					}
				}	
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-category-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContentCategory = new Content($oReg);
				if(!$oContentCategory->setContentCategoryInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oContentCategory->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oContentCategory->getMsgErrors()));
					}
				}		
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'disable-category-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContentCategory = new Content($oReg);
				if(!$oContentCategory->disableContentCategoryInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'enable-category-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContentCategory = new Content($oReg);
				if(!$oContentCategory->enableContentCategoryInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'delete-category-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContentCategory = new Content($oReg);
				if(!$oContentCategory->deleteContentCategoryInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'get-category-infos'){ //ajax
			//besoin du id 
			if($oReg->get('req')->get('id')){
				require_once(DIR_CLASS.'content.php');
				$oContentCategory = new Content($oReg);
				$arrContentCategoryInfos = $oContentCategory->getContentCategoryInfos(intVal($oReg->get('req')->get('id')));
				if($arrContentCategoryInfos){
					$oReg->get('resp')->puts($arrContentCategoryInfos);
				}else{
					$oReg->get('resp')->puts(array('msgerrors'=>_T('could not retrieves infos')));
					}
			}else{
				//fill data with error
				$oReg->get('resp')->puts(array('msgerrors'=>_T('missing id')));
				}		
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'disable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContent = new Content($oReg);
				if(!$oContent->disableContentInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'enable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContent = new Content($oReg);
				if(!$oContent->enableContentInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'delete-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContent = new Content($oReg);
				if(!$oContent->deleteContentInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'new-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContent = new Content($oReg);
				if(!$oContent->newContentInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oContent->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oContent->getMsgErrors()));
					}
				}			
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'content.php');
				$oContent = new Content($oReg);
				if(!$oContent->setContentInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oContent->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oContent->getMsgErrors()));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	
			
			
	
	}else if( $oReg->get('req')->get('section') == 'question'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'disable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'question.php');
				$oQuestion = new Question($oReg);
				if(!$oQuestion->disableQuestionInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'enable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'question.php');
				$oQuestion = new Question($oReg);
				if(!$oQuestion->enableQuestionInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'delete-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'question.php');
				$oQuestion = new Question($oReg);
				if(!$oQuestion->deleteQuestionInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'new-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'question.php');
				$oQuestion = new Question($oReg);
				if(!$oQuestion->newQuestionInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oQuestion->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oQuestion->getMsgErrors()));
					}
				}			
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'question.php');
				$oQuestion = new Question($oReg);
				if(!$oQuestion->setQuestionInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oQuestion->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oQuestion->getMsgErrors()));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	


	
		



	}else if( $oReg->get('req')->get('section') == 'recommandation'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'disable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'recommandation.php');
				$oRecommandation = new Recommandation($oReg);
				if(!$oRecommandation->disableRecommandationInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'enable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'recommandation.php');
				$oRecommandation = new Recommandation($oReg);
				if(!$oRecommandation->enableRecommandationInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'delete-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'recommandation.php');
				$oRecommandation = new Recommandation($oReg);
				if(!$oRecommandation->deleteRecommandationInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'new-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'recommandation.php');
				$oRecommandation = new Recommandation($oReg);
				if(!$oRecommandation->newRecommandationInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oRecommandation->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oRecommandation->getMsgErrors()));
					}
				}			
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'recommandation.php');
				$oRecommandation = new Recommandation($oReg);
				if(!$oRecommandation->setRecommandationInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oRecommandation->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oRecommandation->getMsgErrors()));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	





	}else if( $oReg->get('req')->get('section') == 'conseil'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'disable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'conseil.php');
				$oConseil = new Conseil($oReg);
				if(!$oConseil->disableConseilInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'enable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'conseil.php');
				$oConseil = new Conseil($oReg);
				if(!$oConseil->enableConseilInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'delete-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'conseil.php');
				$oConseil = new Conseil($oReg);
				if(!$oConseil->deleteConseilInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'new-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'conseil.php');
				$oConseil = new Conseil($oReg);
				if(!$oConseil->newConseilInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oConseil->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oConseil->getMsgErrors()));
					}
				}			
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'conseil.php');
				$oConseil = new Conseil($oReg);
				if(!$oConseil->setConseilInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oConseil->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oConseil->getMsgErrors()));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	

		


	}else if( $oReg->get('req')->get('section') == 'bulle'){					
		//--------------------------------------------------------------------------------------------------		
		if($oReg->get('req')->get('service') == 'disable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'bulle.php');
				$oBulle = new Bulle($oReg);
				if(!$oBulle->disableBulleInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}				
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'enable-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'bulle.php');
				$oBulle = new Bulle($oReg);
				if(!$oBulle->enableBulleInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'delete-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'bulle.php');
				$oBulle = new Bulle($oReg);
				if(!$oBulle->deleteBulleInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'new-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'bulle.php');
				$oBulle = new Bulle($oReg);
				if(!$oBulle->newBulleInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oBulle->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oBulle->getMsgErrors()));
					}
				}			
		//--------------------------------------------------------------------------------------------------		
		}else if($oReg->get('req')->get('service') == 'set-item-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'bulle.php');
				$oBulle = new Bulle($oReg);
				if(!$oBulle->setBulleInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('formerrors'=>$oBulle->getFormErrors()));
					$oReg->get('resp')->puts(array('msgerrors'=>$oBulle->getMsgErrors()));
					}
				}
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}	


		
			
			
			
			

	}else if( $oReg->get('req')->get('section') == 'users'){					
		//--------------------------------------------------------------------------------------------------
		if($oReg->get('req')->get('service') == 'disable-users-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'users.php');
				$oUsers = new Users($oReg);
				if(!$oUsers->disableUsersInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
				
		//--------------------------------------------------------------------------------------------------
		}else if($oReg->get('req')->get('service') == 'enable-users-infos'){  
			if($oReg->get('req')->get('data')){
				require_once(DIR_CLASS.'users.php');
				$oUsers = new Users($oReg);
				if(!$oUsers->enableUsersInfos(json_decode($oReg->get('req')->get('data'), true))){
					$oReg->get('resp')->puts(array('msgerrors'=>_T('an error has occured')));
					}
				}	
			
		//--------------------------------------------------------------------------------------------------		
		}else{
			//fill data with error
			$oReg->get('resp')->puts(array('msgerrors'=>_T('service not available')));
			}
			

	
	}else{
		//fill data with error
		$oReg->get('resp')->puts(array('msgerrors'=>_T('section not available')));
		}

		
}else{
	//fill data with error
	$oReg->get('resp')->puts(array('msgerrors'=>_T('no service requested')));
	}

//output back to ajax	
$oReg->get('resp')->addHeader('Content-Type: text/plain; charset=utf-8');
$oReg->get('resp')->output();	

	
//END


