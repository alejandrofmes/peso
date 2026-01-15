<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    public function render($request, Throwable $exception)
    {
        Log::error('Exception occurred:', [
            'exception' => $exception,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        if ($exception instanceof ThrottleRequestsException) {
            // Redirect back with error message
            return redirect()->back()->with('error', __('You have requested too many verification emails. Please try again in a few minutes.'));
        }

        // Handle 404 errors
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('error.404', [], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->view('error.404', [], 404);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->view('error.404', [], 404);
        }

        // Handle other types of exceptions
        // return response()->view('error.404', [], 404);

        return parent::render($request, $exception);
    }

    // /**
    //  * Render the exception into an HTTP response.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @param \Throwable $exception
    //  * @return \Illuminate\Http\Response
    //  */
    // public function render($request, Throwable $exception)
    // {
    //     // Handle 404 errors
    //     if ($exception instanceof NotFoundHttpException) {
    //         return response()->view('error.404', [], 404);
    //     }

    //     // Handle other types of exceptions
    //     return response()->view('error.404', [], 404);
    // }
}
