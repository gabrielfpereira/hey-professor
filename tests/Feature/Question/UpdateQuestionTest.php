<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs,  assertDatabaseCount,  assertDatabaseHas, put};

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

it('should update a question bigger than 255 characters ', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('a', 260) . '?',
    ]);

    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('a', 260) . '?']);
});

it('should have end with a question mark', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('a', 10),
    ]);

    $question->refresh();

    $request->assertSessionHasErrors('question', 'question must end with a question mark');
    assertDatabaseHas('questions', ['question' => $question->question]);
});

it('should have minimum 10 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('a', 8) . '?',
    ]);

    $question->refresh();

    $request->assertSessionHasErrors('question', __('validation.min.string', ['min' => 10, 'atribute' => 'question']));
    assertDatabaseHas('questions', ['question' => $question->question]);
});
