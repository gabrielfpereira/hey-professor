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

it('should order the questions results for like and unlike votes', function () {
    $user       = User::factory()->create();
    $secondUser = User::factory()->create();

    Question::factory(5)->create();

    $mostLikeQuestion   = Question::find(3);
    $mostUnlikeQuestion = Question::find(1);

    $user->like($mostLikeQuestion);
    $secondUser->unlike($mostUnlikeQuestion);

    actingAs($user);

    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) use ($mostLikeQuestion, $mostUnlikeQuestion) {
            expect($questions)
                ->first()->id
                ->toBe($mostLikeQuestion->id)
            ->and($questions)
                ->last()->id
                ->toBe($mostUnlikeQuestion->id);

            return true;
        });
});
