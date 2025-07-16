<?php

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\Feature\Utils\UserTestUtils;

use function Pest\Laravel\postJson;

function loginUser(): TestResponse
{
    $user = User::factory()->create([
        'email' => 'laravel-user@starter.test',
        'password' => bcrypt('password'),
    ]);

    return postJson(apiRoute('auth/login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);
}

it('registers new user successfully', function () {
    $this->postJson(apiRoute('auth/register'), [
        'name' => 'laravel-starter-user',
        'email' => 'laravel-user@starter.test',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'user',
                'token',
                'token_type',
            ],
        ]);
});

it('login user with credentials successfully', function () {
    $response = loginUser();

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'user' => UserTestUtils::matchUserResponse($response->json()['data']['user']),
            ],
        ])
        ->assertJsonStructure([
            'data' => [
                'user',
                'token',
                'token_type',
            ],
        ]);
});

it('gets the authenticated user data', function () {
    $user = User::factory()->create();

    authedUser($user)->getJson(apiRoute('auth/me'))
        ->assertStatus(200)
        ->assertJson([
            'data' => UserTestUtils::matchUserResponse($user),
        ])
        ->assertJsonStructure([
            'data' => UserTestUtils::userResponse(),
        ]);
});

it('returns refresh token', function () {
    $response = loginUser();

    authedUser()->withToken($response->original['data']['token'])
        ->getJson(apiRoute('auth/refresh'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'token',
                'token_type',
            ],
        ]);
});

it('logouts the authenticated user', function () {
    $response = loginUser();

    authedUser()->withToken($response->original['data']['token'])
        ->getJson(apiRoute('auth/logout'))
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'message' => 'Successfully logged out',
            ],
        ])
        ->assertJsonStructure([
            'data' => [
                'message',
            ],
        ]);
});
