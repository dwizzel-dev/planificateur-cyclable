<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	pager view

*/

class widgetPagerView{

	//
	private $wname;

	//construct
	public function __construct($wname){
		$this->wname = $wname;
		}
		
	public function getView($arr){
		$strOutput = '';
		$strOutput .= '<div class="row-fluid">';	
		$strOutput .= '<div class="span12">';	
		$strOutput .= '<div id="'.$this->wname.'">';
		//pagination older-newer
		$strOutput .= '<ul class="pager">';
		if(!$arr['older']){
			$strOutput .= '<li class="previous disabled"><a href="#"><span class="arrow">&lt;</span> '.$arr['previous-text'].'</a></li>';
		}else{
			$strOutput .= '<li class="previous"><a href="'.$arr['older']['link'].'">&lt; '.$arr['previous-text'].'</a></li>';
			}
		//	
		if(!$arr['newer']){
			$strOutput .= '<li class="next disabled"><a href="#">'.$arr['next-text'].' &gt;</a></li>';
		}else{
			$strOutput .= '<li class="next"><a href="'.$arr['newer']['link'].'">'.$arr['next-text'].' &gt;</a></li>';
			}
		$strOutput .= '</ul>';
		$strOutput .= '</div>';	
		$strOutput .= '</div>';	
		$strOutput .= '</div>';	
		//end pagination
		return $strOutput;
		
		}

	
	}
	
//END	
	
	
	
	
	