<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\{Question, User, Vote};
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request): \Illuminate\Http\RedirectResponse
    {
        Question::query()->create(
            array_merge(
                $request->all(),
                [
                    'draft'      => true,
                    'created_by' => auth()->user()->id,
                ]
            )
        );

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }

    public function like(Question $question): RedirectResponse
    {
        /** @var User $user  */
        $user = auth()->user();

        $user->like($question);

        return redirect()->back();
    }

    public function unlike(Question $question): RedirectResponse
    {
        /** @var User $user  */
        $user = auth()->user();

        $user->unlike($question);

        return redirect()->back();
    }

    public function publish(Question $question): RedirectResponse|Response
    {
        $this->authorize('publish', $question);

        $question->update(['draft' => false]);

        return redirect()->back();
    }
}
