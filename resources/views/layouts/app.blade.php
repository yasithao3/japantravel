<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    @yield('page_css')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @can('view employees')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('employees') }}">Employees</a>
                                </li>
                            @endcan
                            @can('apply leaves')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('apply-leaves') }}">Apply Leaves</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('leaves') }}">Leaves</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js">
    </script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js">
        < script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js" >
    </script>
    </script>
    <script>
        function notification_handler(response) {
            var toShow = toShow === undefined ? false : toShow;
            var toHide = toHide === undefined ? false : toHide;
            var target = target === undefined ? false : target;
            var loader = loader === undefined ? false : loader;
            var elem = elem === undefined ? false : elem;
            if (loader == 'inline') {
                $('.button-spin').hide();
            }
            if (response.status == 'success') {
                if (response.renderType == 'message' || response.renderType == 'messagewithview' || response.renderType ==
                    'messagewithmodal' || response.renderType == 'messagewithvalidation') {
                    refresh_data_table(response.data);
                    success_notification(response.message);
                    redirect(response.redirect);
                    $('#crud_model').modal('hide');
                }
                if (response.renderType == 'view' || response.renderType == 'messagewithview') {
                    render_view(response.data.view, response.data.target);
                }
                if (response.renderType == 'modal' || response.renderType == 'messagewithmodal') {
                    $('#' + response.data.target).html(response.data.view);
                    $('.' + response.data.target + '.modal').html(response.data.view);
                    var myModal = new bootstrap.Modal(document.getElementById(response.data.target), {
                        keyboard: false,
                        backdrop: 'static',
                        focus: true
                    });
                    myModal.show();
                }
                if (response.renderType == 'validation' || response.renderType == 'messagewithvalidation') {
                    show_validation_errors(response.data);
                }
                $(toHide).hide();
                $(toShow).show();
            } else {
                if (response.renderType == 'message' || response.renderType == 'messagewithvalidation') {
                    error_notification(response.message);
                    redirect(response.redirect);
                }
                if (response.renderType == 'validation' || response.renderType == 'messagewithvalidation') {
                    show_validation_errors(response.data);
                }
            }
        }

        function success_notification(message) {
            $.toast().reset('all');
            $("body").removeAttr('class');
            $.toast({
                heading: 'Success',
                text: message,
                position: 'top-right',
                loaderBg: '#fec107',
                icon: 'success',
                hideAfter: 3500,
                stack: 6
            });
            return false;
        }

        function error_notification(message) {
            $.toast().reset('all');
            $("body").removeAttr('class');
            $.toast({
                heading: 'Error',
                text: message,
                position: 'top-right',
                loaderBg: '#ff354d',
                icon: 'error',
                hideAfter: 3500,
                stack: 6
            });
            return false;
        }

        function render_view(view, target) {
            $('.' + target).html(view);
        }

        function show_validation_errors(validationData) {
            $('.error-msg').each(function(index) {
                $(this).removeClass('.error-msg');
                $(this).html('');
            });
            $.each(validationData, function(index, value) {
                if (value != '') {
                    $('.' + index).html(value);
                    $('.' + index).removeClass('success-msg');
                    $('.' + index).addClass('error-msg');
                    $('.' + index).prev('.form-control').addClass('error-msg-border');
                } else {
                    $('.' + index).html('');
                    $('.' + index).addClass('success-msg');
                    $('.' + index).removeClass('error-msg');
                    $('.' + index).prev('.form-control').removeClass('error-msg-border');
                }
            });
        }

        function redirect(redirect) {
            if (redirect == 'self') {
                setTimeout(function() {
                    location.reload(true);
                }, 2800);
            } else if (redirect != '') {
                setTimeout(function() {
                    window.location.href = redirect;
                }, 1800);
            }
        }

        function refresh_data_table() {
            if (typeof table !== 'undefined') {
                table.ajax.reload();
            }
            // if (table) {
            //     table.ajax.reload();
            // }
        }
    </script>
    @yield('page_js')
</body>

</html>
