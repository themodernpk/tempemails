(function (document, window, $) {
    'use strict';
    var PermissionModule = {
        data: {},
        //----------------------------------------
        init: function () {
            var current_url = $("input[name=url_current]").val();
            this.data.url = {
                current: current_url,
                list: current_url + "/list?"
            };
        },
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
            NProgress.start();
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
        fetchList: function (url) {
            NProgress.start();
            $.ajax({
                url: url,
            }).done(function (response) {
                console.log(response);
                NProgress.done();
                $("#list").html(response.html);
                PermissionModule.handlePagination(response.list);
            });
        },
        //----------------------------------------
        buildListUrl: function () {
            var url = PermissionModule.data.url.list;

            var page = $("input[name=page]").val();

            url += "page=" + page;
            var s = $(".search").val();
            if (s && s != "") {
                url += "&s=" + s;
            }

            PermissionModule.fetchList(url);
        },
        //----------------------------------------
        handlePagination: function (data) {
            PermissionModule.handleSelectAllReset();
            var total = parseFloat(data.total);
            $(".pagination_con").paging(total, {
                format: '[< nncnn >]',
                perpage: data.per_page,
                lapping: 0,
                page: data.current_page,
                onSelect: function (page) {
                    if (page != data.current_page)
                    {
                        $('input[name=page]').val(page);
                        PermissionModule.buildListUrl();
                    }
                },
                onFormat: function (type) {
                    switch (type) {
                        case 'block': // n and c
                            if (this.value == data.current_page) {
                                var html = '<li class="active page-item"><a class="page-link" href="#">' + this.value + '</a></li>';
                            } else {
                                var html = '<li class="page-item"><a class="page-link" href="#">' + this.value + '</a></li>';
                            }
                            return html;
                        case 'next':
                            return '<li class="page-item"><a class="page-link" href="#"><span class="icon fa-angle-right"></span></a></li>';
                        case 'prev':
                            return '<li class="page-item"><a class="page-link" href="#"><span class="icon fa-angle-left"></span></a></li>';
                        case 'first':
                            return '<li class="page-item"><a class="page-link" href="#"><span class="icon fa-angle-double-left"></span></a></li>';
                        case 'last':
                            return '<li class="page-item"><a class="page-link "  href="#"><span class="icon fa-angle-double-right"></span></a></li>';
                    }
                }
            });
        },
        //----------------------------------------
        handleToggle: function () {
            $("body").on("click", ".enableToggle", function (e) {
                e.preventDefault();
                var id = $(this).closest("tr").attr("data-id");
                var status = $(this).closest("tr").attr("data-enable");
                var element = $(this);
                PermissionModule.handleToggleEnable(id, "", element);
            });
        },
        //----------------------------------------
        handleToggleEnable: function (id, status, element) {
            var data = {};
            data.id = id;
            if (status !== undefined) {
                data.enable = status;
            }
            var url = element.attr('href');

            PermissionModule.handleAjax(url,PermissionModule.buildListUrl, data, 'POST')
        },
        //----------------------------------------
        bulkDisable: function () {
            $("body").on("click", ".bulkDisable", function (e) {
                e.preventDefault();
                var list = $("#list").find(".selectable-item");
                $.each(list, function (index, item) {
                    var check = $(item).prop('checked');
                    if (check == true) {
                        var id = $(item).closest("tr").attr("data-id");
                        var element = $(item).closest("tr").find('.enableToggle');
                        PermissionModule.handleToggleEnable(id, 0, element);
                    }
                });
            });
        },
        //----------------------------------------
        bulkEnable: function () {
            $("body").on("click", ".bulkEnable", function (e) {
                e.preventDefault();
                var list = $("#list").find(".selectable-item");

                $.each(list, function (index, item) {
                    var check = $(item).prop('checked');
                    if (check == true) {
                        var id = $(item).closest("tr").attr("data-id");
                        var element = $(item).closest("tr").find('.enableToggle');
                        PermissionModule.handleToggleEnable(id, 1, element);
                    }
                });
            });
        },
        //----------------------------------------
        handleSearch: function () {
            $("body").on("keyup blur", ".search", function (e) {
                e.preventDefault();
                PermissionModule.buildListUrl();
            });
        },
        //----------------------------------------
        handleDelete: function () {
            $("body").on("click", ".deleteItem", function (e) {
                e.preventDefault();
                PermissionModule.buildListUrl();
            });
        },
        //----------------------------------------
        handleSelectAll: function () {
            $("body").on("click", ".selectable-all", function (e) {
                var state = $(this).is(":checked");
                var list = $(this).closest("table").find(".selectable-item");
                $.each(list, function (index, item) {
                    $(item).prop("checked", state);
                });
            });
        },
        //----------------------------------------
        handleSelectAllReset: function () {
            $(".selectable-all").prop("checked", false);
        },
        //----------------------------------------
        handleShowItem: function () {
            $("body").on("click", ".showItem", function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                PermissionModule.handleAjax(url, PermissionModule.showDataInModal)
            });
        },
        //----------------------------------------
        showDataInModal: function (response) {

            console.log("data received-------------->", response);
            $("#SidebarModal").find('.modal-body').html(response.html);
        },
        //----------------------------------------
        run: function () {
            var self = this;
            this.init();
            this.buildListUrl();
            this.handleToggle();
            this.handleSearch();
            this.handleDelete();
            this.handleSelectAll();
            this.bulkDisable();
            this.bulkEnable();
            this.handleSelectAllReset();
            this.handleShowItem();
        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        PermissionModule.run();
    });
    //-------------------------------------------
    //-------------------------------------------
})(document, window, jQuery);