$(document).ready(function() {

    //Set timer
    $('.clock').countdown('2015/6/10', function(event) {
        $(this).html(event.strftime('%D:%H:%M:%S'));
    });

    //Popup form Call me
    $('.call-me').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        callbacks: {
            beforeOpen: function() {
                $('.top-panel').css('margin-left', '-9px');
            },
            beforeClose: function() {
                $('.top-panel').css('margin-left', '0px');
            }
        }
    });

    //Cart form
    $('.cart').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        callbacks: {
            beforeOpen: function() {
                $('.top-panel').css('margin-left', '-9px');
            },
            beforeClose: function() {
                $('.top-panel').css('margin-left', '0px');
            }
        }
    });

    //Video form
    $('.video-lnk').magnificPopup({
        preloader: false,
        type: 'iframe',
        callbacks: {
            beforeOpen: function() {
                $('.top-panel').css('margin-left', '-9px');
            },
            beforeClose: function() {
                $('.top-panel').css('margin-left', '0px');
            }
        }
    });

    //Feedback form
    $('#feedback-btn').magnificPopup({
        preloader: false,
        type: 'inline',
        focus: '#name',
        callbacks: {
            beforeOpen: function() {
                $('.top-panel').css('margin-left', '-9px');
            },
            beforeClose: function() {
                $('.top-panel').css('margin-left', '0px');
            }
        }
    });

    //Close form Call me thanks
    $('.thanks-close').click(function() {
        $.magnificPopup.close();
    });

    //Popup form Order
    $('.order').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        callbacks: {
            beforeOpen: function() {
                $('.top-panel').css('margin-left', '-9px');
            },
            beforeClose: function() {
                $('.top-panel').css('margin-left', '0px');
            }
        }
    });

    //Phone number toggle
    $('.labels a').click(function() {
        var oper = $(this).attr('href').slice(1);
        $('.labels li').removeClass('active');
        $(this).parent().addClass('active');
        $('.phones li').css('display', 'none');
        $('.' + oper).css('display', 'block');
    });

    //Set color at all block
    $('label').click(function() {
        var color = $(this).attr('class').split(' ')[0];
        var li = $('.' + color).parent();
        $(li).children().attr('checked', 'true');
    });
    //Tooltip for pay methods init
    $('[data-toggle="tooltip"]').tooltip()
        //Phone mask
    $(".mask-phone").mask("(999) 999-9999");
    //Delivery accordeon
    $('.odessa').hide();
    $('.np').hide();

    $('#delivery1').click(function() {
        $('.np').show('fast');
        $('.odessa').hide('fast');
    });
    $('#delivery2').click(function() {
            $('.odessa').show('fast');
            $('.np').hide('fast');
        })
        //Slider init
    $('.feedback-lst').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: '.prev',
        nextArrow: '.next',
        responsive: [{
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    //Forms new submit
    $('form').submit(function(event) {
        event.preventDefault();
        sendForm(this);
        return false;
    });

    //Send forms data
    function sendForm(input_form) {
        var form = $(input_form);
        var error = false;
        form.find('input').each(function() {
            if (validate(this)) {
                error = true;
            }
        });
        //Send data

        if (!error) {
            var str = form.serialize();
            console.log(str);
            $.ajax({
                type: 'POST',
                data: str,
                success: function() {
                    resetForm(form);
                    if (form.parent().attr('id') == 'feedback') {
                        $.magnificPopup.open({
                            items: {
                                src: '#feedback-thanks',
                                type: 'inline',
                                closeBtnInside: true,
                                showCloseBtn: true
                            }
                        });
                    } else {
                        $.magnificPopup.open({
                            items: {
                                src: '#call-me-thanks',
                                type: 'inline',
                                closeBtnInside: true,
                                showCloseBtn: true
                            }
                        });
                    }


                }
            })
        }
    }

    //Validation
    function validate(obj) {
        var error = false;
        if (!noEmpty($(obj))) {
            $(obj).addClass('error');
            error = true;
        } else {
            $(obj).removeClass('error');
        }

        if ($(obj).attr('type') == 'email' && !isEmail($(obj))) {
            $(obj).addClass('error');
            error = true;
        } else if ($(obj).attr('type') == 'email') {
            $(obj).removeClass('error');
        }

        return error;
    }

    //Is on no empty value testing
    function noEmpty(element) {
        if ($(element).val() == '') {
            return false;
        } else {
            return true;
        }
    }

    //Is email testing
    function isEmail(element) {
        var email = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/;
        return email.test($(element).val());
    }

    //Form reset
    function resetForm(input_form) {
        var form = $(input_form);
        form.find('input[type=text],input[type=tel],input[type=email],textarea').val('');
        form.find('input:checkbox, input:radio').removeAttr('checked');
    }

    //Top panel animation
    $('.top-panel').css('height', 0);

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.top-panel').animate({
                'height': 58,
            }, 100);
        } else if ($(this).scrollTop() <= 100) {
            $('.top-panel').animate({
                'height': 0,
            }, 100);
        }
    }); //scroll

    //Up-down arrows in form
    $('.up').click(function() {
        var td = $(this).parent();
        var input = $(td).children()[1];
        $(input).val(function(i, old) {
            return ++old;
        });
    });

    $('.down').click(function() {
        var td = $(this).parent();
        var input = $(td).children()[1];
        if ($(input).val() > 0) {
            $(input).val(function(i, old) {
                return --old;
            });
        }
    });

    //Menu animation
    $('#catalog').click(function() {
        console.log('click');
        $('html, body').animate({
            scrollTop: $(".catalog").offset().top
        }, 1000);
    })
    $('#pay').click(function() {
        console.log('click');
        $('html, body').animate({
            scrollTop: $(".delivery").offset().top
        }, 1000);
    })
    $('#feedback').click(function() {
        console.log('click');
        $('html, body').animate({
            scrollTop: $(".feedback").offset().top
        }, 1000);
    })
});
