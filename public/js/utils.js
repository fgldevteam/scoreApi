$( document ).ready(function() {
	//prevents right click
	document.oncontextmenu = function () { return false; };
	
	var domNode = $('html');
	domNode.get(0).onselectstart = function () { return false; };
});