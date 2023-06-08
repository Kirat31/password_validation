@extends('layouts.app')
@section('content')
<!-- <div class="container"> -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div> 
                        <a href="/">Return to homepage</a>
                    @else
                    <div class="alert alert-info">
                        Your password has expired, please change it.
                    </div>
                    <form method="POST" action="{{ route('password.post_expired') }}">
                       @csrf
                        <!-- <pre>
                            @php
                            print_r($errors->all)
                            @endphp
                        </pre> -->
                        <div class="form-group">
                            <label for="current_password" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="current_password" name="current_password" type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}"  autocomplete="current_password">

                                @if ($errors->has('current_password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('current_password') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" autocomplete="new_password">

                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new_password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                    <!-- {{ trans('global.reset_password') }} -->Submit
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection