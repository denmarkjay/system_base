/**
 * Created by Admin on 8/5/2016.
 */
(function(dcument, window, $) {
    'user strict';
    var Site = window.Site;
    $(document).ready(function($) {
        Site.run();
    });


    (function() {
        $('#formLogin').formValidation({
            framework: "bootstrap",
            button: {
                selector: '#formLoginSubmit',
                disabled: 'disabled'
            },
            icon: null,
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required.'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required.'
                        }
                    }
                },
            }
        }).on('success.form.fv', function(e) {
            // Reset the message element when the form is valid
            var form = '#formLogin';

            if(parseInt($(form).data('onprocess')))
            { return false; }
            else $(form).attr('data-onprocess', 1);

            var error = $(form).find('.has-error').length,
                form = '#formLogin';

            if(error)
                return;

            var data = $._getFormData(form),
                url = $(form).attr('action'),
                $afterTxt = $('.form-after-text'),
                alert = '.alert-dismissible',
                loader = '.wizardLoader';

            $afterTxt.find(alert+':visible').remove();
            $(loader).show();

            console.log(data);
            $.post(url, data, function (data) {}, "json")
                .always(function (data) {
                    $('#formLogin').attr('data-onprocess', 0);
                    $(loader).hide();
                }).
            done(function (data) {
                if(data.res == 'success') {
                    setTimeout( reload, 0);
                }
                else {
                    var messageDiv = $('.alert-dismissible:not(:visible)').clone(true);
                    //messageDiv.find('p.msg').text('Oops! Something went wrong.');
                    messageDiv.prependTo('.form-after-text').show();
                }

            }).fail(function (data) {
                var messageDiv = $('.alert-dismissible:not(:visible)').clone(true);
                messageDiv.find('p.msg').text('Oops! Something went wrong.');
                messageDiv.prependTo('.form-after-text').show();
            });

            return false;
        });

    })();



})(document, window, jQuery);