<?php

namespace Tests\Feature\Utils;

use App\Models\User;

class UserTestUtils
{
    public static function userResponse(): array
    {
        return [
            'id',
            'name',
            'email',
            'created_at',
        ];
    }

    public static function matchUserResponse(User|array $user): array
    {
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];
    }
}
