var IL = {
	
	toggleMenu : function() {
		if ($('nav').is(':visible')) {
			$('nav').slideUp();
		}else {
			$('nav').slideDown();
		}
	}
};