(function(jQuery) { "use strict";
	jQuery.noConflict();

    jQuery(document).ready(function(){
		jQuery('.menu-bar .navbar-collapse li.dropdown a:first-of-type').removeAttr('class');
		jQuery('#offCanvas .nav li a:first-of-type').removeAttr('data-toggle');
        //offcanvas
        jQuery(".navbar-toggle").on('click', function () {
            jQuery("#offCanvas").toggleClass("open");
        });
        jQuery(".offcnvas__close").on('click', function (event) {
            event.preventDefault();
            jQuery("#offCanvas").removeClass("open");
        });

        jQuery('#offCanvas .nav .dropdown').on('shown.bs.dropdown', function(){
            jQuery(this).children('.dropdown-toggle').find('.fa').removeClass("fa-plus").addClass("fa-minus");
        }).on('hidden.bs.dropdown', function(){
            jQuery(this).children('.dropdown-toggle').find('.fa').removeClass("fa-minus").addClass("fa-plus");
        });

        jQuery("#offCanvas ul li .dropdown-menu li.dropdown .dropdown-toggle").on('click', function(){
           jQuery(this).children('.fa').toggleClass("fa-plus fa-minus");
        });


        jQuery('#offCanvas ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            jQuery(this).parent().siblings().removeClass('open');
            jQuery(this).parent().toggleClass('open');
        });

        //select 2 js
        if(jQuery('select').hasClass('classify-select')){
            jQuery(".classify-select").select2({
                theme: "bootstrap"
            });
        }
        //grid and list view
        jQuery('.view-head .view-as a').on('click', function(event){
            event.preventDefault();

            //add remove active class
            if(jQuery(this).hasClass("active")!== true)
            {
                jQuery('.view-head .view-as a').removeClass("active");
                jQuery(this) .addClass("active");
            }

            // add remove grid and list class
            var aclass = jQuery(this).attr('class');
            var st = aclass.split(' ');
            var firstClass = st[0];
            var selector = jQuery(this).closest('.view-head').next().find('div.item');
            var classStr = jQuery(selector).attr('class'),
                lastClass = classStr.substr( classStr.lastIndexOf(' ') + 1);
            jQuery(selector)
            // Remove last class
                .removeClass(lastClass)
                // Put back .item class + the clicked elements class with the added prefix "group-item-".
                .addClass('item-' + firstClass );
        });
        jQuery("#reset").click(function(e) {
            e.preventDefault();
            jQuery("#slider-range").slider("values", [0, 1000]).tooltip("option", "content", "0:1000").tooltip("close");
        });       
        //owl carousel
		setInterval(function(){ 
			jQuery('.owl-carousel').each(function(){
				var owl = jQuery(this);
				//number from single post page carousel
				var loopLength = owl.data('car-length');
				var divLength = jQuery(this).find("div.item").length;
				if(divLength > loopLength){
					owl.owlCarousel({
						rtl: owl.data("right"),
						dots : owl.data("dots"),
						items: owl.data("items"),
						slideBy : owl.data("slideby"),
						rewind: owl.data("rewind"),
						center : owl.data("center"),
						loop : owl.data("loop"),
						margin : owl.data("margin"),
						autoplay : owl.data("autoplay"),
						autoplayTimeout : owl.data("autoplay-timeout"),
						autoplayHoverPause : owl.data("autoplay-hover"),
						autoWidth:owl.data("auto-width"),
						autoHeight:owl.data("auto-Height"),
						merge: owl.data("merge"),
						nav : owl.data("nav"),
						navText: [
							"<i class='fa fa-angle-left'></i>",
							"<i class='fa fa-angle-right'></i>"
						],
						responsive:{
							0:{
								items:owl.data("responsive-small"),
								nav:false,
								dots : false
							},
							600:{
								items:owl.data("responsive-medium"),
								nav:false,
								dots : false
							},
							1000:{
								items:owl.data("responsive-large"),
								nav:false
							},
							1900:{
								items:owl.data("responsive-xlarge"),
								nav:false
							}
						}
					});

				}else{
					owl.owlCarousel({
						rtl: owl.data("right"),
						nav : owl.data("nav"),
						dots : owl.data("dots"),
						items: owl.data("items"),
						loop: false,
						margin: owl.data("margin"),
						autoplay:false,
						autoplayHoverPause:true,
						responsiveClass:true,
						autoWidth:owl.data("auto-width"),
						autoHeight:owl.data("auto-Height"),
						navText: [
							"<i class='fa fa-angle-left'></i>",
							"<i class='fa fa-angle-right'></i>"
						],
						responsive:{
							0:{
								items:owl.data("responsive-small"),
								nav:false
							},
							600:{
								items:owl.data("responsive-medium"),
								nav:false
							},
							1000:{
								items:owl.data("responsive-large"),
								nav:false
							},
							1900:{
								items:owl.data("responsive-xlarge"),
								nav:false
							}
						}
					});
				}
			});
		},1500);
        //tabber
        jQuery("span.tab").on("click", function(){
            if(jQuery(this).hasClass("active")!=true)
            {
                jQuery('.tab').removeClass("active");
                jQuery(this).addClass("active");
                var id = jQuery(this).attr("id");
                jQuery('.content').hide();
                jQuery("."+id).show();
            }
        });
        //back to top
        var offset = 220;
        var duration = 500;
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.back-to-top').fadeIn(duration);
            } else {
                jQuery('.back-to-top').fadeOut(duration);
            }
        });

        jQuery('.back-to-top').on("click", function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        });

        //accordion
        jQuery(".accordion-tab").on("click", function(){
            if(jQuery(this).hasClass("active")!=true)
            {
                jQuery('.accordion-tab').removeClass("active");
                jQuery(this).addClass("active");
                var id = jQuery(this).attr("id");
                jQuery('.accordion-content').slideUp();
                jQuery("."+id).slideDown();
            }
        });
		//match height
		jQuery('.matchheight').matchHeight();
		//Category box hover color		
		jQuery(".classify__catcolor").hover(
		  function() {
			var color = jQuery(this).attr('data-color');			
			jQuery(this).css('border-color', color);
			jQuery(this).children('h4').find('a').css('color', color);
		  }, function() {
			var colorSecondary = jQuery(this).attr('data-secondary-color');
			jQuery(this).css('border-color', '#e1e1e1');
			jQuery(this).children('h4').find('a').css('color', colorSecondary);			
		  }
		);
		jQuery(".classify__catcolor p a").hover(
		  function() {
			var color = jQuery(this).parent().parent().attr('data-color');			
			jQuery(this).css('color', color);
		  }, function() {			
			jQuery(this).css('color', '#888888');						
		  }
		);
		/*Classify toggele*/
		jQuery('.classify_toggle').on('click', function(){
			jQuery(this).next().collapse('toggle');
		});	
		/*Payper post with Woo Commerce*/
		jQuery(".classify_ppp_cart").hide();
		jQuery('a.classify_payperpost_btn').on('click', function(event){
			event.preventDefault();
			var $btn = jQuery(this);
			var product_id = $btn.next('form.classify_ppp_ajax').children('input.product_id').val();
			var post_id = $btn.next('form.classify_ppp_ajax').children('input.post_id').val();
			var post_title = $btn.next('form.classify_ppp_ajax').children('input.post_title').val();
			var days_to_expire = $btn.next('form.classify_ppp_ajax').children('input.days_to_expire').val();
			var data = {
				'action': 'classify_payperpost',
				'product_id': product_id,
				'post_id': post_id,
				'post_title': post_title,
				'days_to_expire': days_to_expire,
			};
			jQuery.ajax({
				url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
				type: "POST",
				data:{
					action:'classify_payperpost', 
					product_id: product_id,
					post_id: post_id,
					post_title: post_title,
					days_to_expire: days_to_expire,
				},
				success: function(data){
					$btn.hide();				
					$btn.siblings('.classify_ppp_cart').show();
				}
			});			
		});
		/*Payper post with Woo Commerce*/
		/*Pricing Plans with Woo Commerce*/
		jQuery(".classify_cart_btn").hide();
		jQuery('.classify_purchase_btn').on('click', function(event){
			event.preventDefault();
			var $btn = jQuery(this);			
			//var amt = jQuery(this).prev().children('input');		
			var AMT = jQuery(this).prev().children('input.AMT').val();		
			var wooID = jQuery(this).prev().children('input.wooID').val();		
			var CURRENCYCODE = jQuery(this).prev().children('input.CURRENCYCODE').val();		
			var user_ID = jQuery(this).prev().children('input.user_ID').val();		
			var plan_name = jQuery(this).prev().children('input.plan_name').val();		
			var total_featured = jQuery(this).prev().children('input.total_featured').val();		
			var total_regular = jQuery(this).prev().children('input.total_regular').val();		
			var plan_time = jQuery(this).prev().children('input.plan_time').val();
			var data = {
				'action': 'classify_implement_woo_ajax',
				'AMT': AMT,
				'product_id': wooID,
				'CURRENCYCODE': CURRENCYCODE,
				'user_ID': user_ID,
				'plan_name': plan_name,
				'total_featured': total_featured,
				'total_regular': total_regular,
				'plan_time': plan_time,
			};
			jQuery.ajax({
				url: ajaxurl,
				type: "POST",
				data : data,
				async : true,
				success: function(data){
					$btn.hide();
					$btn.next('.classify_cart_btn').show();
				}
			});
		});
		/*Pricing Plans with Woo Commerce*/
		/*pay per posts with Woo Commerce*/
		jQuery('.classify_pay_per_post').hide();
		jQuery('#submitcatID').on('change', function(event){
			jQuery('.classify_pay_per_post').hide();
			var catVal = jQuery("#submitcatID").val();
			var data = {
				'action': 'classify_pay_per_post_id',
				'catID': catVal,
			};
			jQuery.post(ajaxurl, data, function(response){
				if(response){
					jQuery('.classifyPPP').html(response);
					jQuery('.classify_pay_per_post').show();
				}
			});
		});
		/*pay per posts with Woo Commerce*/
		//Hide Quantity update from woocommerce cart page//
		jQuery('.woocommerce table .quantity input').attr('readonly', true);
		//Currency Tag apply//
		if(jQuery('select').hasClass('post_currency_tag')){			
			jQuery(document).on('change', '.post_currency_tag', function (){        
				var currencyTag = jQuery(this).val();
				var data = {
					'action': 'classify_change_currency_tag',
					'currencyTag': currencyTag,
				};
				jQuery.post(ajaxurl, data, function(response){
					jQuery('.currency__symbol').html(response);		
				});        
			});	
		}
		//Select Location//		
		jQuery('#classify_country').on('change', function(e){
			var data = {
				'action': 'get_states_of_country',
				'CID': jQuery(this).val()
			};		
			jQuery.post(ajaxurl, data, function(response){
				if(jQuery("#classify_state").length>0){
					jQuery("#classify_state").html(response);
				}
			});
		});
		jQuery('#classify_state').on('change', function(e) {
			var data = {
				'action': 'get_city_of_states',
				'ID': jQuery(this).val()
			};		
			jQuery.post(ajaxurl, data, function(response) {
				if(jQuery("#classify_city").length>0){
					jQuery("#classify_city").html(response);				
				}
			});
		});
		//Select Location//
		//Profile Image//
		function readProfileURL() {			
			if (this.files && this.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					jQuery('.author-avatar').children('.author-avatar').attr('src', e.target.result);
					jQuery("#classifyhiddenIMG").attr('val', e.target.result);
				};
				reader.readAsDataURL(this.files[0]);
			}
		}
		//Profile Image//
		jQuery(".author-UP").change(readProfileURL);
		//Select Box on Submit Ad Page.
		jQuery('.plan_radio').on('click', function() {
			jQuery(this).parent().parent().siblings().children().removeClass('active');
			if(jQuery(this).is(':checked')) {
				jQuery(this).parent().addClass('active');
			}
		});
		//Get Custom Fields on submit page//
		jQuery('.classifyExtraFields').hide();
		jQuery('#submitcatID').on('change', function(e){
			var catVal = jQuery("#submitcatID").val();
			var data = {
				'action': 'classify_Get_Custom_Fields',
				'classify_Cat_ID': catVal,
			};
			jQuery.post(ajaxurl, data, function(response){
				jQuery('.classifyExtraFields').html(response);
				if(response){
					jQuery('.classifyExtraFields').show();
				}			
			});
		});
		//Regular Ads Plan Id//
		jQuery('.classifyGetID').on('click', function(){
			if(jQuery(this).is(':checked')){
				var dataID = jQuery(this).attr('data-regular-id');
				jQuery('.regular_plan_id').val(dataID);
			}
		});
		//Search Page Categories//
		jQuery("#classify_search_cats").change(function(e){
		  jQuery(".custom-field-cat").hide();
		  jQuery(".autoHide").hide();
		  jQuery(".custom-field-cat-" + jQuery(this).val()).show();
		  jQuery(".hide-" + jQuery(this).val()).show();
		});	
		//Search Page Categories//
		jQuery('#offCanvas .nav > li > a:first-of-type').removeAttr('class');
    });

})(jQuery);
jQuery(window).on('load', function(){
	//WP Post Rating//
	jQuery(".post-ratings").contents().filter(function(){
		return (this.nodeType == 3);
	}).remove();
	jQuery(".post-ratings").children('strong').remove();
});
