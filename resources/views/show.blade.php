@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{ Storage::url($listing->feature_image) }}" alt="Job Image" class="card-img-top">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    <div class="card-body">
                        <div class="card-title">
                            <h1>{{ $listing->title }}</h1>
                        </div>
                        <span class="badge bg-primary">{{ $listing->job_type }}</span>
                        <p>Salary: £{{ number_format($listing->salary, 2) }}</p>
                        <p>Address: {{ $listing->address }}</p>

                        <h4 class="mt-4">Job Description</h4>
                        <p class="card-text">{!! $listing->description !!}</p>

                        <h4 class="mt-4">Job Responsibilities</h4>
                        <p class="card-text">{!! $listing->roles !!}</p>

                        <p class="card-text mt-4">Application Closing Data: {{ $listing->application_close_date }}</p>
                        {{-- check if the job is already applied by the user --}}


                        @if (Auth::check())
                            @if (auth()->user()->resume)
                                <form action="{{ route('application.submit', [$listing->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-4">Apply Now</button>
                                </form>
                            @else
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Apply Now
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary mt-4">Login to Apply</a>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <form action="{{ route('application.submit', [$listing->id]) }}" method="post">
                                @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Resume</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" class="form-control" name="resume">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
