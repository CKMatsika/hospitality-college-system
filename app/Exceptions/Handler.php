<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Log exceptions
            if ($this->shouldReport($e)) {
                logger()->error($e->getMessage(), [
                    'exception' => $e,
                    'url' => request()->fullUrl(),
                    'user' => auth()->user()?->id,
                ]);
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        // Handle validation exceptions
        if ($exception instanceof ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $exception->errors(),
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($exception->errors())
                ->withInput();
        }

        // Handle not found exceptions
        if ($exception instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Resource not found.',
                ], 404);
            }
            
            return response()->view('errors.404', [], 404);
        }

        // Handle access denied exceptions
        if ($exception instanceof AccessDeniedHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Access denied.',
                ], 403);
            }
            
            return response()->view('errors.403', [], 403);
        }

        // Handle general exceptions
        if ($request->expectsJson()) {
            return response()->json([
                'message' => config('app.debug') ? $exception->getMessage() : 'Server error.',
                'errors' => config('app.debug') ? [
                    'exception' => get_class($exception),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace(),
                ] : [],
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
