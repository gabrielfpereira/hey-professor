<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    $user = User::factory()->create();
    actingAs($user);

    $questions = Question::factory(5)->create();

    $response = get(route('dashboard'));

    foreach ($questions as $question) {
        $response->assertSee($question->question);
    }
});

it('should paginate the questions results', function () {
    $user = User::factory()->create();
    actingAs($user);

    Question::factory(20)->create();

    get(route('dashboard'))
        ->assertViewHas('questions', function ($value) {
            return $value instanceof \Illuminate\Pagination\LengthAwarePaginator;
        });
});
