@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                  	 <a href="{{action('ExportController@export')}}">Export</a>
                   
                  </div>
                </div>
                
        </div>
    </div>
</div>

@endsection
