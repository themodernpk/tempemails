(function (document, window, $) {
    'use strict';
    var CrudModule = {
        data: {},

        //----------------------------------------
        init: function ()
        {

        },

        //----------------------------------------
        run: function () {
            var self = this;
            this.init();

        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        CrudModule.run();
    });
    //-------------------------------------------
    //-------------------------------------------
})(document, window, jQuery);