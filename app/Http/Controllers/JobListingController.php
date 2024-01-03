<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $salary = $request->query('sort');
        $date = $request->query('date');
        $jobType = $request->query('type');

        $listings = Listing::query();
        if ($salary === 'salary_high_to_low') {
            $listings->orderBy('salary', 'desc');
        } elseif ($salary === 'salary_low_to_high') {
            $listings->orderBy('salary', 'asc');
        }

        if ($date === 'latest') {
            $listings->orderBy('created_at', 'desc');
        } elseif ($date === 'oldest') {
            $listings->orderBy('created_at', 'asc');
        }

        if ($jobType === 'full_time') {
            $listings->where('type', 'Full Time');
        } elseif ($jobType === 'part_time') {
            $listings->where('type', 'Part Time');
        } elseif ($jobType === 'casual') {
            $listings->where('type', 'Casual');
        }

        $jobListing = $listings->with('profile')->get();
        return view('home', compact('jobListing'));
    }

    public function show(Listing $listing)
    {
        return view('show', compact('listing'));
    }
}
