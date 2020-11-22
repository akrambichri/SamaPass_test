<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Salary;
use Illuminate\Support\Facades\Schema;
use App\Notifications\SalaryConfirmation;

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
        Schema::defaultStringLength(191);

        Salary::created(function ($salary){
            retry(5, function() use ($salary){
                $salary->notify(new SalaryConfirmation($salary));
            },100);
        });
    }
}
