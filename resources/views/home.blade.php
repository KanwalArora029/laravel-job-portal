@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4">
            <h4>Recommended Jobs</h4>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Salary
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['sort' => 'salary_high_to_low']) }}">
                            High to Low
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['sort' => 'salary_low_to_high']) }}">
                            Low to High
                        </a>
                    </li>
                </ul>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Date
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['date' => 'latest']) }}">
                            Latest
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['date' => 'oldest']) }}">
                            Oldest
                        </a>
                    </li>
                </ul>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Job Type
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'full_time']) }}">
                            Full Time
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'part_time']) }}">
                            Part Time
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'casual']) }}">
                            Casual
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 g1">
            @foreach ($jobListing as $job)
                <div class="col-md-3">
                    <div class="card p-2">
                        <div class="text-right "><small class="badge text-bg-info">{{ $job->job_type }}</small></div>
                        <div class="text-center mt-2 p-3">
                            @if ($job->profile->profile_pic)
                                <img src="{{ Storage::url($job->profile->profile_pic) }}" alt="Job Image"
                                    class="img-fluid rounded-circle" width="100">
                            @else
                                <img src="https://placehold.co/400" alt="Job Image" class="img-fluid rounded-circle"
                                    width="100">
                            @endif
                            <span class="d-block font-wight-bold">{{ $job->title }}</span>
                            <hr>
                            <div class="d-flex flex-row align-items-center justify-content-center">
                                <small class="ml-1">{{ $job->address }}</small>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <span>£{{ number_format($job->salary, 2) }}</span>
                                <a href="{{ route('job.show', $job->slug) }}">
                                    <button class="btn btn-sm btn-outline-dark">
                                        Apply Now
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
