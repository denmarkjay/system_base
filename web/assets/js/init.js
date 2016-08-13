/**
 * Created by Admin on 7/30/2016.
 */
(function(document, window, $) {
    'use strict';

    $.myapp = $.myapp ||
        {
            url:    null,
            limit:  10,
            page:   1,
            data:   {ajax:true },
            done:   function(data){},
            always: function(data) {},
            fail:   function(data){
                $._createToastAlert({
                    message: 'Oops! Something went wrong.<br>Please try again.',
                    icon: 'danger'
                }).click();
            }
        };

    window.MyApp = $.extend($.myapp, {
        checkSessionHB: function (call) {
            var path = window.location.pathname;
            //check if admin page
            if (!path.match(/admin/gi)) return;

            $.post('/checkSession', {}, function () {
            }).
            always(function (data) {
                console.log('get');
            }).done(function (data) {
                if (data.session) {
                    setTimeout(function () {
                        window.MyApp[call](call);
                    }, 3000);
                } else {
                    swal({
                            title: "NOTICE:",
                            text: "You're not logged in.",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Login',
                            closeOnConfirm: false,
                            //closeOnCancel: false
                        },
                        function () {
                            reload();
                        });
                }
            }).fail(function (data) {
                swal({
                        title: "Oops!",
                        text: "Something went wrong",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Reload',
                        closeOnConfirm: false,
                        //closeOnCancel: false
                    },
                    function () {
                        reload();
                    });
            });

        },
        start: function (actions) {
            for (var act in actions) {
                var call = actions[act];
                this[call] !== undefined ? this[call](call) : console.log(call + ' function does not found!');
            }
        },

        post: function () {

            $.post(MyApp.url, MyApp.data, function() {}, 'json')
                .done( function(data) {
                    $._showForbiddenAlert(data);
                    MyApp.done(data) || null;
                })
                .fail( function(data) {
                    MyApp.fail(data) || null;
                })
                .always( function(data) {
                    MyApp.always(data) || null;
                });
        },
        setUrl: function (url) {
            this.url = url;

            return this;
        },
        setPage: function (page) {
            this.page = page;

            return this;
        },
        setLimit: function (limit) {
            this.limit = limit;

            return this;
        },
        setData: function (data, type) {
            if (type == 'get') {
                for (var i in data) {
                    this.data.push(i + '=' + data[i]);
                }
                this.data = this.data.join('&') + '&ajax=1';
            } else {
                this.data = data;
                this.data.ajax = 1;
            }

            return this;
        },
        setDone: function(call) {
            this.done = call;

            return this;
        },
        setAlways: function(call) {
            this.always = call;

            return this;
        },
        setFail: function(call) {
            this.fail = call;

            return this;
        },
        resetMyApp: function () {
            this.url    = null;
            this.page   = 1;
            this.limit  = 10;
            this.data   = {ajax:true };

            return this;
        }
    });

    $.extend(true, $, {
        _getFormData: function(form, attr) {
            var key = '[name]';

            var data = {};
            $(form).find(key).each( function(k, val) {
                var field = $(this).attr((attr=='id'?'id':'name')) || 'empty-'+k;
                data[field] = this.value || '';

            });

            return data;
        },


        _formProcess: function(form, val) {
            form.attr('onprocess', val);
        },

        _resetForm: function(form) {
            var key = '[name]';

            $(form).find(key).each( function(k, val) {
                this.value = '';
                var _el = $(this);
                var _tag = _el.prop("tagName").toLowerCase();

                if(_tag == 'textarea') _el.html('');
                else if(_tag == 'select') _el.find('option:first-child').attr('selected', 'true');
                else _el.value = '';
            });
        },

        _createToastAlert: function(param) {
            param = param || {};
            var alert = $('<div />');
            alert
                .attr({
                    'aria-live': 'polite', 'role': 'alert',
                    'data-plugin':'toastr',
                    'data-message': param.message || 'This is an alert',
                    'data-container-id': param.container || 'toast-top-right',
                    'data-position-class': param.position || 'toast-top-right',
                    'data-icon-class': 'toast-' + (param.icon || 'success'),
                    'data-close-button': param.close || 'true',
                    'data-time-out': param.timeout || '3000',
                })
            ;

            alert.appendTo('body');

            return alert;
        },
        _showForbiddenAlert: function(data) {
            if(! data.auth) {
                $._createToastAlert({
                    message:'Sorry! Access forbidden.', 'icon':'warning'
                }).click();
            }
        },
        _showSuccessAlert: function(type, message) {
            if(type == 'update') message = 'Successfully updated record!';
            if(type == 'delete')  message = 'Successfully updated record!';

            $._createToastAlert({
                message:'Successfully saved  record! ', 'icon':'success'
            }).click();
        }

    });

})(document, window, jQuery);

(function(document, window, $) {
    'user strict';

    //always check session if logged in
    var MyApp = window.MyApp;
    MyApp.start(['checkSessionHB']);

})(document, window, jQuery);

function reload()  {
    window.location = location.href;
}

function _name( name) {
    var val = $('[name="'+name+'"]').val();

    return val;
}