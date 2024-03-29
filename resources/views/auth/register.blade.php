
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 py-5">
            <div class="card">
                    <div class="h1 card-header text-center"><strong>{{ __('Register') }}</strong></div>
                    @if (auth()->user()->hasRole('admin'))
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                <p class="gl-field-hint text-secondary">Minimum length is 8 characters</p>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group mb-4">
                                <label for="role">{{ __('Role') }}</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="customer">Customer </option>
                                    <option value="inspector">Inspector </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                {{ __('Register') }}
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="card-body">
                    <h4>Please Ask Administrator to Register Your Account</h4>
                </div>
                @endif
        </div>
    </div>
</div>
@endsection
