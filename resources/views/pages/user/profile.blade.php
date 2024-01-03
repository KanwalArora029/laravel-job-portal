@extends('layouts.admin.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('user.update.profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('patch') --}}
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" name="profile_pic" id="logo" class="form-control">
                        @if (auth()->user()->profile_pic)
                            <img src="{{ Storage::url(auth()->user()->profile_pic) }}" width="150"class="img-fluid mt-2"
                                alt="{{ auth()->user()->name }}">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control"
                            value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center mt-3">

            <div class="col-md-8 mt-4">
                <h2>Change Your Password</h2>
                <form action="{{ route('user.change.password') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Your Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control"
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Your New Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Update Password</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
@endsection
