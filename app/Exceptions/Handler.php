<?php
namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
//    protected $dontReport = [
//        //
//    ];
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
//    protected $dontFlash = [
//        'current_password',
//        'password',
//        'password_confirmation',
//    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'],401);
        }
        $guard='';
        if ($exception->guards()[0] != null){
            $guard = array_get($exception->guards(), 0);
        }




        if($guard == 'admin') {
            return redirect()->guest(route('admin.login_page'));
        }
        if($guard == 'master') {
            return redirect()->guest(route('master.login_page'));
        }
        if($guard == 'student') {
            return redirect()->guest(route('student.login_page'));
        }

        return redirect()->guest(route('login'));
//        if ($request->expectsJson()) {
//            return response()->json(['message' => 'Unauthenticated.'], 401);
//        }
//
//        if ($request->is('master') || $request->is('master/*')) {
//            return redirect()->guest('/master');
//        }
//
//        return redirect()->guest(route('login'));
    }
}
