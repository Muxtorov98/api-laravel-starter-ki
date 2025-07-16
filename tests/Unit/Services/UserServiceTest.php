<?php

use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\Concretes\UserService;

beforeEach(function () {
    $this->repository = mock(UserRepositoryInterface::class);
    $this->userService = new UserService($this->repository);
});

it('retrieves all filtered users', function () {
    User::factory(5)->create();
    $users = User::query()->paginate();

    $this->repository
        ->shouldReceive('paginateFiltered')
        ->once()
        ->andReturn($users);

    $response = $this->userService->getFilteredUsers();

    $this->assertEquals($users, $response);
});

it('retrieves all users', function () {
    $users = User::factory(5)->create();

    $this->repository
        ->shouldReceive('all')
        ->once()
        ->andReturn($users);

    $response = $this->userService->getAllUsers();

    $this->assertEquals($users, $response);
    $this->assertCount(5, $response);
});

it('invoke get users method', function () {

    $users = User::factory(5)->make();

    $this->repository
        ->shouldReceive('getFiltered')
        ->once()
        ->andReturn($users);

    $response = $this->userService->getUsers();

    $this->assertEquals($users, $response);
});

it('fetches user by id', function () {
    $user = User::factory()->make(['id' => 1]);

    $this->repository
        ->shouldReceive('findOrFail')
        ->once()
        ->with(1)
        ->andReturn($user);

    $result = $this->userService->getUserById(1);

    expect($result)->toBeInstanceOf(User::class)
        ->and($result->id)->toBe(1);
});

it('stores a new user', function () {
    $user = User::factory()->make()->makeVisible(['password']);

    $this->repository
        ->shouldReceive('create')
        ->with($user->toArray())
        ->once()
        ->andReturn($user);

    $response = $this->userService->createUser($user->toArray());

    $this->assertEquals($user, $response);
    expect($response)
        ->toBeInstanceOf(User::class)
        ->and($response->name)->toBe($user->name);
});

it('updates user by id', function () {
    $user = User::factory()->make([
        'id' => 1,
        'name' => 'updated-name',
    ]);

    $this->repository
        ->shouldReceive('update')
        ->once()
        ->with(1, ['name' => 'updated-name'])
        ->andReturn($user);

    $response = $this->userService->updateUser(1, ['name' => 'updated-name']);

    expect($response)
        ->toBeInstanceOf(User::class)
        ->and($response->name)->toBe('updated-name');
});

it('deletes user by id', function () {
    $user = User::factory()->make(['id' => 1]);

    $this->repository
        ->shouldReceive('delete')
        ->once()
        ->with(1)
        ->andReturn(true);

    $response = $this->userService->deleteUser(1);

    expect($response)->toBeTrue();
});
