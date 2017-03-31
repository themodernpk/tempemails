

//#########################Vue#################################################
const app = new VueCommon({
    el: '#app',
    data: {

        //---------------------Pagination
        pagination:{},
        current_page: null,
        total_page: null,
        per_page: null,
        //---------------------End of Pagination
        accounts: [],
        account_active: null,
        emails: null,
        email_active: null,
        email_fetched: null,
        new_email: null,
        pusher: null,

    },
    mounted: function () {
        //---------------------------------------------------------------
        var geturl = [];
        $("input[data-type=url]").each(function () {
            var name = $(this).attr('name');
            var value = $(this).val();

            if(name == 'base')
            {
                geturl['inbox'] = value+"/"+$('input[name=inbox]').val();
            }

            geturl[name] = value;
        });
        this.urls = geturl;


        //---------------------------------------------------------------
        this.listAccounts();
        //---------------------------------------------------------------
/*        setInterval(function () {
            this.silentFetch();
        }.bind(this), 5000);*/
        //---------------------------------------------------------------
        this.pusher = new Pusher('3ee8efc1b5ea9de4411b', {
            authEndpoint: this.urls.base+'/cron/auth/pusher',
            cluster: 'ap2',
            auth: {
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                }
            }
        });



        //---------------------------------------------------------------
    },
    methods:{
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        silentFetch: function () {
            var url = this.urls.inbox+"/account/list";
            var params = {};
            this.$http.post(url, params)
                .then(response => {
                    this.accounts = response.data.data;
                });

            if(this.account_active)
            {
                var url = this.urls.inbox+"/email/list";
                var params = {te_account_id: this.account_active.id};
                this.$http.post(url, params)
                    .then(response => {
                        this.emails = response.data.data.data;
                    });
            }

        },
        //---------------------------------------------------------------------
        listAccounts: function () {
            var url = this.urls.inbox+"/account/list";
            var params = {};
            this.processHttpRequest(url, params, this.listAccountsAfter);
        },
        //---------------------------------------------------------------------
        listAccountsAfter: function (data) {
            NProgress.done();
            this.accounts = data;


            var self = this;
            this.accounts.forEach(function (account)
            {
                var channel = self.pusher.subscribe('private-account.'+account.id);
                channel.bind("email.created", function(data) {
                    self.silentFetch();
                    console.log("event", data);
                });
            });


        },
        //---------------------------------------------------------------------
        generateAccount: function () {
            var url = this.urls.inbox+"/generate/account";
            var params = {};
            this.processHttpRequest(url, params, this.generateAccountAfter);
        },
        //---------------------------------------------------------------------
        generateAccountAfter: function (data) {
            NProgress.done();
            this.listAccounts();
        },
        //---------------------------------------------------------------------
        setActiveAccount: function (event, account) {
            if(event)
            {
                event.preventDefault();
            }
            this.account_active = account;

            console.log(account);

            this.fetchEmails();

        },
        //---------------------------------------------------------------------
        fetchEmails: function () {
            this.email_fetched = null;
            var url = this.urls.inbox+"/email/list";
            var params = {te_account_id: this.account_active.id};
            this.processHttpRequest(url, params, this.fetchEmailsAfter);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        fetchEmailsAfter: function (data) {
            NProgress.done();
            this.emails = [];
            this.emails = data.data;
        },

        //---------------------------------------------------------------------
        fetchEmail: function (event, email) {
            event.preventDefault();
            email.read = 1;
            this.email_active = email;
            this.emails = this.updateArray(this.emails, this.email_active);
            var url = this.urls.inbox+"/email/details";
            var params = {id: email.id};
            this.processHttpRequest(url, params, this.fetchEmailAfter);
        },
        //---------------------------------------------------------------------
        fetchEmailAfter: function (data) {
            this.email_fetched = data;
            this.activateTabs();
            this.listAccounts();
        },
        //---------------------------------------------------------------------
        activateTabs: function () {
            console.log('tabs=', $('body').delay( 1000 ).find('.tabs').length);
        },
        //---------------------------------------------------------------------
        deleteAccount: function (event, account) {
            var url = this.urls.inbox+"/delete/account";
            var params = {id: account.id};
            //this.removeFromArray(this.accounts, account);

            if(this.account_active && this.account_active.id == account.id)
            {
                this.account_active = null;
            }

            this.processHttpRequest(url, params, this.listAccounts);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        tabs: function (event) {

            event.preventDefault();
            var element = event.target;

            $('body').find('.tabs a').each(function () {
                $(this).removeClass('active');
            });

            $('body').find('.tab-content').each(function () {
                $(this).attr('class', 'tab-content hide');
            });

            $(element).addClass('active');

            var content = $(element).attr('href');

            $(content).removeClass('hide');

        },
        //---------------------------------------------------------------------
        markAllAsRead: function (event, account) {
            var url = this.urls.inbox+"/mark/all/read";
            var params = {id: account.id};
            this.processHttpRequest(url, params, this.fetchEmails);
            this.listAccounts();
        },
        //---------------------------------------------------------------------
        deleteAllEmails: function (event, account) {
            var url = this.urls.inbox+"/delete/all/emails";
            var params = {id: account.id};
            this.processHttpRequest(url, params, this.fetchEmails);
        }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    },
    //-------------------------------------------------------------------

    //-------------------------------------------------------------------
    //-------------------------------------------------------------------
    //-------------------------------------------------------------------
});


//#########################jQuery##############################################

(function (document, window, $) {


    //----------------------------------------------------------
    $('body').on('click', '#showHtmlSource', function () {
        hljs.initHighlighting.called = false;
        hljs.initHighlighting();
    });
    //----------------------------------------------------------
    //alertify.set('notifier','delay', 0);
    //----------------------------------------------------------
    $('body').on('click', '.clickToCopy', function (e) {
        e.preventDefault();
        alertify.success("Email Copied");
    });

    //----------------------------------------------------------



    //----------------------------------------------------------


    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


})(document, window, jQuery);