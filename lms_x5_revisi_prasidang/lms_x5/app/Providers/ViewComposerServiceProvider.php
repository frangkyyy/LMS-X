<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MDLCourse;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $courses = MDLCourse::where('visible', 1)->get();
            $view->with('courses', $courses);
        });
    }
}
