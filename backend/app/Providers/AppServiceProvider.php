<?php

namespace App\Providers;

use App\Repositories\AssuntoRepository;
use App\Repositories\AutorRepository;
use App\Repositories\Contracts\AssuntoRepositoryContract;
use App\Repositories\Contracts\AutorRepositoryContract;
use App\Repositories\Contracts\LivroRepositoryContract;
use App\Repositories\LivroRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AutorRepositoryContract::class, AutorRepository::class);
        $this->app->bind(AssuntoRepositoryContract::class, AssuntoRepository::class);
        $this->app->bind(LivroRepositoryContract::class, LivroRepository::class);
    }

    public function boot(): void {}
}
