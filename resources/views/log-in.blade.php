@extends('templates.sign-in')

@section('content')

<form role="form" class="text-start" method="POST" action="{{ route('login.auth') }}">
    @csrf
    <div class="input-group input-group-outline my-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required />
    </div>
    <div class="input-group input-group-outline mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required />
    </div>
    <div class="form-check form-switch d-flex align-items-center mb-3">
        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" />
        <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
    </div>
    <div class="text-center">
        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
            Sign in
        </button>
    </div>
</form>

@endsection
