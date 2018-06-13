<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	basic menu for admin not from DB but coded directly here



*/

class Menu {
	
	private $arr = array();
	
	public function __construct() {
		//english admin menu
		$this->arr['fr_CA'] = array(
			array(
				'name' => _T('system'),
				'link_id' => false,
				'child' => array(
					array(
						'name' => _T('translation'),
						'description' => _T('simple text used all across the website that are not in the database'),
						'menu_type' => 0,
						'link_id' => 'translation',
						'child' => false, 
						),
					array(
						'name' => _T('datafields'),
						'description' => _T('database fields used all across the website: conseil, reponse, etc...'),
						'menu_type' => 0,
						'link_id' => 'datafields',
						'child' => false, 
						),
					array(
						'name' => _T('config'),
						'description' => _T('basic site configuration: offline, path, debug, etc...'),
						'menu_type' => 0,
						'link_id' => 'config',
						'child' => false, 
						),	
					array(
						'name' => _T('users'),
						'description' => _T('users administration'),
						'menu_type' => 0,
						'link_id' => 'users-listing',
						'child' => false, 
						),	
					),			
				),
				
				
				
			array(
				'name' => _T('grilles'),
				'link_id' => false,
				'child' => array(
					array(
						'name' => _T('recommandations'),
						'description' => _T('liste des recommandations'),
						'menu_type' => 0,
						'link_id' => 'recommandation-listing',
						'child' => false, 
						),
					array(
						'name' => _T('conseils'),
						'description' => _T('liste des conseils'),
						'menu_type' => 0,
						'link_id' => 'conseil-listing',
						'child' => false, 
						),	
					array(
						'name' => _T('bulle aide'),
						'description' => _T('les bulles aide propose dans les boites de questions'),
						'menu_type' => 0,
						'link_id' => 'bulle-listing',
						'child' => false, 
						),	
					array(
						'name' => _T('questions'),
						'description' => _T('les questions utilisees pour les recommandations'),
						'menu_type' => 0,
						'link_id' => 'question-listing',
						'child' => false, 
						),
					array(
						'name' => _T('grilles'),
						'description' => _T('les grilles avec la liste de questions et recommandations'),
						'menu_type' => 0,
						'link_id' => 'grille-listing',
						'child' => false, 
						),	
					),			
				),	
				
				
				
			array(
				'name' => _T('content'),
				'link_id' => 0,
				'child' => array(
					array(
						'name' => _T('links'),
						'description' => _T('links used by the website'),
						'menu_type' => 0,
						'link_id' => 'links',
						'child' => false, 
						),
					array(
						'name' => _T('menu'),
						'description' => _T('menu used by the website'),
						'menu_type' => 0,
						'link_id' => 'menu',
						'child' => false,
						),
					array(
						'name' => _T('categories'),
						'description' => _T('content category listing'),
						'menu_type' => 0,
						'link_id' => 'content-category',
						'child' => false,
						),	
					array(
						'name' => _T('items'),
						'description' => _T('page content listing'),
						'menu_type' => 0,
						'link_id' => 'content-listing',
						'child' => false,
						),	
					),			
				),
				
			array(
				'name' => _T('logout'),
				'link_id' => 'logout',
				'child' => ''	
				),	
						
			);
		
		
		
		//french admin menu
		$this->arr['en_US'] = array();		
		}
		
	public function getMenuTree($lang) {
		return $this->arr[$lang];
		}


	}
	
	
	
	
//END


