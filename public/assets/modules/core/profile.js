Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');





//#########################Vue#################################################
const app = new Vue({
    el: '#app',
    data: {
        title: "",
        new_item: {},
        item: [],
        urls: [],
        password: null,
        list_activities: [],
        current_page: null,
    },
    mounted: function () {
        //---------------------------------------------------------------
        var geturl = [];
        $("input[data-type=url]").each(function () {
            var name = $(this).attr('name');
            var value = $(this).val();
            console.log(name+" - "+value);
            geturl[name] = value;
        });
        this.urls = geturl;
        //---------------------------------------------------------------
        this.getItem();
        //---------------------------------------------------------------

        //---------------------------------------------------------------
        //---------------------------------------------------------------
    },
    methods:{
        //---------------------------------------------------------------------
        errors: function (errors) {
            $.each(errors, function (index, object) {
                alertify.error(object);
            });
        },
        //---------------------------------------------------------------------
        getItem: function () {

            NProgress.start();
            this.$http.get(this.urls.profile, {})
                .then(response => {
                    console.log(response);
                    if(response.data.status == 'success')
                    {
                        this.loadItem(response.data.data)
                        this.getProfileActivities();
                    } else
                    {
                        this.errors(response.data.errors);
                    }

                    NProgress.done();
                });

        },
        //---------------------------------------------------------------------
        loadItem: function (data) {
            this.item = data;
        },
        //---------------------------------------------------------------------
        updateProfile: function (event) {
            event.preventDefault();

            var data = {};
            data.id = this.item.id;
            data.name = this.item.name;
            data.email = this.item.email;
            data.mobile = this.item.mobile;
            data.gender = this.item.gender;
            data.birth_date = this.item.birth_date;
            data.country_calling_code = this.item.country_calling_code;

            if(this.password)
            {
                data.password = this.password;
            }

            NProgress.start();
            this.$http.post(this.urls.profile_update, data)
                .then(response => {
                    if(response.data.status == 'success')
                    {
                        this.loadItem(response.data.data)
                    } else
                    {
                        this.errors(response.data.errors);
                    }
                    NProgress.done();
                });

        },
        //---------------------------------------------------------------------
        getProfileActivities: function ()
        {

            var data = {id: this.item.id};
            var url = this.urls.profile_activities;

            if(this.current_page != null && this.current_page < this.total_page)
            {
                data.page = this.current_page+1;
            }
            NProgress.start();
            this.$http.post(url, data)
                .then(response => {
                    if(response.data.status == 'success')
                    {
                        console.log("activities=", response.data.data);
                        this.current_page = response.data.data.current_page;
                        this.total_page = response.data.data.total;
                        this.loadActivities(response.data.data.data)
                    } else
                    {
                        this.errors(response.data.errors);
                    }
                    NProgress.done();
                });
        },
        //---------------------------------------------------------------------
        loadActivities: function (data) {

            var list = [];
            var self = this;
            data.forEach(function (item)
            {
                console.log(item);
                self.list_activities.push(item);
            });

            console.log(this.list_activities);


        },
        //---------------------------------------------------------------------
        changeGender: function (gender) {
            this.item.gender = gender;
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
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
});


//#########################jQuery##############################################

(function (document, window, $) {



})(document, window, jQuery);