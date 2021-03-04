@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: #fff3c0; border: none; margin-top: 5%;">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <center>
                        <div class="form-group">
                            <h1><b>END OF DAY REPORT</b></h1>
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
                                <input id="password" type="hidden" class="form-control @error('password') is-invalid @enderror" name="password" value="1">

                        <div class="form-group mb-0">
                            <div class="col-md-8">
                                <button type="submit" style="background-color: #442900;" class="btn form-control">
                                    <span style="color: white;">{{ __('Generate') }}</span>
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
