<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    public function register(array $data): array;

    public function login(array $credentials): array;

    public function me(): Authenticatable;

    public function refresh(): string;

    public function logout(): bool;
}
