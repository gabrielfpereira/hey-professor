<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('should creating a question bigger than 255 characters ', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('a', 260) . '?',
    ]);

    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('a', 260) . '?']);
});

it('should be able create a question with draft', function () {
    $user = User::factory()->create();
    actingAs($user);

    post(route('question.store'), [
        'question' => str_repeat('a', 260) . '?',
    ]);

    assertDatabaseHas(
        'questions',
        [
            'question' => str_repeat('a', 260) . '?',
            'draft'    => true,
        ]
    );
});

it('should have end with a question mark', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('a', 10),
    ]);

    $request->assertSessionHasErrors('question', 'question must end with a question mark');
    assertDatabaseCount('questions', 0);
});

it('should have minimum 10 characters', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('a', 8) . '?',
    ]);

    $request->assertSessionHasErrors('question', __('validation.min.string', ['min' => 10, 'atribute' => 'question']));
    assertDatabaseCount('questions', 0);
});

test('only user authenticated can create a question', function () {

    post(route('question.store'), [
        'question' => str_repeat('a', 260) . '?',
    ])->assertRedirect(route('login'));

});

it('questions should be unique', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['question' => 'this is a question?']);

    actingAs($user);
    post(route('question.store', ), [
        'question' => 'this is a question?',
    ])
        ->assertSessionHasErrors(['question' => 'this questions already exists']);
});
