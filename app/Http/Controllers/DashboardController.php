<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $questions = Question::query()
            ->when(request()->search, fn ($query, $search) => $query->where('question', 'like', '%' . $search . '%'))
            ->withSum('votes', 'like')
            ->withSum('votes', 'unlike')
            ->orderByRaw('
                case when votes_sum_like is null then 0 else votes_sum_like end desc,
                case when votes_sum_unlike is null then 0 else votes_sum_unlike end
            ')
            ->paginate();

        return view('dashboard', compact('questions'));
    }
}
