<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able update question in database', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);
    put(route('question.update', $question), [
        'question' => 'Updated Question ?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)->question->toBe('Updated Question ?');
});

it('should be able only the question creator can update question', function () {
    $ownerUser   = User::factory()->create();
    $unkanonUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $ownerUser]);

    actingAs($unkanonUser);
    put(route('question.update', $question), ['question' => 'Updated Question ?'])
    ->assertForbidden();

    actingAs($ownerUser);
    put(route('question.update', $question), ['question' => 'Updated Question ?'])
    ->assertRedirect();
});
