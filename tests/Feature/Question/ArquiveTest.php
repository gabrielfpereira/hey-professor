<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted, put};

it('should archive question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.archive', $question))
        ->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question->fresh())->deleted_at->not->toBeNull();
});

it('should make sure that only the creator can archive a question', function () {
    $ownerUser   = User::factory()->create();
    $unkanonUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $ownerUser]);

    actingAs($unkanonUser);
    put(route('question.archive', $question))
    ->assertForbidden();

    actingAs($ownerUser);
    put(route('question.archive', $question))
    ->assertRedirect();

});

it('should be able to restore a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
                    ->for($user, 'createdBy')
                    ->create([
                        'draft' => true,
                    ]);
    $question->delete();
    actingAs($user);

    put(route('question.restore', $question))
        ->assertRedirect();

    assertNotSoftDeleted('questions', ['id' => $question->id]);

    expect($question->fresh())->deleted_at->toBeNull();
});
