<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('layouts.errors.404', [], 404);
        } elseif ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            
            return response()->view(
                'layouts.errors.403',
                ['error' => 'Sorry, this page is restricted to authorized users only.'],
                403
            );
        } elseif ($exception instanceof HttpException) {
            Log::info($exception->getMessage());
            return response()->view('layouts.errors.503', ['error' => $exception->getTrace()], 500);
        } else if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->view(
                'layouts.errors.403',
                ['error' => 'Sorry, this page is restricted to authorized users only.'],
                422
            );
        }

        return parent::render($request, $exception);
    }
}
