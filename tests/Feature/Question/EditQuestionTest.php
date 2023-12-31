<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able open edit question page', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))
        ->assertSuccessful()
        ->assertViewIs('questions.edit');
});

it('should make shure only draft questions can be edited', function () {
    $user          = User::factory()->create();
    $draftQuestion = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    $question      = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    actingAs($user);
    get(route('question.edit', $draftQuestion))->assertSuccessful();
    get(route('question.edit', $question))->assertForbidden();
});

it('should make shure that the question is editable by the user', function () {
    $ownerUser   = User::factory()->create();
    $unkanonUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $ownerUser]);

    actingAs($unkanonUser);
    get(route('question.edit', $question))
    ->assertForbidden();

    actingAs($ownerUser);
    get(route('question.edit', $question))
    ->assertSuccessful();

});
