<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$data->title}}</title>
    <?php $version = \Config::get('tempemails.version'); ?>

    <meta name="description" content="{{$data->description}}" />

    <link rel="icon" href="https://tempemails.io/favicon.ico" type="image/x-icon">
    <!--start of stylesheet-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100|Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/index/css/masterslider.css">
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/index/css/ms-staff-style.css">
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/index/css/magnific-popup.css">
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/alertify.min.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/nprogress.css" />
    <link rel="stylesheet" href="{{moduleAssets('tempemails')}}/index/css/style.css">
    <!--End of stylesheet-->
    <!-- Facebook -->
    <meta property="og:url" content="https://tempemails.io/">
    <meta property="og:title" content="{{$data->title}}">
    <meta property="og:description" content="{{$data->description}}">
    <meta property="og:site_name" content="TempEmails.io">
    <meta property="og:image" content="https://tempemails.io/logo-media.png">
    <meta property="og:type" content="website">

    <!-- Google Plus -->
    <meta itemprop="name" content="{{$data->title}}">
    <meta itemprop="description" content="{{$data->description}}">
    <meta itemprop="image" content="https://tempemails.io/logo-media.png">

    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
</head>

<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=58e7359082f18900123d85fe&product=inline-share-buttons"></script>

<body>
@include("tempemails::pages.partials.tracking_codes")


<!--start op popup-->
@include("tempemails::pages.partials.contact_popup")
<!--End op popup-->

<div class="header">
    <div class="main_con">
        <div class="top_nav">
            <div class="logo"><a href="{{URL::to("/")}}">@include("tempemails::pages.partials.logo_svg")</a></div>
            <div class="report">
                <a class="button popup-with-zoom-anim" href="#small-dialog">Buzz Me!</a>
            </div>

        </div>
        <div class="main_video">
            <div class="container">

                <?php
                if($data->agent->is('Windows'))
                {?>
                <video
                        id="my-player"
                        class="video-js"
                        controls
                        preload="auto" muted="true" loop="true" autoplay="true"
                        poster="{{moduleAssets('tempemails')}}/index/img/poster.png"
                        data-setup='{"fluid": true}'>
                    <source src="{{moduleAssets('tempemails')}}/index/img/intro.mp4" type="video/mp4"></source>

                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that
                        <a href="http://videojs.com/html5-video-support/" target="_blank">
                            supports HTML5 video
                        </a>
                    </p>
                </video> <?php
                } else{
                ?>
                <img src="{{moduleAssets('tempemails')}}/index/img/top_banner.gif" alt="Dedicated URL">
                <?php
                }
                ?>
                <div class="top_cont">
                    <h1>Temporary Disposable Emails</h1>
                    <p>One Click Ready, No Signup, Test & Debug Transactional Emails<span>For Developers, By Developers</span></p>
                    <a href="{{\URL::route('te.app.redirect')}}" class="button button-outline">Use tempemails.io now</a>
                    <p style="font-size: 14px; margin: 0px;">7 days of life span, unlimited email accounts</p>
                </div>
            </div>
        </div>


    </div>
</div>
<!--start of main features-->
<div class="main_con">
    <div class="main_features">
        <div class="top_heading">
            <div class="container">
                <h3><span>We Believe In Sharing, hence It's Free</span>so we are counting you in for great features</h3>
            </div>
        </div>
        <div class="fetaure_cont">
            <div class="container">

                <div class="row">
                    <div class="column">
                        <div class="rept_features">
                            <span><img src="{{moduleAssets('tempemails')}}/index/img/auto_refresh.png" alt="Auto Refresh"></span>
                            <h4>Auto Refresh</h4>
                            <p>You are the master and you should know this. There is no page reloading and you will receive your emails in your temporary email box within seconds.</p>
                        </div>
                    </div>
                    <div class="column"><div class="rept_features">
                            <span><img src="{{moduleAssets('tempemails')}}/index/img/dedicated_url.png" alt="Dedicated URL"></span>
                            <h4>Dedicated URL</h4>
                            <p>It allows you to have your own dedicated URL for storing temporary emails which can be used for testing and are accessible anywhere and anytime.</p>
                        </div></div>
                    <div class="column"><div class="rept_features">
                            <span><img src="{{moduleAssets('tempemails')}}/index/img/prevent_spam.png" alt="Prevent Spam"></span>
                            <h4>Prevent Spam</h4>
                            <p>Spammers are not preventable but some precautions can reduce their likelihood of getting your email address. We help you in creating temporary email for a site you don’t trust.</p>
                        </div></div>


                </div>

                <a class="button button-blue" href="{{\URL::route('te.app.redirect')}}">I wanna try!</a>

            </div>
        </div>
    </div>
</div>
<!--End of main features-->

<!--start of main statistics-->
<div class="main_con">
    <div class="main_statistics">
        <div class="container">
            <div class="top_heading">
                <h3><span>Tempemails usage</span>Complete Statistics</h3>
            </div>
        </div>
        <div class="statistics_cont">
            <div class="container">
                <div class="row">
                    {{--<div class="column column-67">
                        <div class="stat_chart">
                            <img src="{{moduleAssets('tempemails')}}/index/img/graph.png" alt=" graph">
                        </div>
                    </div>--}}
                    <div class="column {{--column-33--}}">
                        <div class="stat_count">
                            <ul>
                                <li><em><i><img src="{{moduleAssets('tempemails')}}/index/img/ic_inbox.png" alt="Inbox Created"></i></em><p><span>Inbox Created</span> <strong class="counter">{{ $data->accounts }}</strong></p></li>
                                <li><em><i><img src="{{moduleAssets('tempemails')}}/index/img/ic_email.png" alt="Message received"></i></em><p><span>Message received</span> <strong class="counter">{{ $data->emails }}</strong></p></li>

                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--End of main statistics-->

<!--start of happy clients-->
<div class="main_con">
    <div class="main_hclients">
        <div class="top_heading">
            <div class="container">
                <h3><span>Developed for Developers</span>And they love it!</h3>
            </div>
        </div>
        <div class="hclients_cont">
            <div class="container">
                <div class="ms-staff-carousel ms-round">
                    <!-- masterslider -->
                    <div class="master-slider" id="masterslider">
                        <div class="ms-slide">
                            <img src="{{moduleAssets('tempemails')}}/index/img/blank.gif" data-src="https://www.gravatar.com/avatar/9f756756b3b1270654d09b5b9305b940?s=140&d=mm&r=g" alt="Ameey Kumar"/>
                            <div class="ms-info">
                                <h5>Ameey Kumar</h5>
                                <p>A useful tool to avoid spam and keep your primary inbox clean.</p>
                            </div>
                        </div>
                        <div class="ms-slide">
                            <img src="{{moduleAssets('tempemails')}}/index/img/blank.gif" data-src="https://www.gravatar.com/avatar/03a8f60ba2bb4e6fe904f8165db484d0?s=140&d=mm&r=g" alt="Subrat Bhol"/>
                            <div class="ms-info">
                                <h5>Subrat Bhol</h5>
                                <p>It is the easier way to create email accounts (for avoiding spam, testing web services, etc)</p>
                            </div>
                        </div>
                        <div class="ms-slide">
                            <img src="{{moduleAssets('tempemails')}}/index/img/blank.gif" data-src="https://www.gravatar.com/avatar/1a7973431dc5aab60fd701440550a241?s=140&d=mm&r=g" alt="Akansha Singh"/>
                            <div class="ms-info">
                                <h5>Akansha Singh</h5>
                                <p>I'm giving 5 stars to this tool. Its working perfectly and never used this type of tool before...</p>
                            </div>
                        </div>
                        <div class="ms-slide">
                            <img src="{{moduleAssets('tempemails')}}/index/img/blank.gif" data-src="https://www.gravatar.com/avatar/8033ef4b0dedb9b6f1a54929175c2ada?s=140&d=mm&r=g" alt="Rati Madaan"/>
                            <div class="ms-info">
                                <h5>Rati Madaan</h5>
                                <p>Its a best and free temporary email service, where all emails received in your online browser inbox. So, no issues for storage.</p>
                            </div>
                        </div>
                        <div class="ms-slide">
                            <img src="{{moduleAssets('tempemails')}}/index/img/blank.gif" data-src="https://www.gravatar.com/avatar/41428333d01354d8009eb478431d843b?s=140&d=mm&r=g" alt="Ritu Hooda"/>
                            <div class="ms-info">
                                <h5>Ritu Hooda</h5>
                                <p>Its very easy to use and gives you multiple random email address which can be used for registering to untrusted websites</p>
                            </div>
                        </div>
                        <div class="ms-slide">
                            <img src="{{moduleAssets('tempemails')}}/index/img/blank.gif" data-src="https://www.gravatar.com/avatar/ed92cd8eff648e037c659ca46a057fe4?s=140&d=mm&r=g" alt="Sonia Negi"/>
                            <div class="ms-info">
                                <h5>Sonia Negi</h5>
                                <p>Its very dificult to sometimes test an application with just one email ID. this tool is a savior for me, it can create multiple emails and don't even ask for any of my personal details</p>
                            </div>
                        </div>

                    </div>
                    <!-- end of masterslider -->
                    <div class="ms-staff-info" id="staff-info"></div>

                    <div id="line"></div>
                </div>
                <div  id="sldr-arw"></div>
            </div>
        </div>
    </div>
</div>
<!--End of happy clients-->

<!--start of footer cta-->
<div class="main_con">
    <div class="main_ftrcta">
        <div class="container">
            <div class="ftrcta_cont" id="pledge">
                <div class="row am_center">
                    <div class="column"><img src="{{moduleAssets('tempemails')}}/index/img/charcter.gif" alt="No Signup required"></div>
                    <div class="column">
                        <div class="char_cont">
                            @include("tempemails::pages.partials.try_now_svg")
                            <a class="button button-red" href="{{\URL::route('te.app.redirect')}}">Try It Now</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--End of footer cta-->

<!--start of footer cta-->
<div class="main_con">
    <div class="footer">
        <div class="footer_cont">
            <div class="container">
                <div class="row am_center">
                    <div class="column">
                        <div class="ftr_left">
                            <p>Made with<a href="https://www.webreinvent.com/" target="_blank">
                                    <span>@include("tempemails::pages.partials.wri_svg")</span></a>in India</p>
                        </div>

                    </div>
                    <div class="column">
                        <div class="ftr_middle"><a href="{{\URL::to("/")}}">@include("tempemails::pages.partials.footer_logo_svg")</a>
                            <p>&copy; {{date('Y')}} A <a href="https://www.webreinvent.com/" target="_blank">WebReinvent's</a> Product</p>
                        </div>

                    </div>
                    <div class="column">
                        <div class="ftr_right">
                            {{--<span>Share</span>--}}
                            <div class="sharethis-inline-share-buttons"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--End of footer cta-->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{moduleAssets('tempemails')}}/index/js/jquery.easing.min.js"></script>

<!-- Master Slider -->
<script src="{{moduleAssets('tempemails')}}/index/js/masterslider.min.js"></script>
<script src="{{moduleAssets('tempemails')}}/index/js/masterslider.staff.carousel.js"></script>
<?php
if($data->agent->is('Windows'))
{?>
<script src="https://vjs.zencdn.net/5.11/video.min.js"></script>
<script>
    videojs('my-player', {
        controlBar: {
            fullscreenControl: false,

        }
    });
</script>

<?php
} else{
?>
<link rel="stylesheet" href="{{moduleAssets('tempemails')}}/index/css/mobile-style.css">
<?php
}
?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="https://bfintal.github.io/Counter-Up/jquery.counterup.min.js"></script>

<script src="{{moduleAssets('tempemails')}}/nprogress.min.js"></script>
<script src="{{moduleAssets('tempemails')}}/alertify.min.js"></script>

<script src="{{moduleAssets('tempemails')}}/index/js/jquery.magnific-popup.min.js"></script>



<script>
    (function (document, window, $) {
        'use strict';
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

    })(document, window, jQuery);
</script>

<script type="text/javascript">
    var slider = new MasterSlider();
    slider.setup('masterslider' , {
        loop:true,
        width:140,
        height:140,
        speed:20,
        view:'stf',
        preload:0,
        space:0,
        space:83,
        viewOptions:{centerSpace:2}
    });
    slider.control('arrows', {insertTo:'#sldr-arw'});
    slider.control('slideinfo',{insertTo:'#staff-info'});
    slider.control('bullets', {autohide:false  , insertTo:'#line'});
</script>
<script>

    $(document).ready(function() {
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

        $('.counter').counterUp({
            delay: 30,
            time: 1500
        });


        $(".buzzForm").submit(function (e) {
            e.preventDefault();


            NProgress.start();

            var token = $('meta[name=csrf-token]').attr('content');

            $.ajaxSetup({
                headers: {
                    "X-CSRFToken": token
                }
            });

            var ajaxOpt = {
                method: 'POST',
                url: '{{\URL::route('te.notify.admin')}}',
                async: true,
                context: this,
            };
            var  data = $(this).serialize();
            if (data) {
                ajaxOpt.data = data;
            }
            $.ajax(ajaxOpt).done(function (response) {
                NProgress.done();
                if (response.status == "success") {
                    alertify.success('Message Sent!');
                } else {
                    $.each(response.errors, function (index, object) {
                        alertify.error(object);
                    });
                }
            });


        });
    });
</script>

</body>
</html>
