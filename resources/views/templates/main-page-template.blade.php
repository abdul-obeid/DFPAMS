<!doctype html>
<html lang="en">

    <head>
        <title>DF-PAMS</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/tsm-favicons/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" href="{{asset('img/tsm-favicons/favicon.ico')}}"> --}}

        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        {{-- jQuery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        {{-- Select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css"
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

        <!-- Material Kit CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/material-kit.css') }}">

        <!-- Default CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


        {{-- Flatpickr --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        {{-- Bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        {{-- Flatpickr JS --}}
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!--FullCalendar JS -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
        <!-- SweetAlert JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        {{-- DataTable JS--}}
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

        <style>
            /* Apply styles to all text inputs */
            input[type="text"] {
                border: 1px solid #ccc;
            }
        </style>
    </head>

    <body>
        
        <x-admin-navbar />

        <div class="page-header min-vh-35" style = "background-image: url({{asset('assets/img/bg-pricing.jpg')}})">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="text-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body shadow-xl mx-3 mx-md-4 mt-n6">
            <div class="container">
                <div class="section text-center">

                    @yield('content')

                </div>
            </div>
        </div>
        <script>
            //Select2 code
            $(document).ready(function() {
                $('.selector').select2();
                flatpickr('.flatpickr', {
                    dateFormat: 'd-m-Y',
                });
            });
        </script>

        <footer class="footer pt-5 mt-5">
            <div class="col-12">
                <div class="text-center">
                    <p class="text-dark my-4 text-sm font-weight-normal">
                        All rights reserved. Copyright ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> DF-PAMS by <a href="#">Multimedia University</a>.
                    </p>
                </div>
            </div>
            </div>
            </div>
        </footer>

    </body>

    @if ($errors->any() || session('error') || session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if ($errors->any() || session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'There was an error!',
                        html: `<ul class="navbar-nav ml-auto list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        @if (session('error'))
                            <li>{{ session('error') }}</li>
                        @endif
                    </ul>`,
                        showCloseButton: true,
                    });
                @elseif (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        showCloseButton: true,
                    });
                @endif
            });
        </script>
    @endif

</html>