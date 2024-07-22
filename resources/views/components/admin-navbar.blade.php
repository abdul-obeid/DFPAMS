<!-- Navbar Transparent -->
<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent">
    <div class="container">
        <a class="navbar-brand text-white" 
        {{-- href="{{ route('configure.index') }}" --}}
         rel="tooltip"
            title="DF-PAMS" data-placement="bottom">
           MMU FYP Activities Management System
            <div class="navbar-subtext" style="font-size: 1.1em;">Welcome <em>{{ Auth::user()->name }}</em>,</div>
            <div class="navbar-subtext font-weight-bold" style="font-size: 1.2em;">{{ Auth::user()->user_type }}</div>
        </a>
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
            <ul class="navbar-nav ms-auto">
                <!-- Competitions -->
                <li class="nav-item mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuDocs"
                        aria-expanded="false" 
                        href=
                        @if (Auth::user()->user_type === 'coordinator')
                            {{ route('admin.index') }}
                        @elseif(Auth::user()->user_type === 'Student')
                            {{ route('student-homepage.index') }}
                        @elseif(Auth::user()->user_type === 'Supervisor')
                            {{ route('supervisor.index') }}
                        @endif
                        
                        >
                        <i class="material-icons opacity-6 me-2 text-md">home</i>
                        Home
                    </a>
                </li>

                <!-- Sign out -->
                <li class="nav-item mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="logoutButton">
                        <i class="material-icons opacity-6 me-2 text-md">logout</i>
                        Sign out
                    </a>
                </li>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <script>
                    document.getElementById('logoutButton').addEventListener('click', function(event) {
                        event.preventDefault();
                        document.getElementById('logoutForm').submit();
                    });
                </script>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
