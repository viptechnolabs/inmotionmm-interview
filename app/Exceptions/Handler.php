<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;


class Handler extends ExceptionHandler
{
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
    }

    public function render($request, \Exception|Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($this->isHttpException($exception)) {
                return response()->json(['error' => $exception->getMessage()], 404);
            }
            return response()->json(['error' => 'Internal Server Error',
                'status' => false], 500);
        }

        return parent::render($request, $exception);
    }
}
