@extends('layouts.admin.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 mt-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Job Listings
                    </div>

                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created At</th>
                                    <th>Total Applicants</th>
                                    <th>View Job</th>
                                    <th>View Applicants</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listings as $listing)
                                    <tr>
                                        <td>{{ $listing->title }}</td>
                                        <td>{{ $listing->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $listing->users->count() }}</td>
                                        <td>View</td>
                                        <td><a href="{{ route('applicant.show', $listing->slug) }}">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
