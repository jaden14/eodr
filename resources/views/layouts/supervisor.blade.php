<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Activity</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css')}}" />
        
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-view.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <style>
body {
    background-color: #fff3c0;
    background-repeat: no-repeat;
    background-size: cover;
 }

 .vl {
  border-right: 1px solid white;
  height: 300px;
  margin-right: 350px;
} 
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/accomplishment') }}">
                    Activity
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/accomplishment') }}">Accomplishments</a>
                        </li>
                        @if(Auth::user()->office_id ==1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('http://serversql.dvodeoro.ph:8081/') }}">Service Ticketing</a>
                        </li>
                        @endif
                        @if(Auth::user()->role =='Secretariat')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/committe') }}">Committees</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/meeting') }}">Meetings</a>
                        </li>
                        @if(Auth::user()->user_type !='administrator')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('journal.index') }}">Journals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/targets') }}">Targets</a>
                        </li>
                        <li class="nav-item dropdown">
                           <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="modal" data-target="#eligible_export" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Export
                                </a>

                        </li>
                        @endif
                        @if(Auth::user()->user_type =='Supervisor')
                         <li class="nav-item">
                            <a class="nav-link" href="{{ url('/employees') }}">Employees</a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type =='administrator')

                         <li class="nav-item">
                            <a class="nav-link" href="{{ url('/employees') }}">Employees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/offices') }}">Offices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/division') }}">Division</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->FFIRST }} {{ Auth::user()->FMI }} {{ Auth::user()->FLAST }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- modal for export -->
<div class="modal fade" id="eligible_export" data-backdrop="static" data-keyboard="false" tabindex="1"  aria-labelledby="importLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/exports" id="import_form" method="Get">
                <div class="modal-header">
                    <h4 class="modal-title" id="importLabel">Export File</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <input type="month" class="form-control-file" name="date" id="sample" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="vaccination" class="btn " style="background-color:#211401; color:white">Export File</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/swal.min.js') }}"></script>
     @yield('scripts')
</body>
</html>
