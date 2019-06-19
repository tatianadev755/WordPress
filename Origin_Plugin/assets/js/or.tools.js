/*
 * Origin Builder Project
 *
 *  
 *
 * Must obtain permission before using this script in any other purpose
 *
 * or.tools.js
 *
*/

( function($){
	
	if( typeof( or ) == 'undefined' )
		window.or = {};
		
	$().extend( or.tools, {
		
		esc_slug : function (str){
			
			if( str === undefined )
				return 'origin-builder';
			str = str.replace(/^\s+|\s+$/g, '');
			str = str.toLowerCase();
			
			var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
			var to   = "aaaaeeeeiiiioooouuuunc------";
		
			for (var i=0, l=from.length ; i<l ; i++)
			{
				str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
			}
		
			str = str.replace(/[^a-z0-9 -]/g, '')
				.replace(/\s+/g, '-')
				.replace(/-+/g, '-');
		
			return str;
			
		},
		
		esc_attr : function( str ) {
			if( !str ){
				return '';
			}
		    return str.toString()
		    		  .replace(/</g, ':lt:')
		    		  .replace(/>/g, ':gt:')
		    		  .replace(/\[/g, ':lsqb:')
		    		  .replace(/\]/g, ':rsqb:')
		    		  .replace(/"/g, ':quot:')
		    		  .replace(/'/g, ':apos:');
		},
		
		unesc_attr : function( str ) {
			if( !str ){
				return '';
			}
		    return str.toString()
		 		      .replace(/:lt:/g, '<')
		    		  .replace(/:gt:/g, '>')
		    		  .replace(/:lsqb:/g, '[')
		    		  .replace(/:rsqb:/g, ']')
		    		  .replace(/:quot:/g, '"')
		    		  .replace(/:apos:/g, '\'');
		},

		esc : function( str ) {
			if( !str ){
				return '';
			}
		    return str.toString().replace(/&/g, '&amp;')
		    		  .replace(/</g, '&lt;')
		    		  .replace(/>/g, '&gt;')
		    		  .replace(/"/g, '&quot;')
		    		  .replace(/'/g, '&apos;');
		},
		
		unesc : function(str) {
			if( str == undefined ){
				return '';
			}
		    return str.toString().replace(/&amp;/g, '&')
		    		  .replace(/&lt;/g, '<')
		    		  .replace(/&gt;/g, '>')
		    		  .replace(/&quot;/g, '"')
		    		  .replace(/&apos;/g, '\'');
		},
		
		rawdecode : function( input ){
			return decodeURIComponent( input+'' );
		},
		
		rawencode : function( input ){
			input = (input+'').toString();
			return encodeURIComponent( input ).
				   replace(/!/g,'%21').
				   replace(/'/g,'%27').
				   replace(/\(/g,'%28').
				   replace(/\)/g,'%29').
				   replace(/\*/g,'%2A');
		},
		
		decode_css : function( css ){
			
			var css_code = '';
			
			css = css.replace( /\s+/g, ' ' )
				 .replace(/\/\*[^\/\*]+\*\//g,'')
				 .replace(/[^a-zA-Z0-9\-\_\. \:\(\)\%\+\~\;\#\'\{\}\@\/]+/g,'')
				 .trim().split( '{' );
			
			for( var n in css  ){
				
				if( css[n].indexOf('}') > -1 )
				{
					css[n] = css[n].split('}');
					css[n][0] = css[n][0].split(';');
					for( var m in css[n][0] )
					{
						if( css[n][0][m].trim() != '' )
							css_code += "	"+css[n][0][m]+";\n";
					}
					if( css[n][1].trim() != '' )
						css_code += "}\n"+css[n][1]+"{\n";
					else 
						css_code += "}\n";	
					if( css[n][2] != undefined )	
						css_code += "}\n";	
				}
				else if( css[n].trim() != '' )
				{
					css_code += css[n]+"{\n"
				}
				
			}
			
			return css_code;

		},
		
		encode_css : function( css ){
			
			if( css == undefined )
				css = '';
			css = css.replace(/\/\*[^\/\*]+\*\//g,'')
					 .replace( /\ \ /g, '' )
					 .replace(/[^a-zA-Z0-9\-\_\. \:\(\)\%\+\~\;\!\#\'\{\}\@\/]+/g,'').trim();
					 
			return css;
				
		},
		
		nfloat : function( n, m ){
			
			n = n.toString();
			if( m === undefined )
				m = 2;
				
			if( n.indexOf('.') > -1 ){
				
				return parseFloat( n.substr( 0, n.indexOf('.')+m+1 ) );
				
			}else return parseFloat( n );
			
		},
		
		getFormData : function( $form ){
			
		    var unindexed = $form.serializeArray(), indexed = {}, avoidRepeat = {}, name, obs, j, k;
		
		    $.map( unindexed, function( n, i ){
			    
			    if( n['name'].indexOf('[') == -1 ){
				    
				    if( n['value'] != '' ){
					    if( indexed[ n['name'] ] == undefined || indexed[ n['name'] ] == '__empty__' )
							indexed[ n['name'] ] = n['value'];
						else
							indexed[ n['name'] ] += ','+n['value'];
				    }else if( indexed[ n['name'] ] === undefined ){
						indexed[ n['name'] ] = '';
				    }
			    	
			    	
			    }else{
				    
				    n['name'] = "["+n['name'].replace('[','][');
				    name = n['name'].replace( /\[/g, "['" ).replace( /\]/g, "']" );
		        
			        obs = [];
			       
			        [].forEach.call( n['name'].split(']['), function( sp ){
				        sp = sp.replace( /\[/g, '' ).replace( /\]/g, '' ).trim();
				        obs[ obs.length ] = sp;
			        });
			        
			        if( obs.length > 0 ){
				        k = '';
				        for( j=0; j<obs.length; j++){
					        k += "['"+obs[j]+"']";
					        eval("if( indexed"+k+"==undefined )indexed"+k+"={};");
				        }
			        }
			        
			        var query = "if( typeof(indexed"+name+") != 'string' )indexed"+name+"=n['value'];else if(n['value']!=='') indexed"+name+"+=','+n['value'];";
				    eval( query );
			    
			    }
		        
		    });
			
		    return indexed;
		    
		},
		
		basename : function( str ){
			
			var base = str.split(/[\\/]/).pop();
				
		    if( base.lastIndexOf(".") != -1 )       
		        base = base.substring( 0, base.lastIndexOf(".") );
		        
			return base;
		       	
		},
		
		toClipboard : function( str ) {
			
			if (window.clipboardData) {
                window.clipboardData.setData ("Text");
            }else {
	   			
	   			document.oncopy = function(event) {
					event.clipboardData.setData('text', str);
					event.preventDefault();
				};
				
				document.execCommand("Copy", false, null);
				
				document.oncopy = null;
				
			}
		},
		
		rgb2hex : function( rgb ) {

			if( rgb.indexOf('rgb') == -1 )
				return rgb;
		
			rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

			function hex(x) {
				return ("0" + parseInt(x).toString(16)).slice(-2);
			}

			return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);

		},
		
		hex2rgb : function(hex) {

		    r = hex.match(/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i);
		    if (r) {
		            return r.slice(1,4).map(function(x) { return parseInt(x, 16); });
		    }
		    // short version
		    r = hex.match(/^#([0-9a-f])([0-9a-f])([0-9a-f])$/i);
		    if (r) {
		            return r.slice(1,4).map(function(x) { return 0x11 * parseInt(x, 16); });
		    }
		    return hex;
		},
		
		base64 : {
			
		    codex : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
		
		    encode : function (input){
			    
			    if( input == undefined ){
					return '';
				}
				
		        var output = new this.stringBuffer();
		
		        var enumerator = new this.utf8EncodeEnumerator(input);
		        
		        while (enumerator.moveNext()){
			        
		            var chr1 = enumerator.current;
		
		            enumerator.moveNext();
		            var chr2 = enumerator.current;
		
		            enumerator.moveNext();
		            var chr3 = enumerator.current;
		
		            var enc1 = chr1 >> 2;
		            var enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
		            var enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
		            var enc4 = chr3 & 63;
		
		            if (isNaN(chr2)){
		                enc3 = enc4 = 64;
		            }
		            else if (isNaN(chr3)){
		                enc4 = 64;
		            }
		
		            output.append(this.codex.charAt(enc1) 
		            			+ this.codex.charAt(enc2) 
		            			+ this.codex.charAt(enc3) 
		            			+ this.codex.charAt(enc4));
		        }
		
		        return output.toString();
		    },
		
		    decode : function (input){
			    
			    if( input == undefined ){
					return '';
				}
			    
		        var output = new this.stringBuffer();
		
		        var enumerator = new this.decodeEnumerator(input);
		        while (enumerator.moveNext()){
			        
		            var charCode = enumerator.current;
		
		            if (charCode < 128){
		                output.append(String.fromCharCode(charCode));
		            }else if ((charCode > 191) && (charCode < 224)){
		                enumerator.moveNext();
		                var charCode2 = enumerator.current;
		
		                output.append(String.fromCharCode(((charCode & 31) << 6) | (charCode2 & 63)));
		            }else{
		                enumerator.moveNext();
		                var charCode2 = enumerator.current;
		
		                enumerator.moveNext();
		                var charCode3 = enumerator.current;
		
		                output.append(String.fromCharCode(((charCode & 15) << 12) | ((charCode2 & 63) << 6) | (charCode3 & 63)));
		            }
		        }
		
		        return output.toString();
		    },
		    
		    stringBuffer : function() {
			    this.buffer = []
			},
			
			utf8EncodeEnumerator : function(input) {
			    this._input = input;
			    this._index = -1;
			    this._buffer = []
			},
			
			decodeEnumerator : function(input) {
			    this._input = input;
			    this._index = -1;
			    this._buffer = []
			}

		},
		
		media : {
			
			el : null,
			
			callback : null,
			
			uploader : null,
			
			open : function( e ){
				
				if( typeof e.preventDefault == 'function' )
					e.preventDefault();
				
				
				atts = $().extend(
							{ frame: 'select', multiple: false, title: 'Choose Image', button: 'Choose Image', type: 'image' },
							e.data.atts );
				
				or.tools.media.el = this;
				
				if( typeof e.data.callback == 'function' )
					or.tools.media.callback = e.data.callback;
				else or.tools.media.callback = null;
				
		        if ( or.tools.media.uploader ) {
		           return or.tools.media.uploader.open();
		        }
				
				var insertImage = wp.media.controller.Library.extend({
				    defaults :  _.defaults({
			            id: 'insert-image',
			            title: atts.title,
			            button: {
			                text: atts.button
			            },
			            multiple: false,
						editing:   true,
						allowLocalEdits: true,
			            displaySettings: true,
			            displayUserSettings: true,    
			            type : atts.type
				      }, wp.media.controller.Library.prototype.defaults )
				});

		        //Extend the wp.media object
		        or.tools.media.uploader = wp.media.frames.file_frame = wp.media({         
		            frame: atts.frame,
		            state : 'insert-image',
				    states : [ new insertImage() ]
		        });
				
		        or.tools.media.uploader.on('select', function( e ) {
			        
			        var currentSize = $('.attachment-display-settings .size').val()
		        	var state = or.tools.media.uploader.state('insert-image');
		            var attachments = state.get('selection');
		            
		            if( attachments.length === 0 ){
			            
			            if( $('#embed-url-field').get(0) && $('#embed-url-field').val() != null ){
				            if( typeof or.tools.media.callback == 'function' )
					     	 	or.tools.media.callback( { 
						     	 		url: $('#embed-url-field').val(), sizes: {} }, 
						     	 		$(or.tools.media.el) 
						     	 	);
			            }
			            
		            }else{
			            
			            attachments.map( function( attachment ) {
				            
					     	 var attachment = attachment.toJSON();
					     	 attachment.size = currentSize;
					     	 if( typeof or.tools.media.callback == 'function' )
					     	 	or.tools.media.callback( attachment, $(or.tools.media.el) );
					    });
				    
				    }
		
		        });
				
				or.tools.media.uploader.on('open', function( e ) {
					 	
				 	var ids = $(or.tools.media.el).parent().find('.or-param').val();
				 	if( ids === undefined || ids == null || ids == '' )
				 		return;
				 		
				 	ids = ids.split(',');
			 	
				 	var selection = or.tools.media.uploader.state().get('selection');
				 	var attachments = [];
				 	
				 	ids.forEach(function( id ){
						attachments[ attachments.length ] = wp.media.attachment( id );
					});
					
					selection.add( attachments );

				 						
				});
				
		        //Open the uploader dialog
		       return or.tools.media.uploader.open();
			   
		    },		
		    
		    els : null,
			
			callbacks : null,
			
			uploaders : null,
			
			opens : function( e ){
				
				if( typeof e.preventDefault == 'function' )
					e.preventDefault();
				
				or.tools.media.els = this;
				
				if( typeof e.data == 'function' )
					or.tools.media.callbacks = e.data;
				else or.tools.media.callbacks = null;	
				
		        if ( or.tools.media.uploaders ) {
		           or.tools.media.uploaders.open();
		           return false;
		        }
				
		        //Extend the wp.media object
		        or.tools.media.uploaders = wp.media.frames.file_frame = wp.media({
		            title: or.__.i46,
		            button: {
		                text: or.__.i46
		            },
		            multiple: true,
					editing:   true,
					allowLocalEdits: true,
		            displaySettings: true,
		            displayUserSettings: true,
		            
		        });
		 
		        or.tools.media.uploaders.on('select', function( e ) {
		        
		            var attachments = or.tools.media.uploaders.state().get('selection');
		            attachments.map( function( attachment ) {
				     	 var attachment = attachment.toJSON();
				     	 if( typeof or.tools.media.callbacks == 'function' )
				     	 	or.tools.media.callbacks( attachment, $(or.tools.media.els) );
				    });
		
		        });
		        
		        or.tools.media.uploaders.on('open', function( e ) {
					
					// Maybe we dont need to active selected images
					return false;
					 	
				 	var ids = $(or.tools.media.els).parent().find('.or-param').val();
				 	if( ids === undefined || ids == null || ids == '' )
				 		return;
				 		
				 	ids = ids.split(',');
			 	
				 	var selection = or.tools.media.uploaders.state().get('selection');
				 	var attachments = [];
				 	
				 	ids.forEach(function( id ){
						attachments[ attachments.length ] = wp.media.attachment( id );
					});
					
					selection.add( attachments );
				 						
				});
		        
		        //Open the uploader dialog
				or.tools.media.uploaders.open();
			   
			   return false;
			   
		    }
	
		},
		
		popup : new or.backbone.views( 'no-model' ).extend({
			
			margin_top : $('html').get(0).offsetTop,
			
			no_close : false,
			
			render : function( el, atts ){
				
				var keepCurrent = false;
				if( atts != undefined ){
					if( atts.keepCurrentPopups == true ){
						keepCurrent = true;
					}
				}
				
				if( keepCurrent == false )
					$('.or-params-popup .sl-close.sl-func').trigger('click');
	

   
				$('.sys-colorPicker').remove();
				$('.or-controls .more.active').removeClass('active');
				
				var pop_width = 440;
				if( atts.width != undefined )
					pop_width = atts.width;
				var coor = this.coordinates( el, pop_width, keepCurrent );
				
				var atts = $().extend({ 
						top: coor[0], 
						left: coor[1],
						pos: coor[2],
						bottom: coor[3],
						tip: coor[4],
						width: pop_width,
						class: '',
						drag: true,
						content: '', 
						title: 'Settings',
						help: '',
						footer: true,
						footer_text: '',
						scrollTo: true,
						save_text: or.__.save,
						cancel_text: or.__.cancel
					}, atts );
				
				if( atts.footer === false && atts.class.indexOf('no-footer') == -1 )
					atts.class += ' no-footer';	
						
				this.el = $( or.template( 'popup', atts ) );
				this.el.data({ 'button' : el, 'keepCurrentPopups' : keepCurrent, 'tab_active' : 0 });
				
				if( atts.tip != 0 )
					this.el.find( '.wp-pointer-arrow' ).css({marginRight: -atts.tip+'px'});
								
				if( atts.scrollBack == true )
					this.el.data({ 'scrolltop' : $(window).scrollTop() });
					
				$('body').append( this.el  );
				
				if( atts.drag == true ){
					or.ui.draggable( this.el.get(0), 'h3.m-p-header' );
					this.el.find('h3.m-p-header').addClass('or-ui-draggable');
				}
				
				$( this.el ).css({opacity: 1});
				
				if( atts.scrollTo === true ){
					setTimeout( function( pop, atts ){
						
						var wsct = $(window).scrollTop(), wh = $(window).height(),
							wheight = wsct+(wh*0.1);
						
						if( wh > 800 )
							pop.find('.m-p-body').css({ 'max-height': (wh - 250)+'px' });
							
						var pop_rect = pop.get(0).getBoundingClientRect();
							
						if( atts.top > wheight && atts.bottom === 0 ){
							
							if( pop_rect.height < wh - 50 ){
								or.ui.scrollAssistive( atts.top - ((wh-pop_rect.height)/2) , false );
							}else or.ui.scrollAssistive( (atts.top - 50), false );
							
						}else if( pop_rect.top < 0 )
							or.ui.scrollAssistive( (wsct+pop_rect.top) - 50, false );
						
					}, 1, this.el, atts );
				}
				
				return this.el;
				
			},
			
			coordinates : function( el, pop_width, keepCurrent ){
				
				var grids;
				if( $(el).closest('#or-container').get(0) )
					grids = document.getElementById('or-container').getBoundingClientRect();
				else if( document.getElementById('wpbody-content') !== null )
					grids = document.getElementById('wpbody-content').getBoundingClientRect();	
				else if( document.getElementById('content') !== null )
					grids = document.getElementById('content').getBoundingClientRect();
				else grids = document.getElementsByTagName('body')[0].getBoundingClientRect();
				
				if( el === undefined )
					return [0,0,0,0];
						
				var coor = el.getBoundingClientRect(),
					swidth = (grids.width/3),
					sleft = coor.left-grids.left,
					top = coor.top+$(window).scrollTop()+coor.height-this.margin_top,
					bottom = 0,
					left = coor.left+$(window).scrollLeft()+(coor.width/2),
					tip = 0,
					pos = '',
					wheight = $(document).height(),
					wwidth = $(document).width();
					
				if( sleft < swidth ){
					pos = 'left';
					left -= 63;
				}else if( sleft > swidth && sleft < swidth*2 ){
					pos = 'center';
					left -= (pop_width/2);
				}else if( sleft > swidth*2 && sleft < swidth*3 ){
					pos = 'right';
					left -= (pop_width-63);
				}
				
				if( wheight - top < 200 && $(window).scrollTop() > 0 ){
					
					bottom = wheight-top+(coor.height/2);
					$('html').height( wheight - parseInt( $('html').css('padding-top') ) );
				
				}else if( keepCurrent !== true ){
					$('html').height('');
				}
				
				if( left < 50 ){
					tip = left - 50;
					left = 50;
				}
				
				if(  left+swidth > wwidth ){
					left -= ( (left+swidth) - wwidth ) + 50;
				}
				return [ top, left, pos, bottom, tip ];
				
			},
			
			events : {
				'.m-p-controls>li>.cancel,.m-p-header .sl-close:click' : 'cancel',
				'.m-p-header:dblclick' : 'cancel',
				'.m-p-controls>li>.save,.m-p-header .sl-check:click' : 'save'
			},
			
			cancel : function( e ){

				// We will dont close the popup when in instant saving
				if( $('#instantSaving').length > 0 || or.tools.popup.no_close === true ){
					or.tools.popup.no_close = false;
					return;
				}

				if( e.target.tagName == 'INPUT' )
					return;
				
				var el = $(this).closest('.or-params-popup'), keepCurrent = el.data('keepCurrentPopups'),
					beforecalb, calb, aftercalb, i;
				
				if( typeof el.data('before_cancel') !==  undefined ){
					beforecalb = el.data('before_cancel');
					if( typeof beforecalb == 'function' ){
						if( beforecalb( el, e ) == 'prevent' )
							return;
					}else if( beforecalb !== undefined && beforecalb.length > 0 ){
						for( i = 0; i< beforecalb.length; i++ ){
							if( typeof beforecalb[i] == 'function' ){
								if( beforecalb[i]( el, e ) == 'prevent' )
									return;
							}
						}
					}
				}
				
				if( typeof el.data('cancel') !==  undefined ){
					calb = el.data('cancel');
					if( typeof calb == 'function' ){
						calb( el );
					}else if( calb !== undefined && calb.length > 0 ){
						for( i = 0; i< calb.length; i++ ){
							if( typeof calb[i] == 'function' )
								calb[i]( el );	
						}
					}
				}
				
				if( typeof el.data('after_cancel') !==  undefined ){
					aftercalb = el.data('after_cancel');
					if( typeof aftercalb == 'function' ){
						aftercalb( el );
					}else if( aftercalb !== undefined && aftercalb.length > 0 ){
						for( i = 0; i< aftercalb.length; i++ ){
							if( typeof aftercalb[i] == 'function' )
								aftercalb[i]( el );	
						}
					}
				}
					
				if( el.data('scrolltop') != undefined )
					e.data.scrollback( el.data('scrolltop'), el.data('button') );
					
				if( el.data('keepCurrentPopups') !== true )
					$('html').height('');
					
				el.remove();
				$('.sys-colorPicker').remove();
				// remove date picker
				$('.pika-single').remove();
				
				if( keepCurrent == false )
					$('.or-params-popup .sl-close.sl-func').trigger('click');
				
							 
      $( ".backgound_color" ).remove();
      $('.backgound_color').css('opacity','1');
     $('.backgound_color').css('height','0');
     $('.backgound_color').css('width','0');
				
			},
			
			save : function( e ){
				 
					 	
				var el = $(this).closest('.or-params-popup'), keepCurrent = el.data('keepCurrentPopups'), 
					beforecalb, calb, aftercalb, i;
				
				e.data.el = el;
		 
				if( typeof el.data('before_callback') !==  undefined ){ 
					beforecalb = el.data('before_callback');
					if( typeof beforecalb == 'function' ){
						beforecalb( el );
					}else if(  beforecalb !== undefined && beforecalb.length > 0 ){
						for( i = 0; i< beforecalb.length; i++ ){
							if( typeof beforecalb[i] == 'function' )
								beforecalb[i]( el );	
						}
					}
				}
				
				if( typeof el.data('callback') !==  undefined ){ 
					calb = el.data('callback');
					if( typeof calb == 'function' ){
						calb( el );
					}else if( calb !== undefined && calb.length > 0 ){
						for( i = 0; i< calb.length; i++ ){
							if( typeof calb[i] == 'function' )
								calb[i]( el );	
						}
					}
				}
				
				if( typeof el.data('after_callback') !==  undefined ){ 
					aftercalb = el.data('after_callback');
					if( typeof aftercalb == 'function' ){
						aftercalb( el );
					}else if( aftercalb !== undefined && aftercalb.length > 0 ){
						for( i = 0; i< aftercalb.length; i++ ){
							if( typeof aftercalb[i] == 'function' )
								aftercalb[i]( el );	
						}
					}
				}
				 if($(this).hasClass("sl-check") ){
					 
					 	el.find('.sl-close.sl-func').trigger('click'); 
				}
			  
				// We will dont close the popup when in instant saving
				if( $('#instantSaving').length > 0 || or.tools.popup.no_close === true ){
					or.tools.popup.no_close = false;
					return;
				}
					
				if( el.data('scrolltop') != undefined )
					e.data.scrollback( el.data('scrolltop'), el.data('button') );
				
				//el.remove();
				el.find('.sl-close.sl-func').trigger('click');
				
				if( keepCurrent == false ){
					$('.or-params-popup .sl-close.sl-func').trigger('click');
					$('html').height('');
				}
				
			},
			
			scrollback : function( sctop, btn ){
				
				
				var now = $(window).scrollTop();
				
				if( Math.abs( sctop - now ) > 200 ){
					
					or.ui.scrollAssistive( sctop );
					
				}
				
			},
			
			add_tab : function( pop, args ){
				
				args = $().extend( { title: '', class: '', cfg: '', callback: function(){} }, args );
				
				var ul = pop.find('.m-p-wrap ul.or-pop-tabs'), 
					slug = 'or-tab-'+Math.abs(parseInt(Math.random()*1000)), 
					li = $('<li data-tab="'+slug+'" data-cfg="'+args.cfg+'" class="'+args.class+'">'+args.title+'</li>');
				
				if( !ul.get(0) ){
					
					/* if this is first tab be added */
					ul = $('<ul class="or-pop-tabs"></ul>');
					
					if( pop.find('.fields-edit-form').length > 0 ){
						
						var fli = $('<li data-tab="fields-edit-form" class="or-tab-general-title active"><i class="et-tools"></i> General</li>')
						ul.append( fli );
						fli.on( 'click', function( e ){
							
							var wrp = $(this).closest('.m-p-wrap');
							
							wrp.find('>.or-pop-tabs li').removeClass('active');
							$(this).addClass('active');
							
							wrp.find('.m-p-body>.or-pop-tab').removeClass('form-active');
							wrp.find('.m-p-body>.fields-edit-form').addClass('form-active');
							
							if( e.originalEvent !== undefined )
								$(this).closest('.or-params-popup').
									data({ tab_active: $(this).parent().find('>li').index( this ) });
							
						});
						
					}
					
					
					pop.find('.m-p-header').after( ul );
					
				}
				
				ul.append( li );
				
				/* Add event for new tab which just be created */
				li.on( 'click', args.callback, function(e){
					
					var slug = $(this).data('tab'), wrp = $(this).closest('.m-p-wrap').find('>.m-p-body');
					
					$(this).closest('.m-p-wrap').find('>.or-pop-tabs li').removeClass('active');
					$(this).addClass('active');
					wrp.find('>.or-pop-tab').removeClass('form-active');
					var tab = wrp.find('>.'+slug), click_actived = false, this_index = $(this).parent().find('>li').index( this );
					
					if( $(this).closest('.or-params-popup').data('tab_active') == this_index )
							click_actived = true;
					
					if( e.originalEvent !== undefined )
						$(this).closest('.or-params-popup').data({ tab_active: this_index });
					
					if( tab.get(0) ){
						
						tab.addClass('form-active');
						/*
						*	If the tab is actived and click on it
						*	We don't need to run callback
						*/
						if( click_actived === true )
							return;
							
						var callback = $(this).data('callback');
						
						if( typeof callback == 'function' )
							callback( this, tab );
						
						return;
						
					}
					
					tab = $('<form class="or-pop-tab '+slug+' form-active"></form>');
					
					wrp.append( tab );
					
					tab.on( 'submit', function(){
						$(this).closest('.or-params-popup').find('.m-p-footer .save').trigger('click');
						return false;
					});
					
					if( typeof e.data == 'function' )
						tab.append( e.data( this , tab ) );
					
					var callback = $(this).data('callback');
					if( typeof callback == 'function' )
						callback( this, tab );
						
				});
				
			},
			
			callback : function( pop, args ){
				
				var calls;
				
				for( var st in args  ){
					calls = [];
					if( pop.data( st ) !== undefined && typeof pop.data( st ).push == 'function' )
						calls = pop.data( st );
	
					calls.push( args[st] );
					pop.data( st, calls );
				}
					
			}
			
		}),
		
		editor : {
			
			insert : function( id, html ){
				var editor,
					hasTinymce = typeof tinymce !== 'undefined',
					hasQuicktags = typeof QTags !== 'undefined';
			
				wpActiveEditor = id;
				
				if ( hasTinymce ) {
					editor = tinymce.get( wpActiveEditor );
				}

				if ( editor && ! editor.isHidden() ) {
					editor.execCommand( 'mceInsertContent', false, html );
				} else if ( hasQuicktags ) {
					QTags.insertContent( html );
				} else {
					document.getElementById( wpActiveEditor ).value = html;
				}

			},
			
			init : function ( textarea ) {
				
				if ( $( '#wp-link' ).parent().hasClass( 'wp-dialog' ) ) {
					$( '#wp-link' ).wpdialog( 'destroy' );
				}
				
				textarea.val( switchEditors.wpautop( textarea.val() ) );
				
				var eid = textarea.attr( "id" ), tmi = window.tinyMCEPreInit, tmic = tmi.mceInit, tmiq = tmi.qtInit;
				try {
					
					if ( _.isUndefined( tinyMCEPreInit.qtInit[ eid ] ) ) {
						tmiq[ eid ] = _.extend( {}, tmiq[ window.wpActiveEditor ], { id: eid } );
					}
					if ( tmi && tmic[ window.wpActiveEditor ] ) {
						tmic[ eid ] = _.extend( 
							{}, 
							tmic[ window.wpActiveEditor ],
							{
								resize: 'vertical',
								height: 250,
								id: eid,
								setup: function ( e ) {
									if ( typeof(e.on) != 'undefined' ) {
										e.on( 'init', function ( e ) {
											e.target.focus();
											window.wpActiveEditor = eid;
										});
									} else {
										e.onInit.add( function ( e ) {
											e.focus();
											window.wpActiveEditor = eid;
										});
									}
								}
							}
						);
						
						tmic[ eid ].wp_autoresize_on = false;
						
						window.wpActiveEditor = eid;
											
					}
					
					quicktags( tmic[ eid ] );
					QTags._buttonsInit();
					
					if ( window.tinymce ) {
						
						window.switchEditors && window.switchEditors.go( eid, 'tmce' );
						
						if ( tinymce.majorVersion === "4" ) {
							
							tinymce.execCommand( 'mceAddEditor', true, eid );
							
							var pop = $('#'+eid).closest('.or-params-popup');
							if( pop.length > 0 && typeof pop.data('on_editor_change') == 'function' ){
							 
								var action = function(e) {
									
									clearTimeout( document._or_editor_timer );
									
									document._or_editor_timer = setTimeout( function(){
										if( typeof pop.data('on_editor_change') == 'function' )
											pop.data('on_editor_change')( tinyMCE.activeEditor.getContent({format : 'raw'}) );
										
									}, 500 );
									
								}
								 
								tinyMCE.get( eid ).on('keyup', action ).on('mouseup', action ).on('change', action );
							}
						}
						
					}
					
				} catch ( e ) {
					$( '#wp-' + eid + '-wrap' ).html('Tinymce Error!');
					if ( console && console.error ) {
						console.error( e );
					}
				}
			}			
		},
		
		get_icons : function(){
			
			if( or.icons != undefined )
				return or.icons;
			
			function css_text(x) { return x.cssText; }
			
			var files = document.querySelectorAll('*[id^="or-sys-icon-"]'), html = '', css;
			
			if( !files || files.length === 0 )
				return '';
				
			for( var i=0; i < files.length; i++ ){
				
				css = Array.prototype.map.call( files[i].sheet.cssRules, css_text ).join('\n');	
			
				css = css.split('::before');
				
				css.forEach(function( i ){
					i = i.split('.')[1];
					if( i !== undefined && i.indexOf('/') == -1 )
						html += '<i title="'+i.replace(/[^a-z-0-9]/g, "")+'" class="'+i.replace(/[^a-z-0-9]/g, "")+'"></i>';
				});
			}
			
			or.icons = html;

			return html;
			
		}
		
	} );
	
	or.tools.base64.stringBuffer.prototype.append = function append(string) {
	    this.buffer.push(string);
	    return this
	};
	
	or.tools.base64.stringBuffer.prototype.toString = function toString() {
	    return this.buffer.join("")
	};
	
	or.tools.base64.utf8EncodeEnumerator.prototype = {
		
	    current: Number.NaN,
	    
	    moveNext: function() {
	        if (this._buffer.length > 0) {
	            this.current = this._buffer.shift();
	            return true
	        } else if (this._index >= (this._input.length - 1)) {
	            this.current = Number.NaN;
	            return false
	        } else {
	            var charCode = this._input.charCodeAt(++this._index);
	            if ((charCode == 13) && (this._input.charCodeAt(this._index + 1) == 10)) {
	                charCode = 10;
	                this._index += 2
	            }
	            if (charCode < 128) {
	                this.current = charCode
	            } else if ((charCode > 127) && (charCode < 2048)) {
	                this.current = (charCode >> 6) | 192;
	                this._buffer.push((charCode & 63) | 128)
	            } else {
	                this.current = (charCode >> 12) | 224;
	                this._buffer.push(((charCode >> 6) & 63) | 128);
	                this._buffer.push((charCode & 63) | 128)
	            }
	            return true
	        }
	    }
	};
	
	or.tools.base64.decodeEnumerator.prototype = {
		
	    current: 64,
	    
	    moveNext: function() {
	        if (this._buffer.length > 0) {
	            this.current = this._buffer.shift();
	            return true
	        } else if (this._index >= (this._input.length - 1)) {
	            this.current = 64;
	            return false
	        } else {
	            var enc1 = or.tools.base64.codex.indexOf(this._input.charAt(++this._index));
	            var enc2 = or.tools.base64.codex.indexOf(this._input.charAt(++this._index));
	            var enc3 = or.tools.base64.codex.indexOf(this._input.charAt(++this._index));
	            var enc4 = or.tools.base64.codex.indexOf(this._input.charAt(++this._index));
	            var chr1 = (enc1 << 2) | (enc2 >> 4);
	            var chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
	            var chr3 = ((enc3 & 3) << 6) | enc4;
	            this.current = chr1;
	            if (enc3 != 64) this._buffer.push(chr2);
	            if (enc4 != 64) this._buffer.push(chr3);
	            return true
	        }
	    }
	};
	
	
} )( jQuery );
