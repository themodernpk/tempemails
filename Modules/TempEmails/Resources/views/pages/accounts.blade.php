@extends('tempemails::layouts.master')

@section('page_specific_head')

@stop

@section('page_specific_footer')


    <script src="{{moduleAssets('tempemails')}}/Pagination.js"></script>
    <script src="{{moduleAssets('tempemails')}}/VueCommon.js"></script>
    <script src="{{moduleAssets('tempemails')}}/accounts.js"></script>
    <script>hljs.initHighlightingOnLoad();
        new Clipboard('.clickToCopy',{
            text: function(trigger) {

                return trigger.getAttribute('href');
            }
        });
    </script>

@stop

@section('content')

    <div id="app">


        <!--urls-->
        <input type="hidden" data-type="url" name="base" value="{{url("/")}}" />
        <input type="hidden" data-type="url" name="current" value="{{url()->current()}}" />
        <!--/urls-->

        <div class="container-fluid" style="background-color: #f2f2f2;">
            <div class="row-fluid">



                <div class="col-md-2">
                    <div style="border-right: 1px solid #ccc; background-color: #f2f2f2; padding: 10px; ">
                        <h5>Account</h5>
                        <ul class="list-group">
                            <li v-if="accounts" v-for="account in accounts"
                                class="list-group-item">
                                <a class="clickToCopy"

                                   v-bind:href="account.email"
                                   v-on:click="fetchEmails($event, account)" >@{{ account.email }}
                                    <span class="badge">@{{ account.mails_count }}</span>
                                </a>
                                <button
                                        v-on:click="deleteAccount($event, account)"
                                        class="btn btn-sm btn-inverse">X</button></li>
                        </ul>

                        <button class="btn btn-success  btn-sm" v-on:click="generateAccount()">Add</button>

                    </div>



                </div>
                <div class="col-md-3">
                    <div v-if="emails" style="border-right: 1px solid #ccc; padding: 10px; ">
                        <h5 v-if="account_active">Emails of: @{{ account_active.email }}</h5>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Search Email">
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item"  v-for="email in emails"
                                v-on:click="fetchEmail($event, email)"
                                style="cursor: pointer;">
                                <div class="email-subject">

                                    <span v-if="email.read">@{{ email.subject }}</span>
                                    <b v-else>@{{ email.subject }}</b>
                                    <br/>
                                    <div>From:

                                        <span v-for="item in email.from">
                                            <span v-if="item.name" >@{{ item.name }} (@{{ item.email }})</span>
                                            <span v-else >@{{ item.email }}</span>
                                        </span>

                                    </div>
                                    <div>To:
                                        <span v-for="item in email.to">
                                            <span v-if="item.name" >@{{ item.name }} (@{{ item.email }})</span>
                                            <span v-else >@{{ item.email }}</span>
                                        </span>
                                    </div>

                                </div>
                            </li>

                        </ul>

                    </div>

                </div>
                <div class="col-md-7" style="background-color: #fff;" v-if="email_fetched">
                    <div style=" padding: 10px; " >
                        <h4>@{{ email_fetched.subject }}</h4>
                        <table class="table table-condensed table-borderded">
                            <tbody>
                            <tr v-if="email_fetched.from">
                                <th width="50">From</th><td>
                                    <div v-for="item in email_fetched.from">
                                        <span v-if="item.name" >@{{ item.name }} (@{{ item.email }})</span>
                                        <span v-else >@{{ item.email }}</span>
                                    </div>

                                </td>

                            </tr>

                            <tr v-if="email_fetched.to">
                                <th>To</th><td>
                                    <div v-for="item in email_fetched.to">
                                        <span v-if="item.name" >@{{ item.name }} (@{{ item.email }})</span>
                                        <span v-else >@{{ item.email }}</span>
                                    </div>
                                </td>

                            </tr>

                            <tr v-if="email_fetched.cc">
                                <th>Cc</th><td>
                                    <div v-for="item in email_fetched.cc">
                                        <span v-if="item.name" >@{{ item.name }} (@{{ item.email }})</span>
                                        <span v-else >@{{ item.email }}</span>
                                    </div>
                                </td>

                            </tr>

                            </tbody>
                        </table>

                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#html" role="tab" data-toggle="tab">HTML</a></li>
                                <li role="presentation"><a href="#htmlSource" role="tab" id="showHtmlSource" data-toggle="tab">HTML Source</a></li>
                                <li role="presentation"><a href="#text" role="tab" data-toggle="tab">Text</a></li>
                                <li role="presentation"><a href="#raw" role="tab" data-toggle="tab">Raw</a></li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="html">
                                    <iframe style="width: 100%; height: 100%;
                            border: none; outline: none; overflow:scroll;"
                                            v-bind:src="email_fetched.iframe"></iframe>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="htmlSource"><pre><code class="html" >
                                            @{{ email_fetched.formatted }}
                                        </code></pre></div>
                                <div role="tabpanel" class="tab-pane" id="text">@{{ email_fetched.message_text }}</div>
                                <div role="tabpanel" class="tab-pane" id="raw">@{{ email_fetched.message_raw }}</div>
                            </div>

                        </div>

                    </div>


                </div>


            </div>
        </div>


    </div>

@stop
