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
array_push($arrOutput['script'], PATH_JS.'bootstrap.js');
array_push($arrOutput['script'], PATH_JS.'global.js');
array_push($arrOutput['script'], PATH_JS.'bootstrap-datepicker.js');
array_push($arrOutput['script'], PATH_JS.'jquery.scrollTo-1.4.3.1-min.js');
array_push($arrOutput['script'], PATH_JS.'editor.with-moxiecut/tinymce.js'); //moxie-cut russian hack
//array_push($arrOutput['script'], PATH_JS.'editor/tinymce.min.js'); //GOOD ONE
//array_push($arrOutput['script'], PATH_JS.'editor/__tinymce.min.js'); //with the image-manager exemple test
array_push($arrOutput['script'], PATH_WEB.'media-manager/assets/dialog.js');
array_push($arrOutput['script'], PATH_WEB.'media-manager/IMEStandalone.js');



$arrOutput['script-load'] = array();
/*
array_push($arrOutput['script-load'], PATH_JS.'jquery.scrollTo-1.4.3.1-min.js');
array_push($arrOutput['script-load'], PATH_JS.'bootstrap.js');
array_push($arrOutput['script-load'], PATH_JS.'json2.js');
array_push($arrOutput['script-load'], PATH_JS.'editor/tinymce.min.js');
array_push($arrOutput['script-load'], PATH_WEB.'media-manager/assets/dialog.js');
array_push($arrOutput['script-load'], PATH_WEB.'media-manager/IMEStandalone.js');
array_push($arrOutput['script-load'], PATH_JS.'global.js');
*/




//END