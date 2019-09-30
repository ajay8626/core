zoomOutMobile = () => {
    const viewport = document.querySelector('meta[name="viewport"]');

    if ( viewport ) {
      viewport.content = 'initial-scale=1';
      viewport.content = 'width=device-width';
    }
 }

	  jQuery(document).ready(function () {
		  
		  $('.lines-button').click(function( ) {	
				
			if( $(this).hasClass('active') ){
			 
				$('.lines-button').removeClass( 'active' );
				$('.mean-nav ul.firstul').slideUp();
				
			
				} else	{
				
				$('.lines-button').removeClass( 'active' );
				$(this).addClass( 'active' );
			
				$('.mean-nav ul.firstul').slideDown();
						
					
				}
			});
		  
    		jQuery('.main_menu').meanmenu();
			
		     var anchor = document.querySelectorAll('.lines-button');
    
    [].forEach.call(anchor, function(anchor){
      var open = false;
      anchor.onclick = function(event){
        event.preventDefault();
        if(!open){
          this.classList.add('meanclose');
          open = true;
        }
        else{
          this.classList.remove('meanclose');
          open = false;
        }
      }
    });
				
				$( ".newrequest ul li .addwsh .fa.fa-heart-o" ).click(function() {
					alertt("fgh");
  $( this ).toggleClass( "like" );
});
			
    });
	
	
	(function($){
		jQuery(document).ready(function(){
		var leng = $("#slideshow li").length;
			
			if(leng == 1){
				var slider = $('#slideshow').bxSlider({
					auto: false,
					mode:'fade',
					controls: false,
					pager: false,
					speed:0,	
					pagerCustom: null,	
					
				});
			}else{
				var slider = $('#slideshow').bxSlider({
					auto: true,
					mode:'fade',
					controls: false,
					pager: true,
					speed:800,
					 pagerCustom: '#bx-pager'	
				});
			}
		});
	})(jQuery);
  
 	


 equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 jQuery(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

jQuery(window).load(function() {
  equalheight('.rgt_blk');
  equalheight('.jobwrap .col1,.jobwrap .col2');
  equalheight('.newrequest ul li .rqstmain');
});


jQuery(window).resize(function(){
  equalheight('.rgt_blk');
	equalheight('.jobwrap .col1,.jobwrap .col2');
	equalheight('.newrequest ul li .rqstmain');
});

 			jQuery(document).ready(function(){
						jQuery('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  if (/^\s*$/.test(filename)) {
   jQuery(".file-upload").removeClass('active');
    jQuery("#noFile").text("Upload Your Image"); 
  }
  else {
    jQuery(".file-upload").addClass('active');
    jQuery("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
  }
});
});

$('document').ready(function () {
$('window').load(function () {
setTimeout(function(){
		// RESTYLE THE DROPDOWN MENU
    $('#google_translate_element').on("click", function () {

        // Change font family and color
        $("iframe").contents().find(".goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div, .goog-te-menu2 *")
            .css({
                'color': '#544F4B',
                'font-family': 'arial',
								'width':'100%'
            });
        // Change menu's padding
        $("iframe").contents().find('.goog-te-menu2-item-selected').css ('display', 'none');
			
				// Change menu's padding
        $("iframe").contents().find('.goog-te-menu2').css ('padding', '0px');
      
        // Change the padding of the languages
        $("iframe").contents().find('.goog-te-menu2-item div').css('padding', '20px');
      
        // Change the width of the languages
        $("iframe").contents().find('.goog-te-menu2-item').css('width', '100%');
        $("iframe").contents().find('td').css('width', '100%');
      
        // Change hover effects
        $("iframe").contents().find(".goog-te-menu2-item div").hover(function () {
            $(this).css('background-color', '#4D5170').find('span.text').css('color', 'white');
        }, function () {
            $(this).css('background-color', 'white').find('span.text').css('color', '#544F4B');
        });

        // Change Google's default blue border
        $("iframe").contents().find('.goog-te-menu2').css('border', 'none');

        // Change the iframe's box shadow
        $(".goog-te-menu-frame").css('box-shadow', '0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.3)');
        
      
      
        // Change the iframe's size and position?
        $(".goog-te-menu-frame").css({
            'height': '100%',
            'width': '100%',
            'top': '0px'
        });
        // Change iframes's size
        $("iframe").contents().find('.goog-te-menu2').css({
            'height': '100%',
            'width': '100%'
        });
    });
	}, 1000);
});
});

