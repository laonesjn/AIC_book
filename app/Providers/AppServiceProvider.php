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
                'pendingArchivesCount'           => \App\Models\Archive::where('status', 'pending')->count(),
                'pendingCollectionRequestsCount' => \App\Models\CollectionAccessRequest::where('status', 'pending')->count(),
                'pendingHeritageRequestsCount'   => \App\Models\HeritageCollectionAccessRequest::where('status', 'pending')->count(),
                'pendingOrdersCount'             => \App\Models\RequestAccess::whereIn('status', ['pending', 'Pending'])->count(),
                'pendingEnquiriesCount'          => \App\Models\Enquiry::where('status', 'Pending')->count(),
            ]);
        });
    }
}