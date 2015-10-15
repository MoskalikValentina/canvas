$(document).ready(function() {

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

});
