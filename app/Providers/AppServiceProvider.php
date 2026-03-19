<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\News;
use App\Models\Archive;
use App\Models\CollectionAccessRequest;
use App\Models\HeritageCollectionAccessRequest;
use App\Models\RequestAccess;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Share pending counts with the admin layout
        View::composer('layouts.masteradmin', function ($view) {
            $view->with([
                'pendingArchivesCount'           => Archive::where('status', 'pending')->count(),
                'pendingCollectionRequestsCount' => CollectionAccessRequest::where('status', 'pending')->count(),
                'pendingHeritageRequestsCount'   => HeritageCollectionAccessRequest::where('status', 'pending')->count(),
                'pendingOrdersCount'             => RequestAccess::whereIn('status', ['pending', 'Pending'])->count(),
            ]);
        });
    }
}