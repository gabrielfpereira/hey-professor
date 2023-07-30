<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete};

it('should make shure that the question is destroyed', function () {
    $ownerUser   = User::factory()->create();
    $unkanonUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $ownerUser]);

    actingAs($unkanonUser);
    delete(route('question.destroy', $question))
    ->assertForbidden();

    actingAs($ownerUser);
    delete(route('question.destroy', $question))
    ->assertRedirect();

    assertDatabaseMissing('questions', ['id' => $question->id]);
});
