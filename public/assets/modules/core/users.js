(function (document, window, $) {
    'use strict';
    var UsersModule = {
        data: {},
        //----------------------------------------
        init: function () {
            var current_url = $("input[name=url_current]").val();
            this.data.url = {
                current: current_url,
                list: current_url+"/list?",
                enable: current_url+"/enable/",
                disable: current_url+"/disable/",
                delete: current_url+"/delete/",
                restore: current_url+"/restore/",
                permanentDelete: current_url+"/permanent/delete",

            };
        },
        //----------------------------------------
        handlePagination: function (data) {

            var total = parseFloat(data.total);
            $("#paginate").paging(total, {
                format: '[< nncnn >]',
                perpage: data.per_page,
                lapping: 0,
                page: data.current_page,
                onSelect: function (page) {
                    if (page != data.current_page) {
                        UsersModule.buildListUrl(page);
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
        handleStore: function (data, url) {
            UsersModule.handleAjax(url, UsersModule.buildListUrl, data, 'POST');
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
        buildListUrl: function () {
            var url = UsersModule.data.url.list;

            var page = $("#paginate").find(".active").find("a").attr('data-page');

            if (page === undefined) {
                url += "page=1";
            } else {
                url += "page=" + page;
            }
            var s = $(".search").val();
            if (s && s != "") {
                url += "&s=" + s;
            }
            var trashed = $("input[name=trashed]").val();
            if (trashed == 1) {
                url += "&trashed=" + trashed;
            }

            var shortBy = $(".shortBySelected").text();

            if(shortBy != "All" || shortBy != "")
            {
                url += "&shorted-by="+shortBy;
            }

            UsersModule.fetchList(url);
        },
        //----------------------------------------
        fetchList: function (url) {
            console.log(url);
            NProgress.start();
            var s = $(".search").val();
            $.ajax({
                url: url,
            }).done(function (response) {
                NProgress.done();
                console.log(response);
                //console.log(response.html);
                $("#list").html(response.html);
                $("#trashCount").html(response.trashCount);
                UsersModule.handlePagination(response.list);
                if (s != "") {
                    $("#list").highlight(s);
                }
            });
        },

        //----------------------------------------
        deleteUser: function () {

            $("body").on("click", ".itemDelete", function (e) {
                e.preventDefault();
                var url = $(this).attr("href");
                UsersModule.handleAjax(url,UsersModule.buildListUrl);
            });

        },
        //----------------------------------------
        enableToggle: function () {

            $("body").on("click", ".enableToggle", function (e) {
                e.preventDefault();
                var url = $(this).attr("href");
                UsersModule.handleAjax(url,UsersModule.buildListUrl);
            });

        },
        //----------------------------------------

        //----------------------------------------
        shortBy: function () {

            $("body").on("click", ".shortBy a", function (e) {
                e.preventDefault();
                console.log("clicked");
                var selectedText = $(this).text();

                console.log(selectedText);

                $(".shortBySelected").text(selectedText);
                UsersModule.buildListUrl();
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
        bulkActions:function ()
        {
            $("body").on("click", ".bulkAction", function (e) {

                var action = $(this).attr('data-action');
                var url;

                if(action == "enable")
                {
                    url = UsersModule.data.url.enable;
                } else if(action == 'disable')
                {
                    url = UsersModule.data.url.disable;
                } else if(action == 'delete')
                {
                    url = UsersModule.data.url.delete;
                } else if(action == 'restore')
                {
                    url = UsersModule.data.url.restore;
                } else if(action == 'permanent-delete')
                {
                    url = UsersModule.data.url.permanentDelete;
                }

                var list = $("#list").find(".selectable-item");
                $.each(list, function (index, item) {
                    var check = $(item).prop('checked');
                    if (check == true) {
                        var id = $(item).val();
                        var ajaxUrl = url+id;
                        console.log(ajaxUrl);
                        UsersModule.handleAjax(ajaxUrl);
                    }
                });

                UsersModule.buildListUrl();
            });
        },
        //----------------------------------------
        handleSearch: function () {
            $("body").on("keyup blur", ".search", function (e) {
                e.preventDefault();
                UsersModule.buildListUrl();
            });
        },
        //----------------------------------------

        //----------------------------------------

        //----------------------------------------
        run: function () {
            var self = this;
            this.init();
            this.buildListUrl();
            this.deleteUser();
            this.enableToggle();
            this.shortBy();
            this.handleSelectAll();
            this.handleSelectAllReset();
            this.bulkActions();
            this.handleSearch();

        }
        //----------------------------------------
    };
    //-------------------------------------------
    $(document).ready(function () {
        UsersModule.run();
    });
    //-------------------------------------------
    //########### Form Validation
    (function () {
        $('#ModalFormCreate form')
            .find('[name="roles[]"]')
            .change(function(e) {
                /* Revalidate the language when it is changed */
                $('#ModalFormCreate form').formValidation('revalidateField', 'roles[]');
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
                        notEmpty: {
                            message: 'The password is required'
                        },
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
            var $form = $(e.target);
            var id = $form.attr('id');
            var url = $form.attr('action');
            var data = $form.serialize();
            UsersModule.handleStore(data, url);
            $('#ModalFormCreate form').data('formValidation').resetForm(true);
            $('#ModalFormCreate').modal('hide');
        });
    })();
    //-------------------------------------------
})(document, window, jQuery);
//-------------------------------------------


