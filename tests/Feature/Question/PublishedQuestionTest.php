<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, post, put};

it('should publish a question', function () {
    $user = User::factory()->create();
    actingAs($user);

    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);

    put(route('question.publish', $question))
    ->assertRedirect();

    expect($question->fresh())->draft->toBeFalse();
});

it('should make shure that the question is published', function () {
    $ownerUser   = User::factory()->create();
    $unkanonUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $ownerUser]);

    actingAs($unkanonUser);
    put(route('question.publish', $question))
    ->assertForbidden();

    actingAs($ownerUser);
    put(route('question.publish', $question))
    ->assertRedirect();
});
