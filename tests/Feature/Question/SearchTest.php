<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to seached a question', function () {
    $user          = User::factory()->create();
    $worngQuestion = Question::factory()->create(['question' => 'this is a question?']);
    $question      = Question::factory()->create(['question' => 'how are your day?']);

    actingAs($user);

    get(route('dashboard', ['search' => 'day']))
        ->assertSee($question->question)
        ->assertDontSee($worngQuestion->question);
});
