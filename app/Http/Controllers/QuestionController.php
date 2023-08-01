<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\{Question, User, Vote};
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        /**@var User $user */
        $user = auth()->user();

        $questions = $user->questions()->get();

        return view('questions.index', compact('questions'));
    }

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

        return redirect()->back();
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
    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreQuestionRequest $request, Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        $question->update(
            $request->all()
        );

        return redirect()->route('question.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return redirect()->back();
    }

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

    public function archive(Question $question): RedirectResponse|Response
    {
        $this->authorize('archive', $question);

        $question->delete();

        return redirect()->back();
    }

    public function restore(int $id): RedirectResponse|Response
    {
        $question = Question::withTrashed()->find($id);
        $this->authorize('archive', $question);

        $question->restore();

        return redirect()->back();
    }
}
