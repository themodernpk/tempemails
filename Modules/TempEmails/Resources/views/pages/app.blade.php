<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}}
        v{{Config::get('core.version')}}@endif</title>

    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina|Source+Sans+Pro:200|Roboto" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/alertifyjs/1.9.0/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.10.0/styles/default.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/nprogress.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/simple-grid.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/style.css" />


    <!---page specific-->
@yield('page_specific_head')
<!--/page specific-->

</head>
<body >
@include("tempemails::pages.partials.tracking_codes")

<div id="app" v-cloak>

    <!--urls-->
    <input type="hidden" data-type="url" name="base" value="{{url("/")}}" />
    <input type="hidden" data-type="url" name="current" value="{{url()->current()}}" />
    <input type="hidden" name="inbox" value="{{$data->inbox}}" />
    <!--/urls-->

    <!--header-->
    <div class="header">


        <div class="logo-con">
            <div class="logo-device fl">

                <img src="{{moduleAssets('tempemails')}}/img/logo.gif" style="width: 35px; height: 35px; margin: 10px 10px"/>

            </div>
            <div class="logo fl">
                <a href="https://tempemails.io" class="thick">tempemails<span class="thin">.io</span></a>
            </div>
        </div>

{{--        <div class="fr">
            <div  class="fr login ">
                <a href="#" class="thin"><i class="fa fa-user"></i> LOGIN</a>
            </div>
            <div class="fr register">
                Extend email expiry date up to 7 days.
                <a href="#" class="btn btn-success">REGISTER</a>
            </div>
        </div>--}}

    </div>
    <!--/header-->

    <div class="content">


        <!--account list-->
        <div class="sidebar bg-dark-violet ">
            <div class="account-list">

                <h5><i class="fa fa-envelope"></i> EMAIL ACCOUNTS</h5>

                <ul class="scrollbar" style="height: 500px">
                    <li v-if="accounts" v-for="account in accounts">
                        <a class="email-link clickToCopy" v-bind:href="account.email"
                           v-on:click="setActiveAccount($event, account)">@{{ account.email }}</a>
                        <span>
                        <a href="#" class="account-close" v-on:click="deleteAccount($event, account)"><i class="fa fa-times-circle-o"></i></a>
                        </span>

                        <label v-if="account.unread_mails_count > 0">@{{ account.unread_mails_count }}</label>
                    </li>


                </ul>


            </div>
            <button class="new-email" v-on:click="generateAccount()"><i class="fa fa-plus"></i> &nbsp; ADD NEW EMAIL</button>
        </div>
        <!--/account list-->

        <!--account-->
        <div class="page" v-if="account_active" >

            <div class="page-header" >
                <div class="page-header-left">
                    <a class="thin clickToCopy" v-bind:href="account_active.email">@{{ account_active.email }} <span>Click To Copy</span></a>
                </div>
                <div class="page-header-right">
                    <div class="btn-group">
                        <a v-bind:href="account_active.email" class="btn-white clickToCopy"><i class="fa fa-clone"></i></a>
                        <button class="btn-white" v-on:click="setActiveAccount($event, account_active)">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button class="btn-white" v-on:click="deleteAccount($event, account_active)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>

                </div>

                <br clear="all"/>
            </div>

            <div class="page-content">


                <div class="page-body">

                    <div class="page-body-left">

                        <div class="emails">


                            <div class="emails-header">
                                <div class="emails-header-left fl">

                                    <input class="emails-search" placeholder="Search Not Enabled">

                                </div>

                                <div class="emails-header-right fr">
                                    <button class="btn-white" v-on:click="markAllAsRead($event, account_active)">
                                        <i class="fa fa-check-square-o"></i>
                                    </button>
                                    <button class="btn-white" v-on:click="deleteAllEmails($event, account_active)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>


                                <br clear="all"/>

                            </div>

                            <div class="emails-list scrollbar-emails">


                                <table class="table ">
                                    <tr v-for="email in emails" class="fetchEmail" v-on:click="fetchEmail($event, email)">
                                        <td width="15"><span class="tag-circle">w</span></td>
                                        <td><div class="subject" v-bind:class="{'read': email.read}">@{{ email.subject }}
                                                <span class="text-small">From: @{{ email.from[0].email }}</span>
                                            </div>
                                        </td>
                                        <td><div class="time">@{{ fromNow(email.received_at) }}</div></td>
                                    </tr>

                                </table>


                            </div>



                        </div>


                    </div>
                    <div class="page-body-right scrollbar-email">

                        <div class="email-details" v-if="email_fetched">
                            <div class="email-details-header" >

                                <div class="row">

                                    <table>
                                        <tr>
                                            <td><div class="subject" v-if="email_fetched.subject" v-bind:class="{'read': email_fetched.read}">@{{ email_fetched.subject }}</div></td>
                                            <td class="text-right" width="180">
                                                {{--<button class="btn-white"><i class="fa fa-trash"></i></button>--}}
                                                <a class="btn-white" v-bind:href="email_fetched.iframe" target="_blank">
                                                    <i class="fa fa-external-link"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>

                                            <td><span class="text-small" v-if="email_fetched.from && email_fetched.from[0].name">From: @{{ email_fetched.from[0].name }} &lt;@{{ email_fetched.from[0].email }}&gt;</span>

                                                <span class="text-small" v-else>From: @{{ email_fetched.from[0].email }}</span>

                                            </td>

                                            <td class="text-right"><span class="text-small">@{{ fromNow(email_fetched.received_at) }}</span></td>
                                        </tr>

                                        <tr v-if="email_fetched.to">
                                            <td><div class="text-small"><div class="fl text-small">To: &nbsp;</div>
                                                    <span class="fl" v-for="item in email_fetched.to">
                                                    <span class="text-small" v-if="item.name" >@{{ item.name }} &lt;@{{ item.email }}&gt;, &nbsp;</span>
                                                    <span class="text-small" v-else >@{{ item.email }}, &nbsp; </span>
                                                </span>
                                                </div></td>
                                            <td class="text-right"><span class="text-small">@{{ email_fetched.received_at }}</span></td>
                                        </tr>

                                        <tr v-if="email_fetched.cc">
                                            <td><div class="text-small"><div class="fl text-small">CC: &nbsp;</div>
                                                    <span class="fl" v-for="item in email_fetched.cc">
                                                    <span class="text-small" v-if="item.name" >@{{ item.name }} &lt;@{{ item.email }}&gt;, &nbsp; </span>
                                                    <span class="text-small" v-else >@{{ item.email }}, &nbsp; </span>
                                                </span>
                                                </div></td>
                                            <td class="text-right"></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="text-small">
                                            <ul class="attachments fl">
                                                <li>Attachments:</li>
                                                <li v-if="email_fetched.attachments" v-for="file in email_fetched.attachments">
                                                    <a v-bind:href="file.url" target="_blank"><i class="fa fa-paperclip"></i> @{{ file.name }}</a>
                                                </li>


                                            </ul>
                                            </td>

                                        </tr>

                                    </table>

                                </div>


                            </div>

                            <div class="email-details-tabs " >


                                <div class="tabs-con row">
                                    <ul class='tabs'>
                                        <li><a href='#html' v-on:click="tabs($event)" class="active">HTML</a></li>
                                        <li><a href='#htmlSource' id="showHtmlSource" v-on:click="tabs($event)" >HTML Source</a></li>
                                        <li><a href='#text' v-on:click="tabs($event)">Text</a></li>
                                        <li><a href='#raw' v-on:click="tabs($event)">Raw</a></li>
                                    </ul>
                                </div>

                                <div class="tab-content-con row">
                                    <div id='html' class="tab-content">
                                        <iframe style="width: 100%; height: 100%;
                                                border: none; outline: none; overflow:auto;"
                                                v-bind:src="email_fetched.iframe"></iframe>
                                    </div>
                                    <div id='htmlSource' class="tab-content hide">
                                        <pre><code class="html" >
                                            @{{ email_fetched.formatted }}
                                        </code></pre>
                                    </div>
                                    <div id='text' class="tab-content hide">
                                        @{{ email_fetched.message_text }}
                                    </div>

                                    <div id='raw' class="tab-content hide">
                                        @{{ email_fetched.message_raw }}
                                    </div>
                                </div>

                                <br clear="all"/>
                            </div>


                        </div>

                    </div>


                </div>


            </div>

        </div>
        <!--/account-->



    </div>


</div>
<!--/end app-->



<!--common js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.2.1/vue-resource.js"></script>
<script src="http://areaaperta.com/nicescroll/js/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
<script src="https://cdn.jsdelivr.net/alertifyjs/1.9.0/alertify.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.10.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.1/clipboard.js"></script>
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>

<script src="{{moduleAssets('tempemails')}}/Pagination.js"></script>
<script src="{{moduleAssets('tempemails')}}/VueCommon.js"></script>
<script src="{{moduleAssets('tempemails')}}/accounts.js"></script>


<script>
    $(document).ready(function()
    {





        var browser_h = $(window).height();
        var middle_h = browser_h-200;
        $(".scrollbar").css('height', middle_h);
        $(".scrollbar").niceScroll({cursorcolor:"#575e71"});

        var browser_h = $(window).height();
        var middle_h = browser_h-180;
        $(".scrollbar-emails").css('height', middle_h);
        $(".scrollbar-emails").niceScroll({cursorcolor:"#575e71"});


        var browser_h = $(window).height();
        var middle_h = browser_h;
        $(".scrollbar-email").css('max-height', middle_h);
        $(".scrollbar-email").css('height', middle_h);
        $(".scrollbar-email").niceScroll({cursorcolor:"#575e71"});

        hljs.initHighlightingOnLoad();
        new Clipboard('.clickToCopy',{
            text: function(trigger) {
                return trigger.getAttribute('href');
            }
        });

    });

</script>



<script>
    (function (document, window, $) {
        'use strict';
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });




    })(document, window, jQuery);
</script>

<!--/common js-->

<!---page specific-->
@yield('page_specific_footer')
<!--/page specific-->
</body>
</html>
