(function (document, window, $) {
    'use strict';
    var UsersViewModule = {
        data: {},
        //----------------------------------------
        init: function () {
            var current_url = $("input[name=url_current]").val();
            this.data.url = {
                current: current_url,

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
        handleUpdateResponse: function (data) {

        },

        //----------------------------------------

        //----------------------------------------
        run: function () {
            var self = this;
            this.init();


        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        UsersViewModule.run();
    });
    //-------------------------------------------

    //-------------------------------------------
})(document, window, jQuery);
//-------------------------------------------


