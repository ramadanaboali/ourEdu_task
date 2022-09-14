<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\MissingScopeException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

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
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return response()->json(['success' => false,'message' => "Not Found",], 404);
        }
        if ($exception instanceof UnauthorizedHttpException || $exception instanceof UnauthorizedException) {
            return response()->json(['success' => false,'message' => "Un Authorized",], 401);
        }
        if ($exception instanceof MissingScopeException) {
            return response()->json(['success' => false,'message' => "Access Denied",], 403);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['success' => false,'message' => 'Method Not Allowed',], 404);
           }

        if ($exception instanceof ErrorException) {
            if (preg_match('/^file_put_contents/', $exception->getMessage())) {
                return;
            }
        }


        return parent::render($request, $exception);
    }
}
