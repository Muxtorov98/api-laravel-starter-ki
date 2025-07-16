<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            }
        });

        $this->renderable(function (TokenExpiredException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->errorResponse('Token has expired', Response::HTTP_UNAUTHORIZED);
            }
        });

        $this->renderable(function (TokenInvalidException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->errorResponse('Token is invalid', Response::HTTP_UNAUTHORIZED);
            }
        });

        $this->renderable(function (JWTException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->errorResponse('Token is not provided', Response::HTTP_UNAUTHORIZED);
            }
        });

        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->validator->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });
    }
}
