<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, post, put};

it('should publish a question', function () {
    $user = User::factory()->create();
    actingAs($user);

    $question = Question::factory()->create(['draft' => true]);

    put(route('question.publish', $question))
    ->assertRedirect();

    expect($question->fresh())->draft->toBeFalse();
});
