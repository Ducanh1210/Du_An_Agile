<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        \Illuminate\Support\Facades\Gate::define('manage-news', function ($user) {
            return in_array($user->role, ['admin', 'staff', 'content_admin']);
        });

        \Illuminate\Support\Facades\Gate::define('create-news', function ($user) {
            return in_array($user->role, ['admin', 'content_admin']);
        });

        \Illuminate\Support\Facades\Gate::define('edit-news', function ($user, $news = null) {
            if ($user->role === 'admin') return true;
            if ($user->role === 'content_admin') {
                return $news ? $user->id === $news->author_id : true;
            }
            return false;
        });

        \Illuminate\Support\Facades\Gate::define('delete-news', function ($user) {
            return $user->role === 'admin';
        });
    }
}
