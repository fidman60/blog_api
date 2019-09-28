<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryImpl;
use App\Repositories\FavoriteRepository;
use App\Repositories\FavoriteRepositoryImpl;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryImpl;
use App\Repositories\ReactionRepository;
use App\Repositories\ReactionRepositoryImpl;
use App\Repositories\ResponseRepository;
use App\Repositories\ResponseRepositoryImpl;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryImpl;
use App\Services\SocialUserResolver;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
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
        $this->app->bind(PostRepository::class, PostRepositoryImpl::class);
        $this->app->bind(FavoriteRepository::class, FavoriteRepositoryImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(CommentRepository::class, CommentRepositoryImpl::class);
        $this->app->bind(ResponseRepository::class, ResponseRepositoryImpl::class);
        $this->app->bind(ReactionRepository::class, ReactionRepositoryImpl::class);
        $this->app->bind(SocialUserResolverInterface::class, SocialUserResolver::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
