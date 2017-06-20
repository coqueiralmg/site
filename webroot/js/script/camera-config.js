$(function(){

	if(window.location.origin + "/" === window.location.href || window.location.origin === undefined){
		// camera slider
		jQuery('div#container div#home div div#banner div #camera-wrap').camera();
	}
	
});