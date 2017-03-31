(function (document, window, $) {
    'use strict';
    var RoleModuleItem = {
        data: {},
        //----------------------------------------
        init: function () {
            var current_url = $("input[name=url_current]").val();
            this.data.url = {
                current: current_url,
                list: current_url + "/list?",
                read: current_url + "/read",
                toggle: current_url + "/toggle",
                item: current_url + "/details"
            };
        },
        //----------------------------------------
        handleAjax: function (url, callbackfn, data, method) {
            if (!method) {
                method = "GET";
            }

            console.log(data);

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
                NProgress.done();
                console.log("ajax response", response);
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
        handleItemGet: function () {
            RoleModuleItem.handleAjax(RoleModuleItem.data.url.item, RoleModuleItem.handleItemShow);
        },
        //----------------------------------------
        handleItemShow: function (response) {
            if (response.status == "success" && response.data) {
                $(".item").html(response.data);
            }
        },
        //----------------------------------------
        handleItemUpdate: function () {
            $("body").on("submit", ".form-item-update", function (e) {
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                RoleModuleItem.handleAjax(url, RoleModuleItem.handleItemGet, data, "POST");
            });
        },
        //----------------------------------------
        handleItemStats: function () {
            var url = $(".pk-item-stats").attr("href");
            RoleModuleItem.handleAjax(url, RoleModuleItem.handleItemStatsShow);
        },
        //----------------------------------------
        handleItemPermissions: function () {
            var url = $("input[name=url_item_permissions]").val();
            var search = $("#permission-search").val();
            if (search != "") {
                url = url + "?s=" + search;
            }
            RoleModuleItem.handleItemPermissionLoad(url);
        },
        //----------------------------------------
        handleItemPermissionLoad: function (url) {
            RoleModuleItem.handleAjax(url, RoleModuleItem.handleItemPermissionsShow);
        },
        //----------------------------------------
        handleItemPermissionsShow: function (response) {
            $("#permissions-list").html(response.data);
        },
        //----------------------------------------
        handleItemPermissionsSearch: function () {
            $("body").on("keyup blur", "#permission-search", function (e) {
                e.preventDefault();
                RoleModuleItem.handleItemPermissions();


            });
        },
        //----------------------------------------
        handleItemPermissionsToggle: function () {
            $("body").on("click", ".permissionToggle", function (e) {
                e.preventDefault();
                var url = $(this).attr("data-url");
                RoleModuleItem.handleAjax(url, RoleModuleItem.handleItemPermissions);
            });
        },
        //----------------------------------------
        handleItemStatsShow: function (response) {
            if (response.status == "success" && response.data) {
                $("#stats").html(response.data);
            }
        },
        //----------------------------------------
        handleReload: function () {
            $("body").on("click", ".pk-action-reload", function (e) {
                e.preventDefault();
                var target = $(this).attr("data-target");
                if (target == "#stats") {
                    RoleModuleItem.handleItemStats();
                }
            });
        },
        //----------------------------------------
        run: function () {
            var self = this;
            this.init();
            this.handleItemGet();
            this.handleItemUpdate();
            this.handleItemStats();
            this.handleReload();
            this.handleItemPermissions();
            this.handleItemPermissionsSearch();
            this.handleItemPermissionsToggle();
        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        RoleModuleItem.run();
    });
    //-------------------------------------------
    //-------------------------------------------
})(document, window, jQuery);