<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $questions = Question::withSum('votes', 'like')->withSum('votes', 'unlike')->get();

        return view('dashboard', compact('questions'));
    }
}
