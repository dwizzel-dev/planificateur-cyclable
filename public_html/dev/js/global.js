/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	function javascript globals to this site


*/

//----------------------------------------------------------------------------------------------	
	
function formatJavascript(str){
	return String(str).replace(/"/g, '&quot;');
	}	
	
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    //document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    document.cookie = encodeURIComponent(name) + "=" + value + expires + "; path=/";
}

//----------------------------------------------------------------------------------------------	
function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0){
			//return decodeURIComponent(c.substring(nameEQ.length, c.length));
			return c.substring(nameEQ.length, c.length);
			}
    }
    return null;
}

//----------------------------------------------------------------------------------------------	
function eraseCookie(name) {
    createCookie(name, "", -1);
}	
	
//----------------------------------------------------------------------------------------------	
function safeString(str) {
    return str;
}	

//----------------------------------------------------------------------------------------------	
function userInputEncoder(str) {
    //console.log('userInputEncoder.before:' + str);
    str = $('<span>').text(str).html();
    str = String(str).replace(/'/g, '&#39;'); 
    str = String(str).replace(/"/g, '&#34;'); 
    str = String(str).replace(/\\/g, '&#92;'); 
    //console.log('userInputEncoder.after:' + str);
    return str;
}

//----------------------------------------------------------------------------------------------	
function userInputDecoder(str) {
    //console.log('userInputDecoder.before:' + str);
    str = String(str).replace(/&#39;/g, '\''); 
    str = String(str).replace(/&#34;/g, '"'); 
    str = String(str).replace(/&#92;/g, '\\'); 
    //console.log('userInputDecoder.after:' + str);
    return str;
}