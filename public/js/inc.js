// JavaScript Document
$(document).ready(function(){
						   
        $(document).pngFix(); 
		
		$('a.link[title]').qtip({
			style: { 
				name: 'light',
				tip: 'topLeft',
				fontSize: '0.7em'
			},
			position: { target: 'mouse' }
		});
		
		$('div.result_image[title]').qtip({
			style: { 
				name: 'light',
				tip: 'topLeft',
				fontSize: '0.7em'

			},
			position: { target: 'mouse' }
		});
		
		$('div.image a[title]').qtip({
			style: { 
				name: 'light',
				tip: 'topLeft',
				fontSize: '0.7em'

			},
			position: { target: 'mouse' }
		});
		
		// assign a click event to the exposed element, using normal jQuery coding 
    	$(".expose").click(function() { 
 
			// perform exposing for the clicked element 
			$(this).expose({api: true}).load(); 
 
    	}); 
		
		$('ul.sf-menu').superfish({autoArrows:  false, delay: 200, speed: 'fast'});
		
		$('#random_posts').cycle({ 
			fx:    'fade', 
			speed:  2500,
			delay: 4000
		 });
});