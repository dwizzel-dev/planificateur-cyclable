﻿/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	function javascript globals to this site


*/

//----------------------------------------------------------------------------------------------

function debug(str){
	var div = $_('request');
	if(div){
		div.innerHTML = '<br/>' + str + div.innerHTML;
		}
	}

	
//----------------------------------------------------------------------------------------------	
	
function $_(id){
	var el = document.getElementById(id); 
	if(el){
		return el;
		}
	return false;
	}	
	
//----------------------------------------------------------------------------------------------	
	
function isNumeric(o){
	if (o.length > 0 && !o.match(/^[\-\+]?[\d\,]*\.?[\d]*$/)){
		return false;
		}
	return true;	
	}
	
//----------------------------------------------------------------------------------------------	
	
function addslashes (str){
	return str.replace(/&quot;/g, '"').replace(/\'/g, '\'');
	}	
	
//----------------------------------------------------------------------------------------------	
	
function htmlspecialchars_decode (string, quote_style) {
    var optTemp = 0, i = 0,  noquotes = false;
    if(typeof quote_style === 'undefined'){
        quote_style = 2;
		}
    string = string.toString().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
    var OPTS = {
        'ENT_NOQUOTES': 0,
        'ENT_HTML_QUOTE_SINGLE': 1,
        'ENT_HTML_QUOTE_DOUBLE': 2,
        'ENT_COMPAT': 2,
        'ENT_QUOTES': 3,
        'ENT_IGNORE': 4
		};
    if(quote_style === 0){
        noquotes = true;
		}
    if(typeof quote_style !== 'number'){ 
        quote_style = [].concat(quote_style);
        for(i=0; i<quote_style.length; i++) {
            if(OPTS[quote_style[i]] === 0){
                noquotes = true;
            }else if(OPTS[quote_style[i]]) {
                optTemp = optTemp | OPTS[quote_style[i]];
				}
			}
        quote_style = optTemp;
		}
    if(quote_style & OPTS.ENT_HTML_QUOTE_SINGLE){
        string = string.replace(/&#0*39;/g, "'"); 
        }
    if(!noquotes){
        string = string.replace(/&quot;/g, '"');
		}
    string = string.replace(/&amp;/g, '&');
    return string;
	}	
	
//----------------------------------------------------------------------------------------------	

function getSingleSelected(opt){
	var selected;
	for(var i=0;i<opt.length;i++){
		if(opt[i].selected){
			return opt[i].value;
			}
		}
	return false;
	};	
	
//----------------------------------------------------------------------------------------------	

function setSingleSelected(opt,id){
	for(var i=0;i<opt.length;i++){
		if(opt[i].value == id){
			opt[i].selected = true;
			return true;
			}
		}
	return false;
	};	

//----------------------------------------------------------------------------------------------	

function changeBgColor(id,color){
	var el = $_(id);
	if(el){
		el.style.backgroundColor = '#' + color;
		}
	};			
	
//----------------------------------------------------------------------------------------------	
	
function Thread(n,l,p,pm){
	this.i=0;
	this.a=1;
	this.s=0;
	this.f=n;
	this.l=l;
	this.p=p;
	this.pm=pm;
	this.run=function(s){
		clearTimeout(s.i);
		if(s.a){
			var b=s.l[s.f](s.pm);
			if(b){
				s.i=setTimeout(
					function(){
						s.run(s)
						},s.p);
			}else{
				s.s=0;
				s.a=0;
				}
			}
		};
	this.start=function(){
		if(this.a){
			clearTimeout(this.i);
			this.run(this);
			this.s=1;
			}
		};
	this.stop=function(){
		if(this.a){
			clearTimeout(this.i);
			this.s=0;
			}
		};
	};
	
/*-------------------------------------------------------------------------------------------------------*/	
function cleanUrlTitle(str){
    str = str.replace(/^a-z0-9\s-/g, '');  
    str = str.replace(/&amp;/g, '-');
	str = str.replace(/[\s-]+/g, '-'); 
	str = str.replace(/'/g, '-'); 
	str = str.replace(/"/g, '-');
	return str;
	}

//-------------------------------------------------------	
function pricePrint(s){
	return '$' + s;
	}	
	
/*-------------------------------------------------------------------------------------------------------*/	
/*
Large display 1200px
Default	980px
Portrait tablets 768px
Phones to tablets 767px
Phones 480px
*/	
	
jQuery(document).ready(function(){
	
	//prevent les defaults de <a href="#"> sur le menu
	//$('a.prevent-default').each(function() {
	$('#catalogue-menu-line > ul > li > a.prevent-default').each(function() {
		if($(this).attr('href') == '#'){
			$(this).click(function(e) {
				e.preventDefault(); 
				});
			}
		});

	
	//
	
	//top menu fixe only for pC for now
	function chkTopMenu(){
		var y = $(window).scrollTop();
		var w = $(window).width();
		var h = $(window).height();
		
		
		//quand arrive directmenta la hauterur menu
		var hMax = $('#row-top').height() + $('#row-header').height() - $('#catalogue-menu-navbar').height() - parseInt($('#catalogue-menu-navbar').css('marginBottom')) - 5; //a 5 little marging on top

		var hOffset = -($('#row-header').height() - $('#catalogue-menu-navbar').height() - parseInt($('#catalogue-menu-navbar').css('marginBottom')) - 5); //a 5 little marging on top
		
		if(y > hMax && w >= 978 && ($('body').height() > (($('#row-header').height() * 2) + h))){ //pc seulement et faire attention hauteur de la page sinon jump
		//if(y > hMax){ //pour tous mais beaucoup de debug a faire...
			$('#row-header-mini-cart').css({'box-shadow':'0 5px 5px rgba(0, 0, 0, 0.4)'});
			$('#row-header-maxi-cart').css({'box-shadow':'0 5px 5px rgba(0, 0, 0, 0.4)'});
			$('#row-header').css({'position':'fixed','z-index':'10000','top':hOffset, 'box-shadow':'0 5px 5px rgba(0, 0, 0, 0.4)'});
			$('#fix-row-header').css({'display':'block', 'height': $('#row-header').height()});
		}else{
			$('#row-header-mini-cart').css({'box-shadow':'none'});
			$('#row-header-maxi-cart').css({'box-shadow':'none'});
			$('#row-header').css({'position':'relative', 'top':'auto', 'box-shadow':'none'});
			$('#fix-row-header').css({'display':'none', 'height': '0'});
			}
		/*	
		//quand depasse le menu
		var hMax = $('#row-top').height() + $('#row-header').height() - $('#catalogue-menu-navbar').height() - parseInt($('#catalogue-menu-navbar').css('marginBottom')) - 5; //a 5 little marging on top

		var hOffset = -($('#row-header').height() - $('#catalogue-menu-navbar').height() - parseInt($('#catalogue-menu-navbar').css('marginBottom')) - 5); //a 5 little marging on top
		
		//if(y > hMax && w >= 978 && ($('body').height() > (($('#row-header').height() * 2) + h))){ //pc seulement et faire attention hauteur de la page sinon jump
		if(y > hMax){ //pour tous mais beaucoup de debug a faire...
			$('#row-header').css({'position':'fixed','z-index':'1000','top':hOffset, 'box-shadow':'0 10px 10px rgba(0, 0, 0, 0.4)'});
			$('#fix-row-header').css({'display':'block', 'height': $('#row-header').height()});
		}else{
			$('#row-header').css({'position':'relative', 'top':'auto', 'box-shadow':'none'});
			$('#fix-row-header').css({'display':'none', 'height': '0'});
			}	
			*/
		
		}
	//f ot the top menu
	
	$(window).scroll(function(){
		chkTopMenu();
		});
	$(window).resize(function(){
		chkTopMenu();
		});	
	//start check for top menu fixed
	chkTopMenu();	
		
	});

	
