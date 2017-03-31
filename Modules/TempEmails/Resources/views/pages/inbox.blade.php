@extends('tempemails::layouts.master')

@section('page_specific_head')

@stop

@section('page_specific_footer')

@stop

@section('content')

    <div class="container">
        <div class="row">



           <div class="col-md-6 col-md-offset-3">
               <h1>Temporary Emails</h1>


               <p>Generate Temporary Emails</p>
               <div class="form-group btn-group">
                   <div class="input-group">
                       <input type="email" class="form-control" value="{{ $data->username  }}" placeholder="email">
                       <span class="input-group-addon">@tempemails.io</span>
                   </div>
               </div>

               <button class="btn btn-primary">Create</button>


           </div>



        </div>
    </div>


@stop
