<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isPremiumUser;
use App\Http\Requests\JobEditFormRequest;
use App\Http\Requests\JobPostFormRequest;
use App\Models\Listing;
use App\Post\JobPost;
use Illuminate\Support\Str;
//use Illuminate\Http\Request;

class PostJobController extends Controller
{

    protected $job;
    public function __construct(JobPost $job)
    {
        $this->job = $job;
        $this->middleware('auth');
        $this->middleware(isPremiumUser::class)->only(['create', 'store', 'edit', 'delete']);
    }

    public function index()
    {
        $listings = Listing::where('user_id', auth()->user()->id)->get();
        return view('job.index', compact('listings'));
    }
    public function create()
    {
        return view('job.create');
    }

    public function store(JobPostFormRequest $request)
    {
        $this->job->store($request);
        return back()->with('success', 'Job posted successfully');
    }

    public function edit(Listing $listing)
    {
        return view('job.edit', compact('listing'));
    }

    public function update($id, JobEditFormRequest $request)
    {
        $this->job->updatePost($id, $request);
        return back()->with('success', 'Job updated successfully');
    }

    public function destroy($id)
    {
        $this->job->deletePost($id);

        return back()->with('success', 'Job deleted successfully');
    }
}
