<?php

namespace App\Providers;

use App\Models\Chapter;
use App\Models\Enrollment;
use App\Models\Subchapter;
use App\Models\User;
use App\Models\Workshop;
use App\Repositories\Eloquent\ChapterRepository;
use App\Repositories\Eloquent\EnrollmentRepository;
use App\Repositories\Eloquent\SubchapterRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\WorkshopRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class,fn() => new UserRepository(new User()));
        $this->app->bind(WorkshopRepository::class,fn() => new WorkshopRepository(new Workshop()));
        $this->app->bind(EnrollmentRepository::class,fn() => new EnrollmentRepository(new Enrollment()));
        $this->app->bind(ChapterRepository::class,fn() => new ChapterRepository(new Chapter()));
        $this->app->bind(SubchapterRepository::class,fn() => new SubchapterRepository(new Subchapter()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
