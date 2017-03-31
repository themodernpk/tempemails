@extends('tempemails::layouts.master')

@section('page_specific_head')

@stop

@section('page_specific_footer')

@stop

@section('content')
    @include("tempemails::pages.partials.tracking_codes")



    <div class="container">
        <div class="row">



           <div class="col-md-6 col-md-offset-3">
               <h1 class="text-center" >TempEmails.io</h1>


               <p class="text-center" style="font-style:italic; font-size: 24px; color: #888; margin-bottom: 25px;">Temporary Disposable Emails</p>
               <p class="text-center"><a href="{{\URL::route('te.app.redirect')}}" class="btn btn-success btn-lg">Start Application</a></p>


           </div>



        </div>
    </div>


@stop
