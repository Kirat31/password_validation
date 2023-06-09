@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-header p-4">
                <h1>{{ trans('panel.site_title') }}</h1>
                <p class="text-muted">{{ trans('Change password') }}</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('password.update') }}" method="POST">
                @csrf

                    <div class="form-group">
                        <label for="current_password" class="col-md-4 control-label">Current Password</label>

                        <div class="col-md-6">
                            <input type="password" name="current_password" id="current_password">
                            @error('current_password')
                                <span style="color:Red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>

                        <div class="col-md-6">
                            <input type="password" name="password" id="password">
                            @error('password')
                            <span style="color:Red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>

                        <div class ="col-md-6">
                            <input type="password" name="password_confirmation" id="password_confirmation">
                            @error('password_confirmation')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" >
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection