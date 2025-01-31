<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckLogin::class,

//        \App\Http\Middleware\TrustProxies::class,
//        \App\Http\Middleware\SessionTimeOut::class,

//        \PragmaRX\Tracker\Vendor\Laravel\Middlewares\Tracker::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'login_users' => [
            'web',
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\CheckRole\CheckAccountantRole::class,
        ],

        'login_users_api' => [
            'web',
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\CheckRole\CheckAccountantRole::class,
        ],

        'teller' => [
            'web',
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\CheckRole\CheckTellerRole::class,
        ],

        'fine_ad' => [
            'web',
            \App\Http\Middleware\Authenticate::class,
        ],

        'model_town_pso' => [
            'web',
            \App\Http\Middleware\Authenticate::class,
        ],

        'api' => [
//            'bindings',
//            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
//            \Illuminate\Session\Middleware\StartSession::class, // Add this line
//            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Optional for error handling

        ],

        'basicPackage'=>[
            \App\Http\Middleware\Packages\BasicPackage::class,
        ],
        'advancePackage'=>[
            \App\Http\Middleware\Packages\AdvancePackage::class,
        ],
        'premiumPackage'=>[
            \App\Http\Middleware\Packages\PremiumPackage::class,
        ],
        'dayEnd'=>[
            \App\Http\Middleware\DayEnd::class,
        ],
        'checkUser'=>[
            \App\Http\Middleware\CheckUser\CheckUserStatus::class,
        ],
        'checkEmployee'=>[
            \App\Http\Middleware\CheckUser\EmployeeStatus::class,
        ],
        'superAdmin'=>[
            \App\Http\Middleware\Packages\SuperAdmin::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        'check.login' => \App\Http\Middleware\CheckLogin::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
