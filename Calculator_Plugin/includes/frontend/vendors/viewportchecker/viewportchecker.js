/*
    Version 1.3.2
    The MIT License (MIT)

    Copyright (c) 2014 Dirk Groenen

    Permission is hereby granted, free of charge, to any person obtaining a copy of
    this software and associated documentation files (the "Software"), to deal in
    the Software without restriction, including without limitation the rights to
    use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
    the Software, and to permit persons to whom the Software is furnished to do so,
    subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.
*/

(function($){
    $.fn.viewportChecker = function(useroptions){
        // Define options and extend with user
        var options = {
            classToAdd: 'visible',
            offset: 100,
            callbackFunction: function(elem){}
        };
        $.extend(options, useroptions);

        // Cache the given element and height of the browser
        var $elem = this,
            windowHeight = $(window).height();

        this.checkElements = function(){
            // Set some vars to check with
            var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html'),
                viewportTop = $(scrollElem).scrollTop(),
                viewportBottom = (viewportTop + windowHeight);

            $elem.each(function(){
                var $obj = $(this);
                // If class already exists; quit
                if ( $obj.hasClass(options.classToAdd) && options.classToAdd != '' ){
                    return;
                }

                // define the top position of the element and include the offset which makes is appear earlier or later
                var elemTop = Math.round( $obj.offset().top ) + options.offset,
                    elemBottom = elemTop + ($obj.height());

                // Add class if in viewport
                if ((elemTop < viewportBottom) && (elemBottom > viewportTop) && this.done != true){
                    $obj.addClass(options.classToAdd);

                    // Do the callback function. Callback wil send the jQuery object as parameter
                    options.callbackFunction($obj);
                }
            });
        };

        // Run checkelements on load and scroll
        $(window).scroll(this.checkElements);
        this.checkElements();

        // On resize change the height var
        $(window).resize(function(e){
            windowHeight = e.currentTarget.innerHeight;
        });
    };


	$(document).ready(function( $ ){
		$('.animated').each(function(){
		
			var delay = this.className.split('delay-')[1];
			if( delay ){
				$(this).css({
					'-webkit-animation-delay' : delay.split(' ')[0],
					'animation-delay' : delay.split(' ')[0]
				});
			}
		
			var type = this.className.split('eff-')[1];
			if( type ){
				type = type.split(' ')[0];
				$(this).addClass('effHidden').viewportChecker({
				   	 classToAdd: type+' effVisible',
				   	 offset: 100, 
				   	 callbackFunction: function(obj){
				   	 
					   obj.get(0).done = true;
					   	 
			   	 		var clasz = obj.attr('class');
			   	 		
			   	 		var delay = 1500;
			   	 		var claszz = '';
			   	 		if( clasz.indexOf('delay-') > -1 ){
				   	 		delay = clasz.split('delay-')[1].split('ms')[0];
				   	 	}	
				   	 	delay = parseInt(delay);
				   	 	if( !delay ){
					   	 	delay = 1500;
				   	 	}else if(delay != 1500){
					   	 	delay += 1500;
				   	 	}
	
				   	 	if( clasz.indexOf('eff-') > -1 ){	
				   	 		var claszz = clasz.split('eff-')[1].split(' ')[0];
			   	 		}
	
				   	 	setTimeout(function( a , b ){
				   	 		if( a != null ){
							   	 a.removeClass('effHidden');
							   	 a.removeClass('effVisible');
							   	 a.removeClass('animated');
							   	 a.removeClass( b );
							   	 a.removeClass( 'eff-'+b );
						   	 }
					   	}, delay , obj , claszz );
					   	
				   	 }    
				});
			}
		});
		
		$('.counter').each(function(){
			this.target = parseInt( this.innerHTML );
			this.innerHTML = '0';
			$(this).viewportChecker({
				callbackFunction: function( elm ){
			
					if( elm.html() == elm.get(0).target ){
						return;
					}
					
					elm.get(0).starter = 0;
					elm.get(0).loop = function(){
						if( this.starter < this.target ){
							this.starter += 1+(this.target/100);
							this.innerHTML = parseInt(this.starter);
							setTimeout( function(){elm.get(0).loop()}, 10+(Math.random()*100) );
						}else{
							this.innerHTML = this.target;
						}
					}
					elm.get(0).loop();
				}
			});
		});	
		
		
		$('.piechart').each(function(){
	
			$(this).viewportChecker({
				callbackFunction: function( elm ){
					
					var data = elm.attr('data-option');
					if( data == 'loaded' ){
						return;
					}			
					
					elm.attr( 'rel', 'loaded' );
					
					data = data.split('|');
	
					var options = {
						percentage: data[0],
						speed: 30,
						fontSize: data[1],
						diameter: data[2],
						lineColor: data[3],
						remainingLineColor: 'rgba(200,200,200,0.4)',
						lineWidth: data[4]

					}
	
					if( data[3] == '#fff' ){
						elm.find('canvas').eq(0).ClassyLoader3( options );
					}else if( $(elm).hasClass('white') ){
						elm.find('canvas').eq(0).ClassyLoader4( options );
					}else{
						elm.find('canvas').eq(0).ClassyLoader( options );
					}	
					
				}
			});
		});
	
	});

})(jQuery);





