<?php

namespace App\Providers;

use App\View\Components\PlantId\Error;
use App\View\Components\PlantId\OrganSelect;
use App\View\Components\PlantId\Photo;
use App\View\Components\PlantId\Score;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::components([
            'photo' => Photo::class,
            'organ' => OrganSelect::class,
            'score' => Score::class,
        ], 'tree');
    }
}
