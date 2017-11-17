(function($){

	// determine shortest slide, make wrapper that height
	function adjustSlideHeight(wrapper) {

		var ratios = [];
		
    	$(wrapper + ' .slides li img').each(function() {
    		ratios.push($(this).attr('height')/$(this).attr('width'));
        });
        height = Math.ceil($('#slider-width').width() * Math.min.apply(Math,ratios));
        $(wrapper + ' .slides li img').each(function() {
            $(this).css('height', height + 'px');
            $(this).css('width', 'auto');
        }); 
    }

	$(window).load(function() {

		if ($('body').hasClass('single-inventory_vehicle')) {

			// flex slider setup
			var anispeed = 300;
			if (typeof flexslider_opts !== 'undefined'
				&& null != flexslider_opts
				&& flexslider_opts.hover_nav) {
				anispeed = 0;
			}

	        adjustSlideHeight('#slider');

	        $(window).resize(function() {
	            setTimeout(function() {
	                adjustSlideHeight('#slider');
	            }, 120);
	        });

			// The slider being synched must be initialized first
			$('#carousel').flexslider({
				animation: "slide",
				controlNav: false,
				slideshow: false,
				smoothHeight: true,
				itemWidth: 150,
				itemMargin: 10,
				asNavFor: '#slider'
			});

			$('#slider').flexslider({
				animation: "fade",
				controlNav: false,
				slideshow: false,
				sync: "#carousel",
				animationSpeed: anispeed,
			});

			if (typeof flexslider_opts !== 'undefined') {
				if (flexslider_opts.hover_nav) {
					$('#carousel .slides li').on('mouseover',function(){
						$('#slider').flexslider($(this).index());
					});
				}
			}

		}

	});

})(jQuery);