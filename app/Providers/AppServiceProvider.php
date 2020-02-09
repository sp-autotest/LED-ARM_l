<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\AdminCompany;
use App\Accounts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         \Blade::setEchoFormat('nl2br(e(%s))');
        view()->composer('*', function($view) {
            $user = Auth::user();
            if ($user && $user->id) {
                $myCompany = AdminCompany::where('id', '=', $user->getAttribute('company_id'))->first();
                $companyName = $myCompany->getAttribute('company_name');
                $profile = Profile::where('user_id', '=', $user->id)->first();
                $account = Accounts::where('company_registry_id', '=', intval($myCompany->getAttribute('id')))->first();
                if ($account) {
                    $balance = $account->getAttribute('balance');
                } else {
                    $balance = 0;
                }

                View::share('profile', $profile);
                View::share('myCompanyName', $companyName);
                View::share('balance', $balance);
            }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
