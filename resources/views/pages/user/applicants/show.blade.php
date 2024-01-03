@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mt-5">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <h1>{{ $listing->title }}</h1>
                @foreach ($listing->users as $user)
                    <div class="card mt-5 {{ $user->pivot->shortlisted ? 'card-bg' : '' }}">
                        <div class="row p-3 g-0">
                            <div class="col-auto">
                                @if ($user->profile_pic)
                                    <img src="{{ Storage::url($user->profile_pic) }}" alt="Profile Pic" class="rounded-circle"
                                        style="width:150px">
                                @else
                                    <img src="https://placehold.co/400" alt="Profile Pic" class="rounded-circle"
                                        style="width:150px">
                                @endif
                            </div>
                            <div class="col">
                                <div class="card-body">
                                    <p class="fw-bold">{{ $user->name }}</p>
                                    <p class="card-text">{{ $user->email }}</p>
                                    <p class="card-text">Applied on: {{ $user->pivot->created_at }}</p>
                                </div>
                            </div>
                            <div class="col-auto align-self-center align-right">
                                <form action="{{ route('applicant.shortlist', [$listing->id, $user->id]) }}" method="POST">
                                    @csrf
                                    <a href="{{ Storage::url($user->resume) }}" target="_blank"
                                        class="btn btn-primary">Download
                                        Resume</a>
                                    <button type="submit"
                                        class="{{ $user->pivot->shortlisted ? 'btn btn-success' : 'btn btn-dark' }}">
                                        {{ $user->pivot->shortlisted ? 'Shortlisted' : 'Shortlist' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .card-bg {
            background-color: #235023;
            color: #fff;
        }
    </style>
@endsection
