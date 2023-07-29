<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able list all questions created by a user', function () {
    $ownerUser   = User::factory()->create();
    $unkanonUser = User::factory()->create();

    $ownerQuestion   = Question::factory()->for($ownerUser, 'createdBy')->count(10)->create();
    $unkanonQuestion = Question::factory()->for($unkanonUser, 'createdBy')->count(10)->create();

    actingAs($ownerUser);
    $response = get(route('question.index'));

    foreach ($ownerQuestion as $question) {
        $response->assertSee($question->question);
    }

    foreach ($unkanonQuestion as $question) {
        $response->assertDontSee($question->question);
    }
});
