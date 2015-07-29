;
(function($) {
    $.fn.sendForm = function(options) {
        var form = this;
        var settings = $.extend({
            'url': '',
            'method': 'POST',
            'reset': true,
            'className': 'error',
            'statusId': 'form-status',
            'modalOpen': true,
            'modalId': '#thanks',
            'msgSend': 'Отправка данных',
            'msgDone': 'Данные успешно отправлены',
            'msgError': 'Ошибка отправки',
            'msgValError': 'Обзательное поле не заполнено',
            'formPosition': 'relative',
            'success': function() {

            }
        }, options);
        var statusId = '#' + settings.statusId;



        //Init function
        var init = function() {
            //Check if form have action url, send request to it
            if ($(form).attr('action') !== undefined && $(form).attr('action').length > 0) settings.url = $(form).attr('action');

            //Check if form have action url, send request to it
            if ($(form).attr('method') !== undefined && $(form).attr('method').length > 0) settings.method = $(form).attr('method');

            //Find all required input and add clas to them
            $(form).find('input')
                .filter('[required]')
                .addClass('form-required')
                .removeAttr('required');

            //Add status string
            if ($(statusId).length < 1) {
                $(form).append('<span id="' + settings.statusId + '"></span>');
            }
        }

        //Form send init
        var sendInit = function() {
            $(statusId).text(settings.msgSend);
            //Disable form button
            $(form).find('button').attr('disabled', 'true');
            //Add grey form hover
            $(form).append('<div id="formsendHover"><div class="form-loading"></div></div>').css('position', settings.formPosition);
        }

        //Succes form sending
        var successSend = function() {
            if (settings.reset) {
                resetForm(form);
            }
            settings.success();

            //Delete form hover
            $('#formsendHover').remove();
            //Set status text
            $(statusId).text(settings.msgDone);

            //Enable button
            $(form).children('button').removeAttr('disabled');

            //Clear status string after 3 second
            setTimeout(function() {
                $(statusId).text('')
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
            form.find('input').each(function() {
                if (validate(this)) {
                    error = true;
                }
            });
            //Send data
            if (!error) {
                var str = form.serialize();
                sendInit();
                $.ajax({
                    type: settings.method,
                    url: settings.url,
                    data: str,
                    success: function() {
                        successSend();
                    }
                }).fail(function() {
                    $(statusId).text(settings.msgError);
                });
            }
        }


        //Validation
        function validate(obj) {
            var error = false;
            if (!noEmpty($(obj)) && $(obj).hasClass('form-required')) {
                $(obj).addClass(settings.className);
                $(statusId).text(settings.msgValError);
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

    };
})(jQuery);
