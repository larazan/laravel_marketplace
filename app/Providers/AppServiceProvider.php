<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
        Str::macro('readDuration', function(...$text) {
            // $totalWords = str_word_count(implode(" ", $text));
            // $minutesToRead = round($totalWords / 200);
        
            // return (int)max(1, $minutesToRead);

            $totalWords = str_word_count(implode(' ', $text));

            $minutes = ceil($totalWords / 200);
            $minutes = max(1, $minutes);

            return ($minutes > 1) ? $minutes . ' minutes' : $minutes . ' minute';
        });

        // Carbon::setLocale(config('app.locale'));
        // config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
    }
}
