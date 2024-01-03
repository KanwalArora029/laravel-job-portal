@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <h1>Post a Job</h1>
                <form action="{{ route('job.store') }}" method="post" id="jobCreateFrom" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-4">
                        <label for="feature_image">Featured Image</label>
                        <input type="file" name="feature_image" id="feature_image" class="form-control">
                        @if ($errors->has('feature_image'))
                            <span class="text-danger">{{ $errors->first('feature_image') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label for="title">Job Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Enter job title">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label for="description">Job Description</label>
                        <textarea name="description" id="description" class="form-control summernote"></textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label for="roles">Roles & Responsibilities</label>
                        <textarea name="roles" id="roles" class="form-control summernote"></textarea>
                        @if ($errors->has('roles'))
                            <span class="text-danger">{{ $errors->first('roles') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label>Job Type</label>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="fulltime" class="form-check-input" value="Full Time">
                            <label for="fulltime" class="form-check-label">Fulltime</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="parttime" class="form-check-input" value="Part Time">
                            <label for="parttime" class="form-check-label">Parttime</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="casual" class="form-check-input" value="Casual">
                            <label for="casual" class="form-check-label">Casual</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="contract" class="form-check-input" value="Contract">
                            <label for="contract" class="form-check-label">Contract</label>
                        </div>
                        @if ($errors->has('job_type'))
                            <span class="text-danger">{{ $errors->first('job_type') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control">
                        @if ($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label for="salary">Salary</label>
                        <input type="text" name="salary" id="salary" class="form-control">
                        @if ($errors->has('salary'))
                            <span class="text-danger">{{ $errors->first('salary') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <label for="closingDate">Closing Date</label>
                        <input type="text" id="datepicker" name="closingDate" class="form-control">
                        @if ($errors->has('closingDate'))
                            <span class="text-danger">{{ $errors->first('closingDate') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Post a Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .note-insert {
            display: none !important;
        }
    </style>
@endsection
