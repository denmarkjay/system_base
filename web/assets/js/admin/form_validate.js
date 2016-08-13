/**
 * Created by Admin on 8/14/2016.
 */
(function(document, window, $) {
    'user strict';

    ( function($) {

        $.fn.form_validate = function(j) {
            var m = $.extend( {
                module: null,
                onSuccess: function() {},
                form: '',
                btn: ''
            }, j);

            if(m.module) {
                if(m.module == 'new-user')
                    $(this).formValidation({
                        framework: "bootstrap",
                        button: {
                            selector: m.btn,
                            disabled: 'disabled'
                        },
                        icon: null,
                        fields: {
                            username: {
                                trigger: 'blur',
                                validators: {
                                    stringLength: {
                                        min: 6,
                                        max: 15,
                                        message: 'Character length: greater than 6 and less than 15.'
                                    },
                                    regexp: {
                                        regexp: /^[a-zA-Z0-9_]+$/,
                                        message: 'The username can only consist of alphabetical, number, and underscore'
                                    }
                                }
                            },
                            password: {
                                trigger: 'blur',
                                validators: {
                                    stringLength: {
                                        min: 8,
                                        message: 'Please enter at least 8 characters.'
                                    }
                                }
                            },
                            confirmPass: {
                                validators: {
                                    identical: {
                                        field: 'password',
                                        message: 'The password does not match!'
                                    },
                                    notEmpty: {
                                        message: '&nbsp;'
                                    }
                                }
                            }
                        }

                    }).on('success.form.fv', function (e, data) {
                        e.preventDefault();
                        var $form = $(e.target);
                        var fv = $form.data('formValidation');
                        fv.
                           resetForm(true);
                        m.onSuccess();
                    });
            }
        }
    })(jQuery);

})(document, window, jQuery);
