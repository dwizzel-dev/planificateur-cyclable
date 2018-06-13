<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	breadcrumbs view

*/

class widgetBreadcrumbsView{

	//
	private $wname;

	//construct
	public function __construct($wname){
		$this->wname = $wname;
		}
		
	public function getView($arr){
		$strOutput = '';
		$strOutput .= '<div id="'.$this->wname.'">';
		$strOutput .= '<ul class="breadcrumb">';
		$iCmpt = 1;
		foreach($arr as $k=>$v){
		if($iCmpt != count($arr)){
			$strOutput .= '<li><a href="'.$v['link'].'">'.ucfirst($v['text']).'</a> <span class="divider">/</span></li>';
		}else{
			$strOutput .= '<li class="active">'.ucfirst($v['text']).'</li>';
			}
		$iCmpt++;
		}
		$strOutput .= '</ul>';
		$strOutput .= '</div>';	
		return $strOutput;
		}

	
	}
	
//END	
	
	
	
	
	