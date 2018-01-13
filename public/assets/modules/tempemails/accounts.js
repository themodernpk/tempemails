

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
        email_filter: null,
        email_search: null,
        new_email: null,
        pusher: null,
        new_email_code: null,

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
        this.generateNewEmailCode();
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

            console.log("silent loader", this.emails);

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
                        //console.log("email", this.emails);
                    });
            }

        },
        //---------------------------------------------------------------------
        listAccounts: function () {
            var url = this.urls.inbox+"/account/list";
            var params = {};
            console.log("list url", url);
            this.processHttpRequest(url, params, this.listAccountsAfter);
        },
        //---------------------------------------------------------------------
        checkNewEmailCode: function () {
            if(!this.new_email_code)
            {
                this.new_email_code = this.genUID();
            }
        },
        //---------------------------------------------------------------------
        emptyNewEmailCode: function () {
            this.new_email_code = null;
        },
        //---------------------------------------------------------------------
        generateNewEmailCode: function () {

            this.new_email_code = this.genUID();
        },
        //---------------------------------------------------------------------
        genUID: function () {
            var text = "";
            var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 5; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        },
        //---------------------------------------------------------------------

        listAccountsAfter: function (data) {
            NProgress.done();
            this.accounts = data;
            var self = this;
            this.accounts.forEach(function (account)
            {
                var channelName = 'private-account.'+account.id;
                //console.log("channelName", channelName);
                var channel = self.pusher.subscribe(channelName);
                channel.bind("email.created", function(data) {
                    //self.silentFetch();
                    //console.log("email created event", data);
                    self.listAccounts();
                    self.fetchEmails();
                });
            });

            var self = this;

            this.$nextTick(function () {
                self.activateNiceScroll();

            });

        },
        //---------------------------------------------------------------------
        generateAccount: function () {
            var url = this.urls.inbox+"/generate/account";
            var params = { username: this.new_email_code };


            NProgress.start();
            this.$http.post(url, params)
                .then(response => {
                    if(response.data.status == 'success')
                    {
                        alertify.success('Email Account Created')
                    } else
                    {
                        this.errors(response.data.errors);
                    }

                    this.listAccounts();
                    this.generateNewEmailCode();

                    NProgress.done();
                });

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        setActiveAccount: function (event, account) {
            if(event)
            {
                event.preventDefault();
            }

            if(account.expired == 1)
            {
                alertify.error('Account is expired');
                return false;
            }

            this.account_active = account;

            console.log(account);

            this.fetchEmails();

        },
        //---------------------------------------------------------------------
        clickToCopy: function () {

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
            this.email_filter = data.data;
            var self = this;

            this.$nextTick(function () {
                self.activateNiceScroll();

            });
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
            this.resizeIframe();
            var self = this;

            this.$nextTick(function () {
                self.resizeIframe();
                self.activateNiceScroll();

            });
        },
        //---------------------------------------------------------------------
        start: function () {
            NProgress.start();
        },
        //---------------------------------------------------------------------
        resizeIframe: function () {



            $('iframe').load(function() {
                this.style.height = 0;
            this.style.height =
                (this.contentWindow.document.body.offsetHeight +100)+ 'px';

            console.log('-->height', this.style.height);

            });
            $("html, body").animate({ scrollTop: 0 }, "slow");
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
        },
        //---------------------------------------------------------------------
        activateNiceScroll: function () {
            var browser_h = $(window).height();
            var middle_h = browser_h-200;
            $(".scrollbar").css('height', middle_h);
            $(".scrollbar").niceScroll({cursorcolor:"#575e71"});

            var browser_h = $(window).height();
            var middle_h = browser_h-180;
            $(".scrollbar-emails").css('height', middle_h);
            $(".scrollbar-emails").niceScroll({cursorcolor:"#575e71"});


            /*var browser_h = $(window).height();
            var middle_h = browser_h;
            $(".scrollbar-email").css('max-height', middle_h);
            $(".scrollbar-email").css('height', middle_h);
            $(".scrollbar-email").niceScroll({cursorcolor:"#575e71"});*/
        },
        //---------------------------------------------------------------------
        filterEmails: function () {

            console.log("testing", this.email_search);

            var self = this;
            if(this.email_search != "")
            {
                this.emails = this.email_filter.filter(function (item)
                {
                    return item.subject.toLowerCase().match(self.email_search);
                });
            } else
            {
                this.emails = this.email_filter;
            }


        },
        //---------------------------------------------------------------------
        getFirstCharacter: function (string)
        {
            return string.charAt(0);
        },
        //---------------------------------------------------------------------
        getColor: function (email) {



            var char = this.getFirstCharacter(email);



            char.toLowerCase();

            var colorArray = [];
            colorArray['a'] = '#';
            colorArray['b'] = '#EC407A';
            colorArray['c'] = '#AB47BC';
            colorArray['d'] = '#8E24AA';
            colorArray['e'] = '#D81B60';
            colorArray['f'] = '#E53935';
            colorArray['g'] = '#D81B60';
            colorArray['h'] = '#1976D2';
            colorArray['i'] = '#303F9F';
            colorArray['j'] = '#512DA8';
            colorArray['k'] = '#6200EA';
            colorArray['l'] = '#0277BD';
            colorArray['m'] = '#00838F';
            colorArray['n'] = '#00695C';
            colorArray['o'] = '#00BFA5';
            colorArray['p'] = '#00B8D4';
            colorArray['q'] = '#0091EA';
            colorArray['r'] = '#558B2F';
            colorArray['s'] = '#9E9D24';
            colorArray['t'] = '#2E7D32';
            colorArray['u'] = '#2E7D32';
            colorArray['v'] = '#F9A825';
            colorArray['w'] = '#FF8F00';
            colorArray['x'] = '#EF6C00';
            colorArray['y'] = '#F57F17';
            colorArray['z'] = '#FF6F00';


            var color_code = colorArray[char];

            return color_code;

        }
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

        if(!$(this).hasClass( "strikethrough" ))
        {
            alertify.success("Email Copied");
        }

    });

    //----------------------------------------------------------

    $('body').on('click', '#htmlTab', function (e) {
        e.preventDefault();

        var browser_h = $(window).height();
        var middle_h = browser_h-320;

        console.log("height", middle_h);

        $("#html").css('height', middle_h);

        document.getElementById('iframeTag').contentWindow.location.reload();
    });

    //----------------------------------------------------------
    $('.popup-with-zoom-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: false,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in'
    });

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


})(document, window, jQuery);