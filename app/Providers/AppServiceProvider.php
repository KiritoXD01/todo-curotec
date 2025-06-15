<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Adding defaults to Passwords
        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->environment('production')
                ? $rule->mixedCase()->uncompromised()
                : $rule;
        });

        // Prevents Lazy loading
        Model::handleLazyLoadingViolationUsing(function (Model $model, string $relation) {
            $class = Model::class;

            info("Attempted to lazy load [{$relation}] on model [{$class}].");
        });
    }
}
