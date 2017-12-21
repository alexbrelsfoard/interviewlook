<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class WelcomeController extends Controller
{
    public function index()
    {
        $available_titles = Job::getDistinctTitles();
        $job_types = Job::$types;
        return view('look.index', compact('available_titles', 'job_types'));
    }
}
