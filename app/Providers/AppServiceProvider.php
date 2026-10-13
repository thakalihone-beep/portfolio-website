<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        try {
            $profile = Profile::query()->first();
        } catch (\Throwable) {
            $profile = null;
        }

        View::share('profile', $profile ?? new Profile([
            'name' => 'RoshanGauchan',
            'headline' => 'Software Engineer & AI Builder',
            'bio' => 'I build thoughtful digital experiences, intelligent applications and software that turns ambitious ideas into reality.',
        ]));
    }
}
