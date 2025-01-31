<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapFineAdRoutes();

        $this->mapLoginUserRoutes();

        $this->mapLoginUserApiRoutes();

        $this->mapTellerRoutes();

        $this->mapModelTownPSORoutes();

        $this->mapMasterRoutes();

        $this->mapStudentRoutes();
        $this->mapAdminRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapLoginUserRoutes()
    {
        Route::middleware('login_users')
            ->namespace($this->namespace)
            ->group(base_path('routes/login_users.php'));
    }
    protected function mapMasterRoutes()
    {
        Route::middleware('web')
            ->as('master.')
            ->prefix('master')
            ->namespace($this->namespace . '\Master')
            ->group(base_path('routes/master.php'));
    }
    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->as('admin.')
            ->prefix('admin')
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }
    protected function mapStudentRoutes()
    {
        Route::middleware('web')
            ->as('student.')
            ->prefix('student')
            ->namespace($this->namespace . '\Student')
            ->group(base_path('routes/student.php'));
    }

    protected function mapLoginUserApiRoutes()
    {
        Route::prefix('desktop_api')
            ->middleware('login_users_api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/login_users_api.php'));
    }

    protected function mapFineAdRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/fine_ad.php'));
    }


    protected function mapTellerRoutes()
    {
        Route::middleware('teller')
            ->namespace($this->namespace)
            ->group(base_path('routes/teller.php'));
    }

    protected function mapModelTownPSORoutes()
    {
        Route::middleware('model_town_pso')
            ->namespace($this->namespace)
            ->group(base_path('routes/model_town_pso.php'));
    }
}
