/*

Author: DwiZZel
Date: 15-03-2016
Notes:	
		
*/

//----------------------------------------------------------------------------------------------------------------------
    
function JDebug(){

	this.className = 'JLang';	
	this.arr = [];
	this.eol = '<br>';

	//-----------------------------------------------------------------------------------------*	
	this.show = function(str){
		console.log(str);
		}

	//-----------------------------------------------------------------------------------------*	
	this.showObject = function(str, obj){
		console.log(str + '{');
		console.log(obj);
		console.log('}');
		}

	}