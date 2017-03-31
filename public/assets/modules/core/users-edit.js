(function (document, window, $) {
    'use strict';
    var UsersEditModule = {
        data: {},
        //----------------------------------------
        init: function () {
            var current_url = $("input[name=url_current]").val();
            this.data.url = {
                current: current_url,
                list: current_url+"/list?",
                enable: current_url+"/enable",
                disable: current_url+"/disable",
                delete: current_url+"/delete",
                restore: current_url+"/restore",
                permanentDelete: current_url+"/permanent/delete",

            };
        },
        //----------------------------------------
        //----------------------------------------
        handleAjax: function (url, callbackfn, data, method) {
            if (!method) {
                method = "GET";
            }
            var ajaxOpt = {
                method: method,
                url: url,
                async: true,
                context: this,
            };
            if (data) {
                ajaxOpt.data = data;
            }
            $.ajax(ajaxOpt).done(function (response) {
                console.log("ajax response", response);

                NProgress.done();
                if (response.status == "success" && callbackfn) {
                    callbackfn(response);
                } else {
                    $.each(response.errors, function (index, object) {
                        alertify.error(object);
                    });
                }
            });
        },
        //----------------------------------------

        //----------------------------------------
        handleUpdate: function () {
/*            $("body").on("submit", ".UserEditForm", function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                UsersEditModule.handleAjax(url, UsersEditModule.handleUpdateResponse, data);
            });*/
        },
        //----------------------------------------
        handleUpdateResponse: function (data) {
            console.log(data);
            if (data.status == "success") {
                alertify.success("Updated");
            }
        },

        //----------------------------------------

        //----------------------------------------
        run: function () {
            var self = this;
            this.init();
            this.handleUpdate();

        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        UsersEditModule.run();
    });
    //-------------------------------------------
    //########### Form Validation
    (function () {
        $('.UserEditForm')
            .find('[name="roles[]"]')
            .change(function(e) {
                $('.UserEditForm').formValidation('revalidateField', 'roles[]');
            })
            .end()
            .formValidation({
            framework: "bootstrap4",
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The name is required'
                        },
                        stringLength: {
                            min: 3,
                            max: 50
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The username is required'
                        },
                        emailAddress: {
                            message: 'The email address is not valid'
                        }
                    }
                },
                password: {
                    validators: {
                        stringLength: {
                            min: 8
                        }
                    }
                },
                enable: {
                    validators: {
                        notEmpty: {
                            message: 'Choose enable or disable'
                        }
                    }
                },
                'roles[]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select user roles'
                        }
                    }
                }
            }
        }).on('success.form.fv', function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            console.log(url);
            UsersEditModule.handleAjax(url, UsersEditModule.handleUpdateResponse, data, 'POST');
        });
    })();
    //-------------------------------------------
})(document, window, jQuery);
//-------------------------------------------


