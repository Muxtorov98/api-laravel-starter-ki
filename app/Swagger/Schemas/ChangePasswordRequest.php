<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="ChangePasswordRequest",
 *      type="object",
 *      title="Change Password Request",
 *      required={"username", "password", "password_confirmation"},
 *      @OA\Property(
 *          property="username",
 *          type="string",
 *          description="User's username"
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          format="password",
 *          description="New password"
 *      ),
 *      @OA\Property(
 *          property="password_confirmation",
 *          type="string",
 *          format="password",
 *          description="New password confirmation"
 *      )
 * )
 */
class ChangePasswordRequest
{
}