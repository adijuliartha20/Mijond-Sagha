jQuery(document).ready(function(){
    jQuery("body").on("contextmenu",function(e){
        return false;
    });
    
    //Disable part of page
    jQuery("#id").on("contextmenu",function(e){
        return false;
    });



    events_home();
    events_about();
    events_product();
    events_single_product();
    events_testimonial();
    events_faq();
    events_contact();

    set_slide();
    function formatState (state) {
          if (!state.id) { return state.id; }
          var site_url = jQuery('#site_url').val()
          var jQuerystate = jQuery(
            '<span><img src="'+site_url+'/wp-content/themes/mijondsagha/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.element.value.toUpperCase() + '</span>'
          );
          return jQuerystate;
        };    

    jQuery("#lang_choice_1").select2({
        minimumResultsForSearch: -1,
        templateResult: formatState
    });    
   
    jQuery(window).scroll(function(){
        set_event_header_scroll()
    })


    events_blog()
});



function set_event_header_scroll(){
    var state_header = jQuery('#header').attr('data-rel');
    if(state_header=='' || typeof(state_header)=='undefined') return;

    var ww = jQuery(window).width();
    var wh = jQuery("#slide").height();
    var sh = 100;
    if(ww>768) var hms = Math.round(wh/sh);
    else var hms = Math.floor(wh/sh) - 2;
    //var hms = Math.floor(wh/sh) - 2;

    var mxs = hms * sh;
    var half_mxs = mxs/2;
    var mxo = 6;//8 tingkatan

    var single_opacity = hms/mxo;
    var pos = jQuery(window).scrollTop();
    var state = pos/sh;


    var curr_opacity = 1;
    //console.log(pos+'<='+mxs);

    if(pos<=mxs){
        var curr_opacity = (state * single_opacity)/10;
    }

    jQuery('#header').css('background','rgba(255,255,255,'+curr_opacity+')');

    if(pos>=half_mxs) jQuery('body').addClass('white-state-header');
    else jQuery('body').removeClass('white-state-header');
}


function events_home(){
    if(jQuery('#body-home').length==0) return;
    set_slick_product();
    set_slick_testimonial();
}


function events_about(){
    if(jQuery('#body-tentang-kami').length==0) return;
    set_slick_testimonial();
    magnificient_testimonial()
}


function events_product(){
    if(jQuery('#content-product-list').length==0) return;
    var ww = jQuery(window).width();
    if(ww > 580){
        var n = 5;
        if(ww <= 1024){
            n = 3;
        }
        //ert('ewe')
        for (i = n; i>=2; i--) {
            jQuery('#other-category option:nth-child('+i+')').remove()
        }

        var jQueryeventSelect = jQuery('#other-category').select2({})

        jQuery('#other-category').change(function(){
            var url = jQuery(this).val();
            if(url!='other'){
                window.location.href = url;
            }
        })
    }else{
        var jQueryeventSelect = jQuery('#all-category').select2({})

        jQuery('#all-category').change(function(){
            var url = jQuery(this).val();
            if(url!='all'){
                window.location.href = url;
            }
        })
    }
    
}


function events_faq(){
    if(jQuery('#content-qna-list').length==0) return;
    var ww = jQuery(window).width();
    if(ww <=1024){
        jQuery("#select-all-cat-faq").select2()
    }

     if(ww <= 580){

        jQuery('#slick-testimonial').slick({
                              centerMode: true,
                              slidesToShow: 3,
                              arrows: false
                               });
    }else{
        var ns = 4
        if(ww <=1440 || ww<=768) ns = 3;

        jQuery('#slick-testimonial').slick({
                              infinite: true,
                              slidesToShow: ns,
                              slidesToScroll: 1
                            });
    
    }    

    

    magnificient_testimonial()    


}


function magnificient_testimonial(){
    var id = '#slick-testimonial';
    if(jQuery('#slick-testimonial-new').length>0) id = '#slick-testimonial-new';


    jQuery(id).magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function(item) {
                return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
                return element.find('img');
            }
        }
        
    });
}

function events_single_product(){
    if(jQuery('#content-single-product').length==0)return;

    var ww = jQuery(window).width()
    if(ww<=580){
        jQuery('#brief-spb').after("<a id=\"readmore-detail-product\" class=\"link-click\" onClick=\"goto_detail_produk()\" >"+jQuery('#readmore-txt').val()+"...</a>");         
    }else{
        jQuery('#content-spb p:last-child').append("<a id=\"readmore-detail-product\" class=\"link-click\" onClick=\"goto_detail_produk()\" >"+jQuery('#readmore-txt').val()+"...</a>");
    }
    

    jQuery('#readmore-detail-product').click(function (){
        scroll_to_id('#cont-single-produk-detail',100,'')
    })

    

     if(ww <= 580){

        jQuery('#slick-testimonial').slick({
                              centerMode: true,
                              slidesToShow: 3,
                              arrows: false
                               });
    }else{
        var ns = 4
        if(ww <=1440) ns = 3;
        jQuery('#slick-testimonial').slick({
                              infinite: true,
                              slidesToShow: ns,
                              slidesToScroll: 1
                            });
    
    }    

    

    magnificient_testimonial()    
}

function goto_detail_produk(){

}

function scroll_to_detail_produk(e,target){
    var mt = (+100);
    scroll_to_id(target,mt,'')    

    jQuery('#panel-spd button').removeClass('current');
    jQuery(e.target).addClass('current');
}

function scroll_to_id(target,mt,id){
    console.log(target+' '+mt+' '+id);
    var tt = jQuery(target)
    jQuery('html, body').stop().animate({
        scrollTop: tt.offset().top - mt
    }, 1000,function (){

    });   
}


function events_testimonial(){
    if(jQuery('#content-testimonial-list').length==0)return;
    jQuery('#filter-testimonial').select2({})

    var ww = jQuery(window).width()
    //alert(ww);
    
    /*var jQuerygrid = jQuery('.content-list-testimonial').isotope({
                  itemSelector: '.item-testimonial ',
                  layoutMode: 'fitRows',
                  getSortData: {
                    name: '.name',
                    symbol: '.symbol',
                    number: '.number parseInt',
                    category: '[data-category]',
                    weight: function( itemElem ) {
                      //var weight = jQuery( itemElem ).find('.weight').text();
                      //return parseFloat( weight.replace( /[\(\)]/g, '') );
                    }
                  }
                });

    */
    jQuery('#filter-testimonial').change(function (){
        var filterValue = jQuery(this).val()
        //if(filterValue=='*')
        window.location.href = filterValue;
        //jQuerygrid.isotope({ filter: filterValue });
    })
    magnificient_testimonial()
}


function events_contact(){ 
    if(jQuery('#content-contact').length==0) return;
    jQuery('#country').select2()
    jQuery('#province').select2()
    jQuery('#city').select2()
}




function events_blog(){
    if(jQuery('#page-blog').length > 0 || jQuery('#body-search').length > 0) {
        var ww  = jQuery(window).width()

        if(ww > 580){
                        jQuery('#slick-popular').slick({
                                  infinite: true,
                                  slidesToShow: 3,
                                  slidesToScroll: 1
                                });
        }

    }
}



function set_slick_product(){
    if(jQuery('#product-home').length==0) return;
    var ww  = jQuery(window).width()

    if(ww > 580){
                    jQuery('#slick-product').slick({
                              infinite: true,
                              slidesToShow: 2,
                              slidesToScroll: 2
                            });
    }
}

function set_slick_testimonial(){
    if(jQuery('#slick-testimonial').length==0) return;
    var ww  = jQuery(window).width()

    if(ww <= 1024){

        jQuery('#slick-testimonial').slick({
                              centerMode: true,
                              slidesToShow: 3,
                              arrows: false
                               });
    }else{
        jQuery('#slick-testimonial').slick({
                              infinite: true,
                              slidesToShow: 3,
                              slidesToScroll: 3
                               });
    
    }

    magnificient_testimonial()    

    /*jQuery('#slick-testimonial').slick({
                              infinite: true,
                              slidesToShow: 3,
                              slidesToScroll: 3,
                              responsive: [
                                {
                                  breakpoint: 768,
                                  settings: {
                                    arrows: false,
                                    centerMode: true,
                                    slidesToShow: 1
                                  }
                                },
                                {
                                  breakpoint: 480,
                                  settings: {
                                    arrows: false,
                                    centerMode: true,
                                    slidesToShow: 1
                                  }
                                }
                              ]
                            });*/
}

function set_slide(){
    if(jQuery('#slide input').length>0){
        var slide = [];
        jQuery('#slide input').each(function(){
            var src = jQuery(this).val();
            var slide_object = new Object();
            slide_object.src = src;
            slide.push(slide_object);
        })

        var np = jQuery('#slide input').length;
        if(np > 1){
            var btn = '';
            for(i=0; i<np; i++){
                btn += '<button onClick="goto_slide(event)" data-i="'+i+'"></button>';               
            }
            //jQuery('#slide').append('<div id="pagging-slide" class="pagging-slide">'+btn+'</div>');
        }

        jQuery("#slide").vegas({
            delay: 5000,
            slides:slide,
            transition: 'fade',
            timer: false,
            walk: function (nb) {               
                //jQuery('#pagging-slide button').removeClass('active').eq(nb).addClass('active');
            },
            init: function (globalSettings) {},
        });
    }
}


function scroll_down(e){
    var target = jQuery('[name=section-scroll]')

    jQuery('html, body').stop().animate({
        scrollTop: target.offset().top - 0
    }, 1000,function (){
    }); 
}

function scroll_up(e){
    jQuery('html, body').stop().animate({
        scrollTop: 0
    }, 1000,function (){
    });    
}



jQuery(document).ready(function () {
   // togglescroll()   

    var timeoutId;
    jQuery(".icon").click(function () {
        if(timeoutId ){
            clearTimeout(timeoutId );  
        }

        timeoutId = setTimeout(function(){
            if(!jQuery('body').hasClass('nnoscroll')){
                jQuery("#mobilenav").removeAttr( 'style' ); 
                jQuery(".mobilenav").slideDown(500);
                jQuery('.header').addClass('hashowmobile');
            }else{
                jQuery(".mobilenav").slideUp(500);
                jQuery('.header').removeClass('hashowmobile');
            }

            jQuery(".top-menu").toggleClass("top-animate");
            jQuery("body").toggleClass("nnoscroll");
            if (jQuery('body').hasClass('nnoscroll')) scroll = false
            else scroll = true

            jQuery(".mid-menu").toggleClass("mid-animate");
            jQuery(".bottom-menu").toggleClass("bottom-animate");     

        }, 250);
    });
});


// PUSH ESC KEY TO EXIT



jQuery(document).keydown(function(e) {
    if (e.keyCode == 27) {
        jQuery(".mobilenav").slideUp(500);
        jQuery(".top-menu").removeClass("top-animate");
        jQuery("body").removeClass("nnoscroll");
        jQuery(".mid-menu").removeClass("mid-animate");
        jQuery(".bottom-menu").removeClass("bottom-animate");
    }
});


function reset_required_field_agent(){
    jQuery('#country').removeClass('error')
    jQuery('#province').removeClass('error')
}

function get_province(e){
    reset_required_field_agent()
    var country = jQuery(e.target).val()

    var dt =  new Object();
        dt.action           = 'get-province-now';
        dt.id               = jQuery(e.target).val();

    jQuery('#province option').remove();
    jQuery('#province').append('<option value="">'+jQuery('#please_wait').val()+'...</option>');    

    jQuery('#city option').remove();
    jQuery('#city').append('<option value="">'+jQuery('#city_txt').val()+'</option>');    

    jQuery.post(d.url,dt,function(response){
        var res = jQuery.parseJSON(response);
        jQuery('#province option').remove();
        var opt = '<option value="">'+jQuery('#state_txt').val()+'</option>';
        if(res.status=='success'){
            jQuery.each(res.dt,function(i,v){
                opt += '<option value="'+v.id+'">'+v.state+'</option>';
            });
        }
        jQuery('#province').append(opt);
    })
}


function get_city(e){
    reset_required_field_agent()
    var dt =  new Object();
        dt.action           = 'get-city-now';
        dt.id               = jQuery(e.target).val();

    jQuery('#city option').remove();
    jQuery('#city').append('<option value="">'+jQuery('#please_wait').val()+'...</option>');    

    jQuery.post(d.url,dt,function(response){
        var res = jQuery.parseJSON(response);
        jQuery('#city option').remove();
        var opt = '<option value="">'+jQuery('#city_txt').val()+'</option>';
        if(res.status=='success'){
            jQuery.each(res.dt,function(i,v){
                opt += '<option value="'+v.id+'">'+v.city+'</option>';
                //console.log('i='+v.id+', v='+v.state);
            });
        }
        jQuery('#city').append(opt);
    })
}

function search_agent(e){
    var country = jQuery('#country').val()
    var state = jQuery('#province').val()


    var error = 0;

    if(country == ''){
        jQuery('#country').addClass('error')
        error++;
    }

    if(state == ''){
        jQuery('#province').addClass('error')
        error++;
    }

    if(error==0){
        
        search_agent_now(country,state)
        

          
    }
}



function search_agent_now(country,state){
    var txt_looking = jQuery('#looking_agent_txt').val()
    jQuery('#item-country-hide').slideUp(300)
    setTimeout(function(){
        jQuery('#result-agent').html('');
        jQuery('#result-agent').append('<div id="looking" class="looking hide">'+txt_looking+'...</div>');
        jQuery('#looking').slideDown(600)     


        var dt =  new Object();
            dt.action   = 'get-agent-now';
            dt.country      = country;    
            dt.state        = state;    
            dt.city         = jQuery('#city').val(); 

        jQuery.post(d.url,dt,function(response){
            var res = jQuery.parseJSON(response);
            var temp = '';
            if(res.status=='success'){                
                var dtt = res.dt;
                var temp_city = '';
                jQuery.each(dtt.data,function(i,v){
                    //console.log(i); console.log(v);
                    temp_city += temp_city_agent(i,v)
                })

                temp =  '<div id="item-country-hide" class="item-country clearfix hide">'+
                                '<label class="bdr-gray">'+dtt.name+'</label>'+
                                '<div class="list-city clearfix">'+ temp_city+'</div>'+
                            '</div>'; 
            }else{
                //'<h2>Please contact us use information below:</h2>'+
                temp = jQuery('#dtt-contact').clone()
            }

            setTimeout(function(){
                jQuery('#result-agent').html('');
                jQuery('#result-agent').append(temp);
                jQuery('#result-agent > div').slideDown(600)
            },1500)
        })     


    },300)
}

function search_agent_area(e){
    var country = jQuery(e.target).attr('data-country')
    var state = jQuery(e.target).attr('data-state')

    search_agent_now(country,state)
}


function temp_city_agent(state,dt){
    var temp_agent = '';

    jQuery.each(dt,function(i,v){
        temp_agent += temp_item_agent(i,v);
    })



    var temp = '<div class="item-city fleft clearfix">'+
                    '<label>'+state+'</label>'+
                    '<div class="list-agent">'+temp_agent+'</div>'+
                '</div>' ;
    return temp;              
}




/*function temp_country_agent(state,dt,country){
    var temp_city = '';
    //console.log(dt)
    jQuery.each(dt,function(i,v){
         //console.log(i)
         //console.log(v)
        temp_city += temp_city_agent(state,v);
    })


    var temp =  '<div id="item-country-hide" class="item-country clearfix hide">'+
                '<label class="bdr-gray">'+country+'</label>'+
                '<div class="list-city clearfix">'+ temp_city+'</div>'+
            '</div>';    

    return temp;        
}

function temp_city_agent(state,dt){
    var temp_agent = '';

    //console.log(name)
    //console.log(dt)
    jQuery.each(dt,function(i,v){
        //temp_agent += temp_item_agent(i,v);
    })



    var temp = '<div class="item-city fleft clearfix">'+
                    '<label>'+state+'</label>'+
                    '<div class="list-agent">'+temp_agent+'</div>'+
                '</div>' ;
    return temp;              
}*/


function temp_item_agent(i,v){
    var txt = jQuery('#detail_txt').val()
    //console.log(v)
    var temp = '<div class="item-agent clearfix">'+
                    '<label class="fleft">'+v.name+'</label>'+
                    '<button class="btn-white-purple fright" data-name="'+v.name+'" data-country="'+v.country+'" data-state="'+v.state+'" data-city="'+v.city+'" data-image="'+v.image+'" data-account_facebook="'+v.account_facebook+'" data-phone="'+v.phone+'" onClick="show_detail_agent(event)">'+
                        txt+
                    '</button>'+
                '</div>';
    return temp;            
}


function show_detail_agent(e){
     
    var pp_agent = jQuery(e.target).attr('data-image')
    var name_agent = jQuery(e.target).attr('data-name')
    var phone_agent = jQuery(e.target).attr('data-phone')
    var city_country_agent = jQuery(e.target).attr('data-city')+', '+jQuery(e.target).attr('data-state')+', '+jQuery(e.target).attr('data-country')
    //var link_map_agent = jQuery(e.target).attr('data-link_map')
    var link_fb_agent = jQuery(e.target).attr('data-account_facebook')


    /*console.log(pp_agent)
    console.log(name_agent)
    console.log(phone_agent)
    console.log(city_country_agent)
    console.log(link_map_agent)
    console.log(link_fb_agent)*/


    jQuery('#pp_agent').attr('src',pp_agent);
    jQuery('#name_agent').text(name_agent);
    jQuery('#phone_agent').text(phone_agent);
    jQuery('#phone_agent').attr('href','tel:'+phone_agent);
    jQuery('#city_country_agent').text(city_country_agent);

    //jQuery('#link_map_agent').attr('href',link_map_agent);
    jQuery('#link_fb_agent').attr('href',link_fb_agent);

    jQuery('#overlay').fadeIn(300)
    jQuery('#popup').fadeIn(300)
}

function hide_detail_agent(e){
    jQuery('#overlay').fadeOut(300)
    jQuery('#popup').fadeOut(300)
}



function goto_this(e){
    var site_url = jQuery(e.target).val()
    window.location.href = site_url
}


function fbs_click(id) {
    var leftPosition, topPosition;
    var width = 400;
    var height = 300;

    //Allow for borders.
    leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
    //Allow for title and status bars.
    topPosition = (window.screen.height / 2) - ((height / 2) + 50);
    var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
    u=location.href;
    t=document.title;
    var url_app = jQuery('#'+id).attr('data-url');
    //console.log(url_app);
    window.open(url_app+encodeURIComponent(u)+'?v=1&t='+encodeURIComponent(t),'sharer', windowFeatures);
    return false;
}