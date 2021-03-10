@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: #fff3c0; border: none; margin-top: 5%;">

                <div class="card-body">
                    <form method="POST" action="{{ route('login.verify') }}">
                        @csrf
                        <center>
                        <div class="form-group">
                            @if ($message = Session::get('delete'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>

@endif
                            <h1><b>EORD SUPERVISOR LOGIN</b></h1>
                            <div class="col-md-8">
                            <div class="dropdown-divider" style="border-top: 1px solid #212529"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input id="cats" type="text" class="form-control @error('cats') is-invalid @enderror" name="cats" value="{{ old('cats') }}" required autocomplete="cats" placeholder="Cats Number" autofocus>

                                @error('cats')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password">
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-8">
                                <button type="submit" style="background-color: #442900;" class="btn form-control">
                                    <span style="color: white;">{{ __('Login') }}</span>
                                </button>
                            </div>
                        </div>
                    </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
