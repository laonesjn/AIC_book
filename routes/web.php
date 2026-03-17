<?php

use App\Http\Controllers\CollectionAccessRequestController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PdfDownloadController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionCategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HeritageCollectionCategoryController;
use App\Http\Controllers\HeritageCollectionController;
use App\Http\Controllers\HeritageCollectionAccessRequestController;
use App\Http\Controllers\ExhibitionCategoryController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffHistoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ComandTechController;
use App\Http\Controllers\ArchiveController;
use App\Models\Exhibition;
use App\Models\ExhibitionCategory;


/*
|--------------------------------------------------------------------------
| Client routes (redirect admin away)
|--------------------------------------------------------------------------
*/
Route::middleware(['redirect.admin'])->group(function () {
    //----------Client side Home
    Route::get('/', function () {return view('welcome');})->name('client.home');

    Route::get('/about', function () {return view('client.aboutus');})->name('client.about');




/*
|--------------------------------------------------------------------------
| Client Routes (Public Pages)
|--------------------------------------------------------------------------
*/
Route::get('/collection/{id}/view', [CollectionController::class, 'clientshow'])
    ->name('client.collectionshow');

Route::get('/collection/{id}/download', [CollectionController::class, 'downloadPdf'])
    ->name('collection.download');

Route::get('/discover-our-collection', [CollectionController::class, 'discoverOurCollection'])
    ->name('client.discoverourcollection');

Route::get('/archivecentre', [CollectionController::class, 'getAllMasterCategoriesWithCollectionCount'])
    ->name('client.archivecentrecollection');


    /*
|--------------------------------------------------------------------------
| Client Heritage Collection (Public Pages)
|--------------------------------------------------------------------------
*/

Route::get('/heritage/discover', [HeritageCollectionController::class, 'discoverOurCollection'])
        ->name('heritage.discover');

Route::get('/heritage/archive-centre', [HeritageCollectionController::class, 'getAllMasterCategoriesWithCollectionCount'])
        ->name('heritage.archive-centre');

Route::get('/heritage/{id}', [HeritageCollectionController::class, 'showMasterCategory'])
        ->name('heritage.master-category.show');

Route::get('/heritage/{id}/view', [HeritageCollectionController::class, 'clientshow'])
        ->name('heritage.collection.show');

Route::get('/heritage/{id}/download', [HeritageCollectionController::class, 'downloadPdf'])
        ->name('heritage.collection.download');


Route::post('/heritagecollection/access-request', [HeritageCollectionAccessRequestController::class, 'submitRequestheritage'])->name('heritagecollections.request.submit');






Route::get('/all/publications', [PublicationController::class,  'index'])->name('client.publications');
   
Route::post('/publications/request', [RequestController::class, 'submitRequest'])->name('publications.request.submit');

Route::get('/publications/filter', [PublicationController::class, 'filter'])->name('publications.filter');



//Client side JoinUs
Route::get('/joinus', [MemberController::class, 'joinUs'])->name('client.joinus');




// Public PDF download
Route::get('/collections/{collection}/download-pdf', [CollectionController::class, 'downloadPdf'])
    ->name('news.download.pdf');

// Private access request
Route::post('/collections/access-request', [CollectionAccessRequestController::class, 'submitRequest'])
    ->name('collections.request.submit');






   


// Route::get('/heritageCentre', function () {
//     return view('client.heritagecentre');
// })->name('client.heritage-centre');


Route::get('/committee', [ComandTechController::class, 'showCommittee'])->name('client.committee');
Route::get('/technical-team', [ComandTechController::class, 'showTechnicalTeam'])->name('client.technicalteam');

Route::get('/heritageCentre', function (\Illuminate\Http\Request $request) {
    $query = Exhibition::with('category')
        ->withCount('artifacts')
        ->latest();

    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    $exhibitions = $query->get();
    $categories  = ExhibitionCategory::orderBy('name')->get();

    return view('client.heritagecentre', compact('exhibitions', 'categories'));
})->name('client.heritage-centre');

Route::get('/heritageCentre/{exhibition}', function (Exhibition $exhibition) {
    $exhibition->load([
        'category',
        'galleryImages',
        'artifacts' => fn ($q) => $q->orderBy('name'),
    ]);

    return view('client.exhibitionview', compact('exhibition'));
})->name('client.exhibition.show');





// Main collection view
    Route::get('/heritage/heritagecollection/{id}', [HeritageCollectionController::class, 'clientshow'])->name('heritage.collection.show');

    
    
    // Category view
    Route::get('/heritage/category/{id}', [HeritageCollectionController::class, 'showMainCategory'])->name('heritage.category.show');
    
    // Discover all collections






    




   


// Route::get('/tolexhibtion', function () {
//     return view('client.tolexhibtion');
// })->name('client.tolexhibtion');

// Route::get('/exhibitionheritag', function () {
//     return view('client.exhibitionheritag');
// })->name('client.exhibitionheritag');

Route::get('/subjectguides', function () {
    return view('client.subjectguides');
})->name('client.subjectguides');

Route::get('/collaborate', function () {
    return view('client.collaborate');
})->name('client.collaborate');

Route::get('/supportus', function () {
    return view('client.supportus');
})->name('client.supportus');


Route::get('/archiving', [ArchiveController::class, 'show'])->name('client.archiving');
Route::post('/archiving/submit', [ArchiveController::class, 'store'])->name('client.archiving.submit');

Route::get('/explorexhibition', [ExhibitionCategoryController::class, 'displaycategoryclient'])
    ->name('client.explorexhibition');





Route::get('/api/subcategories-by-main-category/{mainCategoryId}', [PublicationController::class, 'getSubcategoriesByMainCategory'])
    ->name('api.subcategories.byMainCategory');



// Admin Routes (protected)



//Client side Event
Route::get('/projects', function () {
    return view('client.projects');
})->name('client.projects');


Route::get('/contactus', [EnquiryController::class, 'create'])
    ->name('client.contactus');

Route::get('/captcha/refresh', [EnquiryController::class, 'refreshCaptcha'])
    ->name('captcha.refresh');

Route::post('/enquiry/store', [EnquiryController::class, 'store'])
    ->name('enquiry.store');

// Membership Application
Route::post('/membership/apply', [MemberController::class, 'store'])->name('membership.apply');



    
//Client side books shop
Route::get('/books', function () {
    return view('client.book');
})->name('client.book');

//Client Successful sent
Route::get('/successful', function () {
    return view('client.successful');
})->name('client.successful');


// AJAX live-search endpoint (returns JSON)
Route::get('/search/live', [SearchController::class, 'live'])
    ->name('search.live')
    ->middleware('throttle:60,1'); // 60 requests per minute per IP

// Full results page
Route::get('/search', [SearchController::class, 'results'])
    ->name('search.results');


});

//------------------PDF water Mark--------------------------//
Route::get('/publicfree/download-pdf/{id}', [PublicationController::class, 'downloadPublication'])
    ->name('download.pdf');




//-------Error Pages---------------------------//
Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
})->name('unauthorized');








    






    


    



    




//     //---------------Enquiry------------------//

//     Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries');
//     Route::get('enquiries/{id}', [EnquiryController::class, 'show'])->name('enquiries.show');
//     Route::post('/enquiries/{id}/status', [EnquiryController::class, 'updateStatus'])->name('enquiries.updateStatus');
    
// });
//     });


Route::prefix('admin')->group(function () {

    // Guest Routes
    Route::middleware(['redirect.admin'])->group(function() {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login.view');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
        Route::post('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgot-password');
        Route::post('/verify-otp', [AdminAuthController::class, 'verifyOTP'])->name('admin.verify-otp');
        Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.reset-password');
    });

    // Refresh token (no auth middleware needed)
    Route::post('/refresh', [AdminAuthController::class, 'refresh'])->name('admin.refresh');

    // Authenticated Routes
    Route::middleware(['auth.jwt'])->name('admin.')->group(function () {
          Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');;
        Route::post('/change-password', [AdminAuthController::class, 'changePassword'])->name('change-password');
    
   

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/audit-logs', [DashboardController::class, 'auditLogs'])->name('audit-logs')->middleware('check.permission:admin');


    // Staff Management (Admin only)
    Route::middleware(['check.permission:admin'])->group(function () {
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

        // Staff History (Audit Logs)
        Route::get('/staff-history', [StaffHistoryController::class, 'index'])->name('staff.history.index');
        Route::get('/staff-history/{module}', [StaffHistoryController::class, 'items'])->name('staff.history.items');
        Route::get('/staff-history/{module}/{id}', [StaffHistoryController::class, 'show'])->name('staff.history.show');
    });

// Dashboard AJAX - Chart data
Route::get('/dashboard/chart', [DashboardController::class, 'chartData'])->name('dashboard.chart');

// Dashboard AJAX - Approve / Reject publication requests
Route::post('/dashboard/approve/{id}',  [DashboardController::class, 'approveRequest'])->name('dashboard.approve');
Route::post('/dashboard/reject/{id}',   [DashboardController::class, 'rejectRequest'])->name('dashboard.reject');

// Dashboard AJAX - Collection access requests
Route::post('/dashboard/collection-request/{id}/approve', [DashboardController::class, 'approveCollectionRequest'])
     ->name('admin.dashboard.collection.approve');

// Dashboard AJAX - Heritage collection access requests
Route::post('/dashboard/heritage-request/{id}/approve', [DashboardController::class, 'approveHeritageRequest'])
     ->name('admin.dashboard.heritage.approve');

    Route::get('/admin/profile', [AdminAuthController::class, 'profile'])->name('profile');


    



Route::get('/categories/main/publication',                    [CategoryController::class, 'index'])->name('categories.main.index');
Route::post  ('/categories/main/publication',                    [CategoryController::class, 'storeMainCategory'])->name('categories.main.store');
Route::get   ('/categories/main/{mainCategory}/edit/publication',[CategoryController::class, 'editMainCategory'])->name('categories.main.edit');
Route::put   ('/categories/main/{mainCategory}/publication',     [CategoryController::class, 'updateMainCategory'])->name('categories.main.update');
Route::delete('/categories/main/{mainCategory}/publication',     [CategoryController::class, 'destroyMainCategory'])->name('categories.main.destroy');

// AJAX: get subcategories for a main category
Route::get('/categories/main/{mainCategory}/subcategories/publication', 
    [CategoryController::class, 'getSubcategories']
)->name('categories.main.subcategories');

// Subcategories (store under main category)
Route::post('/categories/main/{mainCategory}/subcategories/publication', 
    [CategoryController::class, 'storeSubcategory']
)->name('categories.subcategories.store');

// Subcategory standalone routes (edit/update/delete by subcategory id)
Route::get   ('/categories/subcategories/{subcategory}/edit/publication', [CategoryController::class, 'editSubcategory'])   ->name('categories.subcategories.edit');
Route::put   ('/categories/subcategories/{subcategory}/publication',      [CategoryController::class, 'updateSubcategory'])->name('categories.subcategories.update');
Route::delete('/categories/subcategories/{subcategory}/publication',      [CategoryController::class, 'destroySubcategory'])->name('categories.subcategories.destroy');

// AJAX helpers
Route::get('/categories/all-with-subcategories', 
    [CategoryController::class, 'getAllWithSubcategories']
)->name('categories.all');

Route::get('/categories/subcategories-by/{mainCategoryId}', 
    [CategoryController::class, 'getSubcategoriesByMainCategory']
)->name('categories.by-main');

// Publications protection
Route::middleware(['check.permission:Publications'])->group(function () {



    
  









    Route::get('publicationorders', [RequestController::class, 'index'])->name('publicationorders');
    Route::post('orders/{order}/toggle-status', [RequestController::class, 'toggleStatus'])->name('orders.toggle-status');
    Route::post('orders/toggle-payment/{id}', [RequestController::class, 'togglePayment'])->name('orders.toggle-payment');



    Route::get('/publications', [PublicationController::class, 'adminindex'])->name('publications.view');
    Route::get('/publications/create', [PublicationController::class, 'create'])->name('publications.create');
    Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
    Route::put('/publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
    Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');
    
    // AJAX endpoints
    Route::get('/categories-by-type/{typeId}', [PublicationController::class, 'getCategoriesByType'])->name('categories.byType');
    Route::post('/publication-types', [PublicationController::class, 'storeType'])->name('publication-types.store');
    Route::post('/categories', [PublicationController::class, 'storeCategory'])->name('categories.store');
});



  // Main Categories

    


    

    
    







    //---------------Enquiry------------------//
    Route::middleware(['check.permission:Members'])->group(function () {

    Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries');
    Route::get('enquiries/{id}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::post('/enquiries/{id}/status', [EnquiryController::class, 'updateStatus'])->name('enquiries.updateStatus');

    // Membership Management
    Route::get('members', [MemberController::class, 'index'])->name('members.index');
    Route::get('members/{id}', [MemberController::class, 'show'])->name('members.show');
    Route::patch('members/{id}/status', [MemberController::class, 'updateStatus'])->name('members.status');
    Route::delete('members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::get('members/{id}/photo', [MemberController::class, 'showPhoto'])->name('members.photo');
    Route::get('members/{id}/document', [MemberController::class, 'downloadDocument'])->name('members.document');

    // Committee & Technical Team Management
    Route::get('committee', [ComandTechController::class, 'index'])->name('committee.index');
    Route::get('committee/create', [ComandTechController::class, 'create'])->name('committee.create');
    Route::post('committee', [ComandTechController::class, 'store'])->name('committee.store');
    Route::get('committee/{id}/edit', [ComandTechController::class, 'edit'])->name('committee.edit');
    Route::put('committee/{id}', [ComandTechController::class, 'update'])->name('committee.update');
    Route::delete('committee/{id}', [ComandTechController::class, 'destroy'])->name('committee.destroy');

    // Archive Management
    Route::get('archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::post('settings/update', [ArchiveController::class, 'updateSetting'])->name('settings.update');
    Route::patch('archives/{id}/status', [ArchiveController::class, 'updateStatus'])->name('archives.status');
    Route::get('archives/{id}/download', [ArchiveController::class, 'download'])->name('archives.download');
});




    // Collection Route- Star---------------////
    Route::middleware(['check.permission:Collection'])->group(function () {

    // Collection main categories
    Route::get('/categories/main',[CollectionCategoryController::class, 'indexadmin'])->name('main.index');
    Route::post('/categories/main',[CollectionCategoryController::class, 'mastercategoriesstore'])->name('main.store');
    Route::get('/categories/main/{id}',[CollectionCategoryController::class, 'editMainCategory'])->name('main.edit');
    Route::put('/categories/main/{id}',[CollectionCategoryController::class, 'update'])->name('main.update');
    Route::delete('/categories/main/{id}',[CollectionCategoryController::class, 'destroyMainCategory'])->name('main.destroy');

     // Collections resource routes
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
    Route::get('/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
    Route::match(['put', 'patch'], '/collections/{collection}', [CollectionController::class, 'update'])->name('collections.update');
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');

    // AJAX deletes
    Route::delete('/collections/{collection}/images/{index}', [CollectionController::class, 'deleteImage'])
        ->name('collections.images.destroy');

    Route::delete('/collections/{collection}/title-image', [CollectionController::class, 'deleteTitleImage'])
        ->name('collections.title_image.destroy');


            // routes/web.php
Route::get('/collection/access-requests', [CollectionAccessRequestController::class, 'index'])
    ->name('access-requests.index');


Route::patch('/collection/access-requests/{collectionAccessRequest}/status',
    [CollectionAccessRequestController::class, 'updateStatus'])
    ->name('access-requests.status');


    

    // Collection Route- End ---------------////
    });


  



// ── Exhibitions (resource) ───────────────────────────────────
Route::middleware(['check.permission:Virtual Exhibition'])->group(function () {
Route::get   ('/exhibitions',                    [ExhibitionController::class, 'index'])       ->name('exhibitions.index');
Route::get   ('/exhibitions/trashed',            [ExhibitionController::class, 'trashed'])     ->name('exhibitions.trashed');
Route::post  ('/exhibitions/{id}/restore',       [ExhibitionController::class, 'restore'])     ->name('exhibitions.restore');
Route::delete('/exhibitions/{id}/force-delete',  [ExhibitionController::class, 'forceDelete']) ->name('exhibitions.forceDelete');
Route::get   ('/exhibitions/create',             [ExhibitionController::class, 'create'])      ->name('exhibitions.create');
Route::post  ('/exhibitions',                    [ExhibitionController::class, 'store'])       ->name('exhibitions.store');
Route::get   ('/exhibitions/{exhibition}',       [ExhibitionController::class, 'show'])        ->name('exhibitions.show');
Route::get   ('/exhibitions/{exhibition}/edit',  [ExhibitionController::class, 'edit'])        ->name('exhibitions.edit');
Route::put   ('/exhibitions/{exhibition}',       [ExhibitionController::class, 'update'])      ->name('exhibitions.update');
Route::delete('/exhibitions/{exhibition}',       [ExhibitionController::class, 'destroy'])     ->name('exhibitions.destroy');


// ── Artifacts (nested under exhibitions) ────────────────────
Route::get   ('/exhibitions/{exhibitionId}/artifacts',                          [ArtifactController::class, 'index'])   ->name('exhibitions.artifacts.index');
Route::post  ('/exhibitions/{exhibitionId}/artifacts',                          [ArtifactController::class, 'store'])   ->name('exhibitions.artifacts.store');
Route::get   ('/exhibitions/{exhibitionId}/artifacts/{id}',                     [ArtifactController::class, 'show'])    ->name('exhibitions.artifacts.show');
Route::put   ('/exhibitions/{exhibitionId}/artifacts/{id}',                     [ArtifactController::class, 'update'])  ->name('exhibitions.artifacts.update');
Route::delete('/exhibitions/{exhibitionId}/artifacts/{id}',                     [ArtifactController::class, 'destroy']) ->name('exhibitions.artifacts.destroy');
Route::post  ('/exhibitions/{exhibitionId}/artifacts/{id}/restore',             [ArtifactController::class, 'restore']) ->name('exhibitions.artifacts.restore');

// ── Gallery Images (nested under exhibitions) ────────────────
Route::get   ('/exhibitions/{exhibition}/gallery',              [GalleryImageController::class, 'index'])       ->name('exhibitions.gallery.index');
Route::post  ('/exhibitions/{exhibition}/gallery',              [GalleryImageController::class, 'store'])       ->name('exhibitions.gallery.store');
Route::get   ('/exhibitions/{exhibition}/gallery/{galleryImage}',[GalleryImageController::class, 'show'])       ->name('exhibitions.gallery.show');
Route::delete('/exhibitions/{exhibition}/gallery/{galleryImage}',[GalleryImageController::class, 'destroy'])    ->name('exhibitions.gallery.destroy');
Route::delete('/exhibitions/{exhibition}/gallery',              [GalleryImageController::class, 'bulkDestroy']) ->name('exhibitions.gallery.bulkDestroy');


     Route::get('/exhibitions/main/categories', [ExhibitionCategoryController::class, 'index'])
    ->name('exhibitions.categories.index');

Route::post('/exhibitions/main/categories', [ExhibitionCategoryController::class, 'store'])
    ->name('exhibitions.store');

Route::get('/exhibitions/main/categories/{category}/edit', [ExhibitionCategoryController::class, 'edit'])
    ->name('exhibitions.edit');

Route::put('/exhibitions/main/categories/{category}', [ExhibitionCategoryController::class, 'update'])
    ->name('exhibitions.update');

Route::delete('/exhibitions/main/categories/{category}', [ExhibitionCategoryController::class, 'destroy'])
    ->name('exhibitions.destroy');
});

    ///---------Hetitage Collection Start--------------------//
    Route::middleware(['check.permission:Heritage'])->group(function () {

    // ── Master Categories ──────────────────────────────────────────────────────



        Route::get('/heritage/categories', [HeritageCollectionCategoryController::class, 'indexadmin'])
            ->name('heritage.indexadmin');

        Route::post('/heritage/categories', [HeritageCollectionCategoryController::class, 'mastercategoriesstore'])
            ->name('heritage.store');

        Route::get('/heritage/categories/{id}/edit', [HeritageCollectionCategoryController::class, 'editMainCategory'])
            ->name('heritage.edit');

        Route::put('/heritage/categories/{id}', [HeritageCollectionCategoryController::class, 'update'])
            ->name('update');

        Route::delete('/heritage/categories/{id}', [HeritageCollectionCategoryController::class, 'destroyMainCategory'])
            ->name('destroy');


        // ── Collections ────────────────────────────────────────────────────────────

        // GET  /admin/heritage/collections
        Route::get('/heritagecollections', [HeritageCollectionController::class, 'index'])
            ->name('heritagecollections.index');

        // GET  /admin/heritage/collections/create
        Route::get('/heritagecollections/create', [HeritageCollectionController::class, 'create'])
            ->name('heritagecollections.create');

        // POST /admin/heritage/collections
        Route::post('heritagecollections', [HeritageCollectionController::class, 'store'])
            ->name('heritagecollections.store');

        // GET  /admin/heritage/collections/{collection}
        Route::get('/heritagecollections/{collection}', [HeritageCollectionController::class, 'show'])
            ->name('heritagecollections.show');

        // GET  /admin/heritage/collections/{collection}/edit
        Route::get('/heritagecollections/{collection}/edit', [HeritageCollectionController::class, 'edit'])
            ->name('heritagecollections.edit');

        // PUT  /admin/heritage/collections/{collection}
        Route::put('/heritagecollections/{collection}', [HeritageCollectionController::class, 'update'])
            ->name('heritagecollections.update');

        // DELETE /admin/heritage/collections/{collection}
        Route::delete('/heritagecollections/{collection}', [HeritageCollectionController::class, 'destroy'])
            ->name('heritagecollections.destroy');

        // DELETE /admin/heritage/collections/{collection}/images/{index}  (AJAX)
        Route::delete('/heritagecollections/{collection}/images/{index}', [HeritageCollectionController::class, 'deleteImage'])
            ->name('heritagecollections.images.destroy');

        // DELETE /admin/heritage/collections/{collection}/title-image  (AJAX)
        Route::delete('/heritagecollections/{collection}/title-image', [HeritageCollectionController::class, 'deleteTitleImage'])
            ->name('heritagecollections.title-image.destroy');

    ///----------Heritage Collection End--------------------//
    });





       



        // ✅ Specific routes FIRST
Route::get('/heritage-collections/access-requests', [HeritageCollectionAccessRequestController::class, 'heritageindex'])
    ->name('heritage.access-requests.index');
Route::patch('/heritage-collections/access-requests/{request}/status', [HeritageCollectionAccessRequestController::class, 'updateStatus'])
    ->name('heritage-collections.access-requests.status');








 










    Route::get('/unauthorized', function () {
        return view('errors.403');
    })->name('unauthorized');

});

});

