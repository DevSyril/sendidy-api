<?php

namespace App\Providers;

use App\Interfaces\GroupMemberInterface;
use App\Repositories\GroupMemberRepository;
use Illuminate\Support\ServiceProvider;

class GroupMemberServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GroupMemberInterface::class, GroupMemberRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
