<?php

use App\Models\User;
use Tests\Feature\Utils\UserTestUtils;

it('returns users without filters', function () {
    User::factory(5)->create();
    $response = authedUser()->getJson(apiRoute('users'));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => UserTestUtils::userResponse(),
        ],
    ]);
});

it('returns users with name filter', function () {
    User::factory()->create(['name' => 'laravel-starter']);

    authedUser()->getJson(apiRoute('users?filter[name]=laravel'))
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                0 => [
                    'name' => 'laravel-starter',
                ],
            ],
        ]);
});

it('returns users with email filter', function () {
    User::factory()->create(['email' => 'laravel@starter.com']);

    authedUser()->getJson(apiRoute('users?filter[email]=starter'))
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                0 => [
                    'email' => 'laravel@starter.com',
                ],
            ],
        ]);
});

it('returns 400 bad request when passing wrong filters', function () {
    User::factory()->create(['name' => 'laravel-starter']);

    authedUser()->getJson(apiRoute('users?filter[non_existing]=laravel'))
        ->assertStatus(400)
        ->assertJson(['message' => 'Requested filter(s) `non_existing` are not allowed. Allowed filter(s) are `id, name, email`.']);
});

it('returns empty users when no records matches in the DB', function () {
    User::factory(5)->create();

    authedUser()->getJson(apiRoute('users?filter[name]=2454352345435'))
        ->assertStatus(200)
        ->assertJson([
            'data' => [],
        ]);
});

it('returns all users', function () {
    User::factory(5)->create();
    authedUser()->getJson(apiRoute('users/all'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => UserTestUtils::userResponse(),
            ],
        ]);
});

it('returns active users', function () {
    User::factory(5)->create();

    authedUser()->getJson(apiRoute('users/active'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => UserTestUtils::userResponse(),
            ],
        ]);
});

it('shows a user by id', function () {
    $user = User::factory(1)->create()->first();

    authedUser()->getJson("/api/v1/users/$user->id")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => UserTestUtils::userResponse(),
        ])
        ->assertJson([
            'data' => UserTestUtils::matchUserResponse($user),
        ]);
});

it('returns not found if not user exist with the given id', function () {
    authedUser()
        ->getJson('/api/v1/users/352465')
        ->assertNotFound();
});

it('creates new user', function () {
    $user = User::factory()->make()->makeVisible('password');

    $response = authedUser()->postJson('/api/v1/users', $user->toArray());
    $createdUser = $response->original['data'];

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => UserTestUtils::userResponse(),
        ])
        ->assertJson([
            'data' => UserTestUtils::matchUserResponse($createdUser),
        ]);

    $this->assertDatabaseHas('users', ['id' => $createdUser['id']]);
});

it('returns 422 when no user name provided', function () {
    $user = User::factory()->make(['name' => null])->makeVisible('password');

    authedUser()->postJson('/api/v1/users', $user->toArray())
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);
});

it('returns 422 when no user email provided', function () {
    $user = User::factory()->make(['email' => null])->makeVisible('password');

    authedUser()->postJson('/api/v1/users', $user->toArray())
        ->assertStatus(422)
        ->assertJsonValidationErrorFor('email');
});

it('returns 422 when no user password provided', function () {
    $user = User::factory()->make();

    authedUser()->postJson('/api/v1/users', $user->toArray())
        ->assertStatus(422)
        ->assertJsonValidationErrorFor('password');
});

it('updates an existing user', function () {
    $user = User::factory()->create()->first();
    $user->name = 'laravel-starter-updated';

    authedUser()
        ->putJson("/api/v1/users/$user->id", $user->toArray())
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => UserTestUtils::userResponse(),
        ])
        ->assertJson([
            'data' => UserTestUtils::matchUserResponse($user),
        ]);

    $this->assertDatabaseHas('users', ['name' => $user['name']]);
});

it('deletes an existing user', function () {
    $user = User::factory()->create()->first();

    authedUser()
        ->deleteJson("/api/v1/users/$user->id")
        ->assertNoContent();

    $this->assertDatabaseMissing('users', ['id' => $user['id']]);
});
