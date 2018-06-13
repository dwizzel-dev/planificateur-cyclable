<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	script model

*/


//push le global
array_push($arrOutput['script'], PATH_JS.'respond.min.js');
array_push($arrOutput['script'], PATH_JS.'json2.js');
array_push($arrOutput['script'], PATH_JS.'jquery-1.7.2.js');
array_push($arrOutput['script'], PATH_JS.'bootstrap.min.js');
array_push($arrOutput['script'], PATH_JS.'bootstrap-tooltip.js');
array_push($arrOutput['script'], PATH_JS.'modernizr.js');
array_push($arrOutput['script'], PATH_JS.'global.js');

//specific to appz
array_push($arrOutput['script'], PATH_JS.'jdebug.js');
array_push($arrOutput['script'], PATH_JS.'jlang.js');
array_push($arrOutput['script'], PATH_JS.'jcomm.js');
array_push($arrOutput['script'], PATH_JS.'jappz.js');
array_push($arrOutput['script'], PATH_JS.'jthread.js');




//javascript load
$arrOutput['script-load'] = array();
//array_push($arrOutput['script-load'], PATH_JS.'bootstrap.js');



//END