/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

jQuery(function ($) {

    // Stikcy Header
    var header = $('#sp-header');
    if (header.length) {
        var headerHeight = header.outerHeight();
        var stickyHeaderTop = header.offset().top;
        header.before('<div class="nav-placeholder"></div>');
        var stickyHeader = function() {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > stickyHeaderTop) {
                header.addClass('header-sticky');
                $('.nav-placeholder').height(headerHeight);
            } else {
                if (header.hasClass('header-sticky')) {
                    header.removeClass('header-sticky');
                    $('.nav-placeholder').height('inherit');
                }
            }
        };
        stickyHeader();
        $(window).on('scroll', function() {
            stickyHeader();
        });
    }

    // go to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.sp-scroll-up').fadeIn();
        } else {
            $('.sp-scroll-up').fadeOut(400);
        }
    });

    $('.sp-scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    //mega menu
    $('.sp-megamenu-wrapper').parent().parent().css('position', 'static').parent().css('position', 'relative');
    $('.sp-menu-full').each(function () {
        $(this).parent().addClass('menu-justify');
    });

    // Offcanvs
    $('#offcanvas-toggler').on('click', function (event) {
        event.preventDefault();
        $('.offcanvas-init').addClass('offcanvas-active');
    });

    $('.close-offcanvas, .offcanvas-overlay').on('click', function (event) {
        event.preventDefault();
        $('.offcanvas-init').removeClass('offcanvas-active');
    });
    
    $(document).on('click', '.offcanvas-inner .menu-toggler', function(event){
        event.preventDefault();
        $(this).closest('.menu-parent').toggleClass('menu-parent-open').find('>.menu-child').slideToggle(400);
    });

    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //  Cookie consent
    $('.sp-cookie-allow').on('click', function(event) {
        event.preventDefault();
        
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();               
        document.cookie = "spcookie_status=ok" + expires + "; path=/";

        $(this).closest('.sp-cookie-consent').fadeOut();
    });

    $(".btn-group label:not(.active)").click(function() {
			var label = $(this);
			var input = $('#' + label.attr('for'));
            
			if (!input.prop('checked')) {
				label.closest('.btn-group').find("label").removeClass('active btn-success btn-danger btn-primary');
				if (input.val() === '') {
					label.addClass('active btn-primary');
				} else if (input.val() == 0) {
					label.addClass('active btn-danger');
				} else {
					label.addClass('active btn-success');
				}
				input.prop('checked', true);
				input.trigger('change');
            }
            var parent = $(this).parents('#attrib-helix_ultimate_blog_options'); 
            if( parent ){ 
                showCategoryItems( parent, input.val() )
            }
    });
    
    $(".btn-group input[checked=checked]").each(function() {
        if ($(this).val() == '') {
            $("label[for=" + $(this).attr('id') + "]").addClass('active btn btn-primary');
        } else if ($(this).val() == 0) {
            $("label[for=" + $(this).attr('id') + "]").addClass('active btn btn-danger');
        } else {
            $("label[for=" + $(this).attr('id') + "]").addClass('active btn btn-success');
        }
        var parent = $(this).parents('#attrib-helix_ultimate_blog_options'); 
        if( parent ){
            parent.find('*[data-showon]').each( function() {
                $(this).hide();
            })
        }
    });

    function showCategoryItems(parent, value){
        var controlGroup = parent.find('*[data-showon]'); 
        controlGroup.each( function() {
            var data = $(this).attr('data-showon')
            data = typeof data !== 'undefined' ? JSON.parse( data ) : []
            if( data.length > 0 ){
                if(typeof data[0].values !== 'undefined' && data[0].values.includes( value )){
                    $(this).slideDown();
                }else{
                    $(this).hide();
                }
            }
        })
    }
          
    // Newsletter
    $(document).on('submit', '.form-newsletter', function(event) {
        event.preventDefault();
        var btn = $(this).find('.btn');
        var body = $(this).closest('.mod-newsletter');
        var request = {
            'option' : 'com_ajax',
            'module' : 'newsletter',
            'email'   : $(this).find('input[name=email]').val(),
            'format' : '{$format}'
        };

        $(this).parent().find('.alert').remove();

        $.ajax({
            type   : 'POST',
            data   : request,
            beforeSend: function() {
                btn.find('.newsletter-btn-icon').removeClass('fa-envelope').addClass('fa-spinner fa-spin');
            },
            success: function (response) {

                var data = $.parseJSON(response);

                if(data.status == 'subscribed') {
                    btn.find('.newsletter-btn-icon').removeClass('fa-spinner fa-spin').addClass('fa-check');
                    btn.find('.newsletter-btn-text').text(data.message);
                }

                if(data.status == 'pending') {
                    body.find('.alert').remove();
                    body.append( "<div class='alert alert-warning'>"+ data.message +"</div>" );
                    btn.find('.newsletter-btn-icon').removeClass('fa-spinner fa-spin').removeClass('fa-check').addClass('fa-envelope');
                    btn.find('.newsletter-btn-text').text('Subscribe');
                }

                if(data.status == 400) {
                    body.find('.alert').remove();
                    body.append( "<div class='alert alert-danger'>"+ data.message +"</div>" );
                    btn.find('.newsletter-btn-icon').removeClass('fa-spinner fa-spin').removeClass('fa-check').addClass('fa-envelope');
                    btn.find('.newsletter-btn-text').text('Subscribe');
                }
            },
            error: function(response) {
                var data = '',
                    obj = $.parseJSON(response.responseText);
                for(key in obj){
                    data = data + ' ' + obj[key] + '<br/>';
                }
                body.find('.alert').remove();
                body.append( "<div class='alert alert-danger'>"+ data +"</div>" );
                btn.find('.newsletter-btn-icon').removeClass('fa-spinner fa-spin').removeClass('fa-check').addClass('fa-envelope');
                btn.find('.newsletter-btn-text').text('Subscribe');
            }
        });
        return false;
    });

    // Login
    $(document).on('click', '.anchor-login-dropdown', function(event) {
        event.preventDefault();
        $('.login-dropdown').fadeToggle(200);
    });

    // Search Popup
    $(document).on('click', '.anchor-search-popup', function(event) {
        event.preventDefault();
        $('body').addClass('search-popup-open');
        $('.search-popup').fadeIn(200);
    });

    $(document).on('click', '.search-popup-close', function(event) {
        event.preventDefault();
        $('.search-popup').fadeOut(200);
        $('body').removeClass('search-popup-open');
    });

    // Contact Form
    $('#contactForm').on('submit', function(event) {
        event.preventDefault();
        var btn = $(this).find('.btn');
        var $this = $(this);

        var name = $(this).find('#contactName').val(),
            email = $(this).find('#contactEmail').val(),
            subject = $(this).find('#contactSubject').val(),
            message = $(this).find('#contactMessage').val(),
            captcha = $(this).find('#g-recaptcha-response').val();

        var request = {
            'option' : 'com_simplepage',
            'task' : 'sendEmail',
            'name' : name,
            'email' : email,
            'subject' : subject,
            'message' : message,
            'g-recaptcha-response' : captcha
        };

        $.ajax({
            type   : 'POST',
            data   : request,
            beforeSend: function() {
                btn.html('<span class="fa fa-spinner fa-spin"></span> &nbsp;Sending...');
            },
            success: function (response) {
                var data = $.parseJSON(response);

                btn.html('Send Message');

                if(data.status) {
                    $this.find('.alert-message').removeClass('alert-message-danger').addClass('alert-message-success').text(data.message).fadeIn(200);
                    $this.trigger('reset');
                    grecaptcha.reset();
                } else {
                    $this.find('.alert-message').removeClass('alert-message-success').addClass('alert-message-danger').text(data.message).fadeIn(200);
                }
            },
            error: function(response) {
                var data = '',
                    obj = $.parseJSON(response.responseText);
                for(key in obj){
                    data = data + ' ' + obj[key] + '<br/>';
                }

                $this.find('.alert-message').removeClass('alert-message-success').addClass('alert-message-danger').text(data).fadeIn(200);
                btn.html('Send Message');
            }
        });
        return false;
    });


    $.fn.visible = function(partial) {
        var $t            = $(this),
            $w            = $(window),
            viewTop       = $w.scrollTop(),
            viewBottom    = viewTop + $w.height(),
            _top          = $t.offset().top,
            _bottom       = _top + $t.height(),
            compareTop    = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;
      
        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));
    };

    $(window).scroll(function(event) {
        $(".eb-entry-body").each(function(i, el) {
            var el = $(el);
            if (el.visible(true)) {
                el.addClass("eb-entry-body-visible"); 
            } else {
                el.removeClass("eb-entry-body-visible");
            }
        });
    });

});
  
  
