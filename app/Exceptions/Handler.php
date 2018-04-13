<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (config('app.debug')) {
            return parent::render($request, $e);
        }
        return $this->handle($request, $e);
    }


    private function handle($request, Exception $e)
    {
        if($e instanceof ModelNotFoundException) {
            $data = array_merge([
                'id' => 'not_found',
                'status' => '405'
            ], config('errors.not_found'));

            $status = 405;
        } else if($e instanceof ValidationException) {

            $data = collect();
            foreach($e->validator->messages()->messages() as $key => $error)
            {
                $a = collect();
                $a->put('id', 'validation_error');
                $a->put('status', '422');
                $a->put('title', $key);
                $a->put('detail', $error[0]);
                $data->push($a);
            }
            $data = $data->toArray();
            $status = 422;

        } else if($e instanceof NoTienePermisoARutaException) {

            $data = array_merge([
                'id'     => 'forbidden',
                'status' => '403'
            ], config('errors.forbidden'));

            $status = 403;

        } else if($e instanceof NoTieneAccesoAEstaObraSocialException) {

            $data = array_merge([
                'id'     => 'obra_social_erronea',
                'status' => '403'
            ], config('errors.obra_social_erronea'));

            $status = 403;

        }else {
            $data = array_merge([
                'id'     => 'error_sistema',
                'status' => '500'
            ], config('errors.error_sistema'));

            $status = 500;
        }

        return response()->json($data, $status);
    }
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
