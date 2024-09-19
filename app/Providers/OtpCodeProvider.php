<?php

namespace App\Providers;

use App\Interfaces\OtpCodeInterface;
use App\Repositories\OtpCodeRepository;
use Illuminate\Support\ServiceProvider;

class OtpCodeProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OtpCodeInterface::class, OtpCodeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
