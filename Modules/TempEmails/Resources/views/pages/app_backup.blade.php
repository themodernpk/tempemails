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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/simple-grid.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/style.css" />



<!---page specific-->
@yield('page_specific_head')
<!--/page specific-->


</head>
<body>

    <!--header-->
    <div class="header">


        <div class="logo-con">
            <div class="logo-device fl">

            </div>
            <div class="logo fl">
                <a href="https://tempemails.io" class="thick">tempemails<span class="thin">.io</span></a>
            </div>
        </div>

            <div class="fr">
                <div  class="fr login ">
                    <a href="#" class="thin"><i class="fa fa-user"></i> LOGIN</a>
                </div>
                <div class="fr register">
                    Extend email expiry date up to 7 days.
                    <a href="#" class="btn btn-success">REGISTER</a>
                </div>
            </div>

    </div>
    <!--/header-->

    <div class="content">







    <!--account list-->
            <div class="sidebar bg-dark-violet ">
                <div class="account-list">

                <h5><i class="fa fa-envelope"></i> EMAIL ACCOUNTS</h5>

                    <ul class="scrollbar" style="height: 500px">
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>

                        <li class="active">
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>

                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>

                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>
                        <li>
                            <a class="email-link" href="agdce@tempemails.io">agdce@tempemails.io</a>
                            <label>20</label>
                            <a href="#" class="account-close"><i class="fa fa-times-circle-o"></i></a>
                        </li>


                    </ul>



                </div>
                <button class="new-email"><i class="fa fa-plus"></i> &nbsp; ADD NEW EMAIL</button>
            </div>
    <!--/account list-->

    <!--account-->
    <div class="page" >

        <div class="page-header">

            <div class="page-header-left">
                <h3 class="thin">asdfas@tempemails.io</h3>
            </div>


            <div class="page-header-right">

                <div class="btn-group">
                    <button class="btn-white"><i class="fa fa-clone"></i></button>
                    <button class="btn-white"><i class="fa fa-refresh"></i></button>
                    <button class="btn-white"><i class="fa fa-trash"></i></button>
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

                                <input class="emails-search" placeholder="Search Email">

                            </div>

                            <div class="emails-header-right fr">
                                <button class="btn-white"><i class="fa fa-check-square-o"></i></button>
                                <button class="btn-white"><i class="fa fa-trash"></i></button>
                            </div>


                            <br clear="all"/>

                        </div>

                        <div class="emails-list scrollbar-emails">


                            <table class="table ">
                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>
                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>


                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>


                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>

                                <tr>
                                    <td width="15"><span class="tag-circle">w</span></td>
                                    <td><div class="subject read">CSS Styling Tables - W3Schools
                                            <span class="text-small">From: weasdf@gmail.com</span>
                                        </div>

                                    </td>
                                    <td><div class="time">2 days ago</div></td>
                                </tr>


                            </table>


                        </div>



                    </div>


                </div>
                <div class="page-body-right scrollbar-email" style="overflow: scroll">

                    <div class="email-details  ">
                        <div class="email-details-header">

                            <div class="row">

                                <table>
                                    <tr>
                                        <td><div class="subject">CSS vertical-align property - W3Schools CSS vertical-align property - W3Schools</div></td>
                                        <td class="text-right" width="150">
                                            <button class="btn-white"><i class="fa fa-trash"></i></button>
                                            <button class="btn-white"><i class="fa fa-external-link"></i></button>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td><span class="text-small">From: weasdf@gmail.com</span></td>
                                        <td class="text-right"><span class="text-small">2 days ago</span></td>
                                    </tr>

                                    <tr>
                                        <td><span class="text-small">To: weasdf@gmail.com</span></td>
                                        <td class="text-right"><span class="text-small">22 Mar 2017, 12:30pm</span></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><span class="text-small">Attachments:
                                            <ul class="attachments">
                                                <li><a href="#"><i class="fa fa-paperclip"></i> Testing Files</a></li>
                                                <li><a href="#"><i class="fa fa-paperclip"></i> Testing Files</a></li>
                                                <li><a href="#"><i class="fa fa-paperclip"></i> Testing Files</a></li>

                                            </ul>
                                            </span></td>

                                    </tr>

                                </table>

                            </div>


                        </div>

                        <div class="email-details-tabs ">


                            <div class="tabs-con row">
                            <ul class='tabs'>
                                <li><a href='#tab1' class="active">HTML</a></li>
                                <li><a href='#tab2'>HTML Source</a></li>
                                <li><a href='#tab3'>Text</a></li>
                                <li><a href='#tab3'>Raw</a></li>
                            </ul>
                            </div>

                            <div class="tab-content-con row">
                            <div id='tab1' class="tab-content">
                                <p>Hi, this is the first tab.</p>
                            </div>
                            <div id='tab2' class="tab-content">
                                <p>This is the 2nd tab.</p>
                            </div>
                            <div id='tab3' class="tab-content">
                                <p>And this is the 3rd tab.</p>
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






<!--common js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.2.1/vue-resource.js"></script>
    <script src="http://areaaperta.com/nicescroll/js/jquery.nicescroll.min.js"></script>


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

        });

    </script>



<script>
    (function (document, window, $) {
        'use strict';
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });


        $('ul.tabs').each(function(){
            // For each set of tabs, we want to keep track of
            // which tab is active and its associated content
            var $active, $content, $links = $(this).find('a');

            // If the location.hash matches one of the links, use that as the active tab.
            // If no match is found, use the first link as the initial active tab.
            $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
            $active.addClass('active');

            $content = $($active[0].hash);

            // Hide the remaining content
            $links.not($active).each(function () {
                $(this.hash).hide();
            });

            // Bind the click event handler
            $(this).on('click', 'a', function(e){
                // Make the old tab inactive.
                $active.removeClass('active');
                $content.hide();

                // Update the variables with the new link and content
                $active = $(this);
                $content = $(this.hash);

                // Make the tab active.
                $active.addClass('active');
                $content.show();

                // Prevent the anchor's default click action
                e.preventDefault();
            });
        });





    })(document, window, jQuery);
</script>

<!--/common js-->

<!---page specific-->
@yield('page_specific_footer')
<!--/page specific-->
</body>
</html>
