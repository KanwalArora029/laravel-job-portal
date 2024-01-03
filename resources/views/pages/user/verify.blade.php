@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h1>Verify your email</h1>
                <div class="card-body">
                    <p>Your account is not verified, Please verify your account first.</p>
                    <a href="{{ route('verification.resend') }}" class="btn btn-primary">Resend verification email</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection