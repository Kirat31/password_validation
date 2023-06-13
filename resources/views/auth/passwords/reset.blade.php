@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ trans('panel.site_title') }}</h1>

                <p class="text-muted">{{ trans('global.reset_password') }}</p>

                <form method="POST" action="{{ route('password.resets')}}">
                    @csrf

                    <!-- @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach -->

                    <input name="token" value="{{ $token }}" type="hidden">

                    <div class="form-group">
                        <input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ $email ?? old('email') }}">

                        @error('email')
                            <span style="color:Red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ trans('global.login_password') }}">

                        @error('password')
                            <span style="color:Red;">{{ $message }}</span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('global.login_password_confirmation') }}">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                {{ trans('global.reset_password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection