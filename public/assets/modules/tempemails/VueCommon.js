Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');


var VueCommon = Vue.extend({
    methods: {

        //---------------------------------------------------------------------
        processHttpRequest: function (url, params, callback) {
            NProgress.start();
            this.$http.post(url, params)
                .then(response => {
                    if(response.data.status == 'success')
                    {
                        callback(response.data.data)
                    } else
                    {
                        this.errors(response.data.errors);
                        NProgress.done();
                    }
                });
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        errors: function (errors) {
            $.each(errors, function (index, object) {
                alertify.error(object);
            });
        },
        //---------------------------------------------------------------------
        success: function (message) {

            if(message === undefined)
            {
                message = "success"
            }

            alertify.success(message);
        },
        //---------------------------------------------------------------------
        updateArray: function(array, updatedElement) {
            const index = array.indexOf(updatedElement);
            array[index] = updatedElement;
            return array;
        },
        //---------------------------------------------------------------------
        removeFromArray: function remove(array, element) {
            const index = array.indexOf(element);
            array.splice(index, 1);
        },
        //---------------------------------------------------------------------
        splitString: function (string, characters) {
            console.log(string);
            if(string != "" && string != null)
            {
                if(string.length > characters){
                    string = string.substring(0,characters)+"...";
                }
            }

            return string;
        },
        //---------------------------------------------------------------------
        formatDate: function (value) {
            return moment(value).format('YYYY-MM-DD');
        },
        //---------------------------------------------------------------------
        fromNow: function (value) {
            return moment(value).fromNow();
        },
        //---------------------------------------------------------------------
        checkPermission: function (slug) {
            return this.permissions.indexOf(slug) > -1 ? true : false;
        },
        //---------------------------------------------------------------------
        paginate: function (event, page) {
            event.preventDefault();
            this.current_page = page;
            this.listLoader();
        },
        //---------------------------------------------------------------------
        makePagination: function (data) {
            this.pagination = Pagination.Init(data.last_page, this.current_page, this.per_page);
        },
        //---------------------------------------------------------------------
        paginateIsActive: function (page) {
            if(page == this.current_page)
            {
                return true;
            }
            return false;
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }

});