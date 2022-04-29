<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Product;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-product', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('delete-product', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('update-product-image', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('add-product-image', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('delete-product-image', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });
    }
}
