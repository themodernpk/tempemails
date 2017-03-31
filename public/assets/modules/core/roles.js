(function (document, window, $) {
    'use strict';
    var RoleModule = {
        data: {},
        //----------------------------------------
        init: function () {
            var current_url = $("input[name=url_current]").val();
            this.data.url = {
                current: current_url,
                list: current_url + "/list?",
                toggle: current_url+"/toggle",
                delete: current_url+"/delete",
                restore: current_url+"/restore",
                deletePermanent: current_url+"/delete/permanent"
            };
        },
        //----------------------------------------
        fetchList: function (url) {

            console.log('url', url);

            NProgress.start();
            $.ajax({
                url: url,
            }).done(function (response) {
                console.log(response);
                NProgress.done();
                $("#list").html(response.html);
                RoleModule.handlePagination(response.list);
            });
        },
        //----------------------------------------
        buildListUrl: function () {
            var url = RoleModule.data.url.list;

            var page = $("input[name=page]").val();
            url += "page=" + page;
            var trashed = $("input[name=trashed]").val();

            if(trashed == 1)
            {
                url+="&trashed=1";
            }


            var s = $(".search").val();
            if (s && s != "") {
                url += "&s=" + s;
            }

            RoleModule.fetchList(url);
        },
        //----------------------------------------
        //----------------------------------------
        handlePagination: function (data) {
            RoleModule.handleSelectAllReset();
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
                        RoleModule.buildListUrl();
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
                var element = $(this);
                RoleModule.handleToggleEnable(id, "", element);
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
            RoleModule.handleAjax(url,RoleModule.buildListUrl, data, 'POST')
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
                        RoleModule.handleToggleEnable(id, 0, element);
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
                        RoleModule.handleToggleEnable(id, 1, element);
                    }
                });
            });
        },
        //----------------------------------------
        handleSearch: function () {
            $("body").on("keyup blur", ".search", function (e) {
                e.preventDefault();
                RoleModule.buildListUrl();
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
        handleStore: function (url, data) {
            RoleModule.handleAjax(url, RoleModule.buildListUrl, data, 'POST');
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
                console.log("ajax response", response);

                if (response.status == "success" && callbackfn) {

                    callbackfn(response);

                } else {
                    $.each(response.errors, function (index, object) {
                        alertify.error(object);
                    });
                }

                NProgress.done();
            });
        },
        //----------------------------------------
        handleDelete: function () {
            $("body").on("click", ".itemDelete", function (e) {
                e.preventDefault();
                var url = $(this).attr("href");
                RoleModule.handleAjax(url, RoleModule.buildListUrl);
            });
        },
        //----------------------------------------
        bulkDelete: function () {
            $("body").on("click", ".bulkDelete", function (e) {
                e.preventDefault();
                var list = $("#list").find(".selectable-item");
                $.each(list, function (index, item) {
                    var check = $(item).prop('checked');
                    if (check == true) {
                        var id = $(item).closest("tr").attr("data-id");
                        RoleModule.handleAjax(RoleModule.data.url.delete, RoleModule.buildListUrl, {id: id})
                    }
                });
            });
        },
        //----------------------------------------
        bulkDeletePermanent: function () {
            $("body").on("click", ".bulkDeletePermanent", function (e) {
                e.preventDefault();
                var list = $("#list").find(".selectable-item");
                $.each(list, function (index, item) {
                    var check = $(item).prop('checked');
                    if (check == true) {
                        var id = $(item).closest("tr").attr("data-id");
                        RoleModule.handleAjax(RoleModule.data.url.deletePermanent, RoleModule.buildListUrl, {id: id})
                    }
                });
            });
        },
        //----------------------------------------
        bulkRestore: function () {
            $("body").on("click", ".bulkRestore", function (e) {
                e.preventDefault();
                var list = $("#list").find(".selectable-item");
                $.each(list, function (index, item) {
                    var check = $(item).prop('checked');
                    if (check == true) {
                        var id = $(item).closest("tr").attr("data-id");
                        RoleModule.handleAjax(RoleModule.data.url.restore, RoleModule.buildListUrl, {id: id})
                    }
                });
            });
        },
        //----------------------------------------
        handleToggleTrashed: function () {
            $("body").on("click", "#showTrashed", function (e) {
                e.preventDefault();

                $(this).find('.showTrashedChecked').toggle();
                var hiddenField = $('input[name=trashed]');
                var val = hiddenField.val();
                if (val == 1) {
                    hiddenField.val(0);
                } else {
                    hiddenField.val(1);
                }
                RoleModule.buildListUrl();
            });
        },
        //----------------------------------------
        run: function () {
            var self = this;
            this.init();
            this.buildListUrl();
            this.handleToggle();
            this.handleSearch();
            this.handleSelectAll();
            this.handleSelectAllReset();
            this.handleDelete();
            this.handleToggleTrashed();
            this.bulkEnable();
            this.bulkDisable();
            this.bulkDelete();
            this.bulkDeletePermanent();
            this.bulkRestore();
        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        RoleModule.run();
    });
    //-------------------------------------------
    //########### Form Validation
    (function () {
        $('#ModalFormCreate form').formValidation({
            framework: "bootstrap4",
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The name is required'
                        },
                    }
                }
            }
        }).on('success.form.fv', function (e) {
            e.preventDefault();
            var $form = $(e.target);
            var id = $form.attr('id');
            var url = $form.attr('action');
            var data = $form.serialize();
            RoleModule.handleStore(url, data);
            $('#ModalFormCreate form').data('formValidation').resetForm(true);
            $('#ModalFormCreate').modal('hide');
        });
    })();
    //-------------------------------------------
})(document, window, jQuery);
//-------------------------------------------


