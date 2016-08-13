(function (document, window, $) {
    'use strict';
// Example Wizard Form
    // -------------------
    (function () {
        // set up formvalidation
        $('#accountCompanyForm').formValidation({
            framework: 'bootstrap',
            fields: {
                c_name: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter your company'
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: 'Character length: greater than 2 and less than 30.'
                        },
                    }
                }
            }
        });

        $("#accountInfoForm").formValidation({
            framework: 'bootstrap'
        });

        $("#accountSecurityForm").formValidation({
            framework: 'bootstrap',
            fields: {
                ul_login: {
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
                ul_pass: {
                    trigger: 'blur',
                    validators: {
                        stringLength: {
                            min: 8,
                            message: 'Please enter at least 8 characters.'
                        }
                    }
                },
                ul_pass2: {
                    validators: {
                        identical: {
                            field: 'ul_pass',
                            message: 'The password does not match!'
                        },
                        notEmpty: {
                            message: '&nbsp;'
                        }
                    }
                }
            }
        });

        // init the wizard
        var defaults = $.components.getDefaults("wizard");
        var options = $.extend(true, {}, defaults,
            {
                buttonsAppendTo: '.panel-body',
                onFinish: function () {
                    $.fn.load();

                    var data = $.fn.getData();
                    console.log(data);
                    $.post(url, {data: data}, function (response) {
                            console.log(response);
                        }, "json")
                        .always(function (data) {
                            $.fn.done(data);
                        }).
                    done(function (data) {
                        $.fn.done(data);
                    }).fail(function (data) {
                        $.fn.error(data);
                    });
                    return false;
                }
            });
        var wizard = $("#exampleWizardForm").wizard(options).data(
            'wizard');

        // setup validator
        // http://formvalidation.io/api/#is-valid
        wizard.get("#accountCompany").setValidator(function () {
            var fv = $("#accountCompanyForm").data('formValidation');
            fv.validate();

            if (!fv.isValid()) {
                return false;
            }

            return true;
        });

        wizard.get("#accountInfo").setValidator(function () {
            var fv = $("#accountInfoForm").data('formValidation');
            fv.validate();

            if (!fv.isValid()) {
                return false;
            }

            return true;
        });

        wizard.get("#accountSecurity").setValidator(function () {
            var fv = $("#accountSecurityForm").data('formValidation');
            fv.validate();

            if (!fv.isValid()) {
                return false;
            }

            return true;
        });

        $('form').submit(function () {
            return false;
        })

        //button proceed
        $('#btnSuccessProceed:enabled').click(function (e) {
            var btn = this;
            e.preventDefault();
            var l = Ladda.create(btn);
            reload();
        })

        var url = $('#exampleWizardForm').data('url');

        var msg = $('.wizardMessage'),
            msg1 = msg.find('h4'),
            msg2 = msg.find('h2'),
            proceedBtn = $('#btnSuccessProceed'),
            wzdButtons = $('.wizard-buttons'),
            wzdLoader = $('#wizardLoader')
            ;

        $.extend(true, $.fn, {
            getData: function () {
                var data = {};
                data.user = {
                    user_fname: _name('u_fname'),
                    user_lname: _name('u_lname'),
                    user_email: _name('u_email'),
                    user_phone: _name('u_phone'),
                    user_login: _name('ul_login'),
                    user_password: _name('ul_pass'),

                };

                data.company = {
                    company_name: _name('c_name'),
                    company_email: _name('c_email'),
                    company_address: _name('c_address'),
                };

                return data;
            },
            /**
             * Loader
             */
            load: function () {
                $('[data-wizard=finish]').addClass('disabled');

                msg1.html('We are setting up your account. Please wait...');
                msg.find('.wb-check').
                removeClass('wb-warning');

                var showList = [wzdLoader],
                    hideList = [msg2, wzdButtons, msg.find('.wb-check')];
                for (var i in showList) {
                    showList[i].show();
                }
                for (var i in hideList) {
                    hideList[i].hide();
                }
            },
            /**
             * Success
             */
            done: function (data) {

                if (data.result == 'success') {
                    msg2.html('Congratulations!');
                    msg1.html('Successfully setup account.');

                    var showList = [msg.find('.wb-check'), msg2, proceedBtn],
                        hideList = [wzdLoader];
                    for (var i in showList) {
                        showList[i].show();
                    }
                    for (var i in hideList) {
                        hideList[i].hide();
                    }

                } else {
                    $.fn.error({status: ''});
                }
            },

            error: function (data) {
                msg2.html(data.status + ' Error!');
                msg1.html('Oop! Something went wrong.');

                msg.find('.wb-check').
                addClass('wb-warning');
                wzdButtons.find('[data-wizard="finish"]').removeClass('disabled').html('Retry');

                var showList = [msg.find('.wb-check'), msg2, wzdButtons],
                    hideList = [wzdLoader];
                for (var i in showList) {
                    showList[i].show();
                }
                for (var i in hideList) {
                    hideList[i].hide();
                }
            }
        });

    })();
})(document, window, jQuery);