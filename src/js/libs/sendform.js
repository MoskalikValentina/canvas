;
(function($) {
    $.fn.sendForm = function(options) {
        return this.each(function() {
            var form = this;
            var settings = $.extend({
                'url': '',
                'reset': true,
                'className': 'error',
                'statusId': 'form-status',
                'modalOpen': true,
                'modalId': '#thanks',
                'msgSend': 'Отправка данных',
                'msgDone': 'Данные успешно отправлены',
                'msgError': 'Ошибка отправки',
                'msgValError': 'Одно из полей не заполено',
                'spinnerColor': '#000',
                'formPosition': 'relative',
                'success': function(data) {}
            }, options);

            var statusId = '.' + settings.statusId;

            var init = function() {
                //Check if form have action url, send request to it
                if ($(form).attr('action') != undefined && $(form).attr('action').length > 0) settings.url = $(form).attr('action');

                //Find all required input and add clas to them
                $(form).find('*').filter('[required]').addClass('form-required').removeAttr('required')

                //Add status string
                if ($(form).find(statusId).length < 1) {
                    $(form).append('<span class="' + settings.statusId + '"></span>');
                }
            }

            //Form send init
            var sendInit = function() {
                $(form).find(statusId).text(settings.msgSend);
                //Disable form button
                $(form).find('button').attr('disabled', 'true');
                //Add form hover
                $(form).append('<div id="formsendHover"><div class="form-loading"></div></div>').css('position', settings.formPosition);
                $('.form-loading').css({
                    'border-color': settings.spinnerColor,
                    "border-top-color": 'transparent',
                    'border-right-color': 'transparent'
                });
            }

            //Succes form sending
            var successSend = function(data) {
                if (settings.reset) {
                    resetForm(form);
                }
                settings.success(data);

                //Delete form hover
                $('#formsendHover').remove();
                //Set status text
                $(form).find(statusId).text(settings.msgDone);

                //Enable button
                $(form).find('button').removeAttr('disabled');

                //Clear status string after 3 second
                setTimeout(function() {
                    $(form).find(statusId).text('')
                }, 3000);

                if (settings.modalOpen) {
                    $.magnificPopup.open({
                        items: {
                            src: settings.modalId,
                            type: 'inline',
                            closeBtnInside: true,
                            showCloseBtn: true
                        }
                    });
                }
            }


            var errorSend = function() {
                $(form).find(statusId).text(settings.msgError);
                $('#formsendHover').remove();
                //Enable button
                $(form).children('button').removeAttr('disabled');
            }

            init();

            //Forms new submit
            $(form).submit(function(event) {
                event.preventDefault();
                sendForm(this);
                return false;
            });

            //Send forms data
            function sendForm(input_form) {
                var form = $(input_form);
                var error = false;
                form.find('input, textarea').each(function() {
                    if (validate(this)) {
                        error = true;
                    }
                });
                //Send data
                if (!error) {
                    sendInit();
                    var str = form.serialize();
                    $.ajax({
                        type: 'POST',
                        url: settings.url,
                        data: str,
                        success: function(data) {
                            successSend(data);
                        }
                    }).fail(function() {
                        errorSend();
                    });
                }
            }


            //Validation
            function validate(obj) {
                var error = false;
                if (!noEmpty($(obj)) && $(obj).hasClass('form-required')) {
                    $(obj).addClass(settings.className);
                    $(form).find(statusId).text(settings.msgValError);
                    error = true;
                } else {
                    $(obj).removeClass(settings.className);
                }

                if ($(obj).attr('type') == 'email' && !isEmail($(obj))) {
                    $(obj).addClass(settings.className);
                    error = true;
                } else if ($(obj).attr('type') == 'email') {
                    $(obj).removeClass(settings.className);
                }

                if ($(obj).attr('name') == 'url' && !isUrl($(obj))) {
                    $(obj).addClass(settings.className);
                    error = true;
                } else if ($(obj).attr('name') == 'url') {
                    $(obj).removeClass(settings.className);
                }


                if ($(obj).hasClass('cyr-validation') && !isCyr($(obj))) {
                    $(obj).addClass(settings.className);
                    error = true;
                } else if ($(obj).hasClass('cyr-validation')) {
                    $(obj).removeClass(settings.className);
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

            //Is url testing
            function isUrl(element) {
                var url = /[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,}/;
                return url.test($(element).val());
            }

            //Is min 5 charachter
            function minLength(element) {
                console.log(element);
                if ($(element).val().length > 5)
                    return true;
            }

            //Form reset
            function resetForm(input_form) {
                var form = $(input_form);
                form.find('input[type=text],input[type=tel],input[type=email],textarea').val('');
                form.find('input:checkbox, input:radio').removeAttr('checked');
            }

            //Is url testing
            function isUrl(element) {
                var url = /[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,}/;
                return url.test($(element).val());
            }

            //Is min 5 charachter
            function minLength(element) {
                if ($(element).val().length > 5)
                    return true;
            }

            //Is cyrillic testing
            function isCyr(element) {
                var cyr = /[\u0400-\u04FF]/gi;
                return cyr.test($(element).val())
            }
        })
    };
})(jQuery);