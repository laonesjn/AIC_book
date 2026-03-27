<?php

namespace App\Http\Controllers;

use App\Models\HeritageCollection;
use App\Models\HeritageMasterMainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\PDF\FpdiWithRotate;
use Illuminate\Support\Str;
use App\Models\OneDriveLink;

class HeritageCollectionController extends Controller
{
    // ── Admin: List ────────────────────────────────────────────────────────────

    /**
     * Display a listing of heritage collections (admin).
     * Route: GET /admin/heritage/collections
     */
    public function index(Request $request)
    {
        $search               = $request->input('search');
        $accessType           = $request->input('access_type');
        $masterMainCategoryId = $request->input('master_main_category_id');

        $masterMainCategories = HeritageMasterMainCategory::ordered()->get();

        $collections = HeritageCollection::query()
            ->with('masterMainCategory')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%")
                                        ->orWhere('description', 'like', "%{$search}%"))
            ->when($accessType, fn($q) => $q->where('access_type', $accessType))
            ->when($masterMainCategoryId, fn($q) => $q->where('master_main_category_id', $masterMainCategoryId))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.viewheritagecollection', compact(
            'collections',
            'search',
            'accessType',
            'masterMainCategories',
            'masterMainCategoryId'
        ));
    }

    // ── Admin: History ────────────────────────────────────────────────────────

    public function history()
    {
        $logs = \App\Models\AuditLog::with('admin')
            ->where('model_type', HeritageCollection::class)
            ->whereIn('action', ['updated', 'deleted'])
            ->orderByDesc('created_at')
            ->limit(30)
            ->get()
            ->map(fn($log) => [
                'action'     => $log->action,
                'item_name'  => $log->changes['before']['title'] ?? $log->changes['after']['title'] ?? 'N/A',
                'admin_name' => $log->admin->name ?? 'Unknown',
                'date'       => $log->created_at->format('M d, Y H:i'),
            ]);

        return response()->json($logs);
    }

    // ── Admin: Create ──────────────────────────────────────────────────────────

    /**
     * Show the create heritage collection form.
     * Route: GET /admin/heritage/collections/create
     */
    public function create()
    {
        $masterMainCategories = HeritageMasterMainCategory::ordered()->get();
        return view('admin.addheritagecollection', compact('masterMainCategories'));
    }

    // ── Admin: Store ───────────────────────────────────────────────────────────

    /**
     * Store a newly created heritage collection.
     * Route: POST /admin/heritage/collections
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'master_main_category_id' => 'required|exists:heritage_master_main_categories,id',
                'title'                   => 'required|string|max:255',
                'description'             => 'required|string|min:10',
                'title_image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'images'                  => 'nullable|array|max:10',
                'images.*'                => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'access_type'             => 'required|in:Public,Private',
                'pdf'                     => 'nullable|file|mimes:pdf|max:51200',
            ];

            $messages = [
                'master_main_category_id.required' => 'Please select a master category.',
                'master_main_category_id.exists'   => 'The selected master category does not exist.',
                'title.required'                   => 'The collection title is required.',
                'title.max'                        => 'Title cannot exceed 255 characters.',
                'description.required'             => 'The description is required.',
                'description.min'                  => 'Description must be at least 10 characters.',
                'images.max'                       => 'You can upload a maximum of 10 images.',
                'images.*.image'                   => 'Each file must be a valid image.',
                'images.*.max'                     => 'Each image cannot exceed 5 MB.',
                'access_type.required'             => 'Please select an access type.',
                'access_type.in'                   => 'Access type must be either Public or Private.',
                'pdf.mimes'                        => 'The file must be a valid PDF.',
                'pdf.max'                          => 'The PDF file cannot exceed 50 MB.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $validator->validated();

            // Title image
            if ($request->hasFile('title_image')) {
                $ti = $request->file('title_image');
                $filename = uniqid() . '.' . $ti->getClientOriginalExtension();
                $ti->move(public_path('heritage_collections/titleimg'), $filename);
                $data['title_image'] = 'heritage_collections/titleimg/' . $filename;
            }

            // Gallery images
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $img) {
                    $filename = uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('heritage_collections/img'), $filename);
                    $images[] = 'heritage_collections/img/' . $filename;
                }
                $data['images'] = $images;
            } else {
                $data['images'] = null;
            }

            // PDF
            if ($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                $filename = Str::slug(pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . uniqid() . '.pdf';
                $pdf->move(public_path('heritage_collections/pdf'), $filename);
                $data['pdf'] = 'heritage_collections/pdf/' . $filename;
            } else {
                $data['pdf'] = null;
            }

        $collection = HeritageCollection::create($data);

        // Handle OneDrive Links
        if ($request->has('onedrive_links')) {
            foreach ($request->input('onedrive_links') as $linkData) {
                if (!empty($linkData['url'])) {
                    $collection->oneDriveLinks()->create([
                        'url'   => $linkData['url'],
                        'title' => $linkData['title'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.heritagecollections.index')
                ->with('success', 'Heritage collection created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create heritage collection: ' . $e->getMessage());
        }
    }

    // ── Admin: Show ────────────────────────────────────────────────────────────

    /**
     * Show a single heritage collection (admin).
     * Route: GET /admin/heritage/collections/{collection}
     */
    public function show(HeritageCollection $collection)
    {
        $collection->load(['masterMainCategory', 'oneDriveLinks']);
        $collection->increment('view_count');

        return view('admin.showheritagecollection', compact('collection'));
    }

    // ── Admin: Edit ────────────────────────────────────────────────────────────

    /**
     * Show the edit form.
     * Route: GET /admin/heritage/collections/{collection}/edit
     */
    public function edit(HeritageCollection $collection)
    {
        $collection->load(['masterMainCategory', 'oneDriveLinks']);
        $masterMainCategories = HeritageMasterMainCategory::ordered()->get();

        return view('admin.editheritagecollection', compact('collection', 'masterMainCategories'));
    }

    // ── Admin: Update ──────────────────────────────────────────────────────────

    /**
     * Update the specified heritage collection.
     * Route: PUT/PATCH /admin/heritage/collections/{collection}
     */
    public function update(Request $request, HeritageCollection $collection)
    {
        try {
            $rules = [
                'master_main_category_id' => 'required|exists:heritage_master_main_categories,id',
                'title'                   => 'required|string|max:255',
                'description'             => 'required|string|min:10',
                'title_image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'images'                  => 'nullable|array|max:10',
                'images.*'                => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'access_type'             => 'required|in:Public,Private',
                'pdf'                     => 'nullable|file|mimes:pdf|max:51200',
            ];

            $messages = [
                'master_main_category_id.required' => 'Please select a master category.',
                'master_main_category_id.exists'   => 'The selected master category does not exist.',
                'title.required'                   => 'The collection title is required.',
                'title.max'                        => 'Title cannot exceed 255 characters.',
                'description.required'             => 'The description is required.',
                'description.min'                  => 'Description must be at least 10 characters.',
                'images.max'                       => 'You can upload a maximum of 10 images.',
                'images.*.image'                   => 'Each file must be a valid image.',
                'images.*.max'                     => 'Each image cannot exceed 5 MB.',
                'access_type.required'             => 'Please select an access type.',
                'access_type.in'                   => 'Access type must be either Public or Private.',
                'pdf.mimes'                        => 'The file must be a valid PDF.',
                'pdf.max'                          => 'The PDF file cannot exceed 50 MB.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $validator->validated();

            // Title image
            if ($request->hasFile('title_image')) {
                $this->deleteFile($collection->title_image);
                $ti = $request->file('title_image');
                $filename = uniqid() . '.' . $ti->getClientOriginalExtension();
                $ti->move(public_path('heritage_collections/titleimg'), $filename);
                $data['title_image'] = 'heritage_collections/titleimg/' . $filename;
            }

            // Gallery images
            if ($request->hasFile('images')) {
                $this->deleteFiles($collection->images);
                $images = [];
                foreach ($request->file('images') as $img) {
                    $filename = uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('heritage_collections/img'), $filename);
                    $images[] = 'heritage_collections/img/' . $filename;
                }
                $data['images'] = $images;
            } else {
                unset($data['images']);
            }

            // PDF
            if ($request->hasFile('pdf')) {
                $this->deleteFile($collection->pdf);
                $pdf = $request->file('pdf');
                $filename = Str::slug(pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . uniqid() . '.pdf';
                $pdf->move(public_path('heritage_collections/pdf'), $filename);
                $data['pdf'] = 'heritage_collections/pdf/' . $filename;
            } elseif ($request->boolean('delete_pdf')) {
                $this->deleteFile($collection->pdf);
                $data['pdf'] = null;
            } else {
                unset($data['pdf']);
            }

            $collection->update($data);

        // Sync OneDrive Links
        if ($request->has('onedrive_links')) {
            $existingLinkIds = $collection->oneDriveLinks->pluck('id')->toArray();
            $updatedLinkIds = [];

            foreach ($request->input('onedrive_links') as $linkData) {
                if (empty($linkData['url'])) continue;

                if (!empty($linkData['id'])) {
                    $link = OneDriveLink::find($linkData['id']);
                    if ($link && $link->linkable_id == $collection->id && $link->linkable_type == HeritageCollection::class) {
                        $link->update([
                            'url'   => $linkData['url'],
                            'title' => $linkData['title'] ?? null,
                        ]);
                        $updatedLinkIds[] = $link->id;
                    }
                } else {
                    $newLink = $collection->oneDriveLinks()->create([
                        'url'   => $linkData['url'],
                        'title' => $linkData['title'] ?? null,
                    ]);
                    $updatedLinkIds[] = $newLink->id;
                }
            }

            $toDelete = array_diff($existingLinkIds, $updatedLinkIds);
            if (!empty($toDelete)) {
                OneDriveLink::destroy($toDelete);
            }
        }

        return redirect()->route('admin.heritagecollections.index')
                ->with('success', 'Heritage collection updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update heritage collection: ' . $e->getMessage());
        }
    }

    // ── Admin: Destroy ─────────────────────────────────────────────────────────

    /**
     * Delete the specified heritage collection and all its stored files.
     * Route: DELETE /admin/heritage/collections/{collection}
     */
    public function destroy(Request $request, HeritageCollection $collection)
    {
        try {
            $this->deleteFiles($collection->images);
            $this->deleteFile($collection->title_image);
            $this->deleteFile($collection->pdf);

            $collection->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Heritage collection deleted successfully.'
                ]);
            }

            return redirect()->route('admin.heritagecollections.index')
                ->with('success', 'Heritage collection deleted successfully.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete heritage collection: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to delete heritage collection: ' . $e->getMessage());
        }
    }

    // ── Admin: Delete individual gallery image (AJAX) ──────────────────────────

    /**
     * Route: DELETE /admin/heritage/collections/{collection}/images/{index}
     */
    public function deleteImage(HeritageCollection $collection, int $index)
    {
        try {
            $images = $collection->images ?? [];

            if (!array_key_exists($index, $images)) {
                return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
            }

            $this->deleteFile($images[$index]);

            array_splice($images, $index, 1);
            $collection->update(['images' => array_values($images)]);

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ── Admin: Delete title image (AJAX) ───────────────────────────────────────

    /**
     * Route: DELETE /admin/heritage/collections/{collection}/title-image
     */
    public function deleteTitleImage(HeritageCollection $collection)
    {
        try {
            if (!$collection->title_image) {
                return response()->json(['success' => false, 'message' => 'No title image found.'], 404);
            }

            $this->deleteFile($collection->title_image);
            $collection->update(['title_image' => null]);

            return response()->json(['success' => true, 'message' => 'Title image deleted successfully.']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete title image: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ── Client: Master category collections page ───────────────────────────────

    /**
     * Show all heritage collections under a master category (client).
     * Route: GET /heritage-collection/{id}
     */
    public function showMasterCategory(int $id)
    {
        $masterCategory = HeritageMasterMainCategory::withCount('collections')->findOrFail($id);

        $masterCategory->increment('view_count');

        $collections = HeritageCollection::where('master_main_category_id', $id)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($col) => [
                'id'          => $col->id,
                'title'       => $col->title,
                'title_image' => $col->title_image,
                'description' => $col->description,
                'first_image' => collect($col->images)->first(),
                'access_type' => $col->access_type,
                'pdf'         => $col->access_type === 'Public' ? $col->pdf : null,
                'view_count'  => $col->view_count,
            ]);

        $data = [
            'id'          => $masterCategory->id,
            'name'        => $masterCategory->name,
            'view_count'  => $masterCategory->view_count,
            'collections' => $collections,
        ];

        return view('client.heritage.archivecentrecollectionshow', compact('data'));
    }

    // ── Client: Single heritage collection view ───────────────────────────────

    /**
     * Route: GET /heritage-collection/{id}/view
     */
    // public function clientshow(int $id)
    // {
    //     $collection = HeritageCollection::with('masterMainCategory')->findOrFail($id);

    //     $images = $collection->images ?? [];

    //     $collection->increment('view_count');

    //     if ($collection->access_type === 'Private') {
    //         $collection->pdf = null;
    //     }

    //     $titleImg    = $collection->title_image;
    //     $overviewImg = !empty($images) ? $images[count($images) - 1] : $titleImg;

    //     return view('client.heritagecollectionshow', compact('collection', 'titleImg', 'images', 'overviewImg'));
    // }

    public function clientshow(int $id)
{
    $collection = HeritageCollection::with('masterMainCategory', 'oneDriveLinks')->findOrFail($id);

    $images = $collection->images ?? [];

    $collection->increment('view_count');

    $hasPdf = !empty($collection->pdf);

    if ($collection->access_type === 'Private') {
        $collection->pdf = null;
    }

    $titleImg    = $collection->title_image;
    $overviewImg = !empty($images) ? $images[count($images) - 1] : $titleImg;

    return view('client.heritagecollectionshow', compact('collection', 'titleImg', 'images', 'overviewImg', 'hasPdf'));
}

    // ── Client: Download watermarked PDF ──────────────────────────────────────

    /**
     * Route: GET /heritage-collection/{id}/download
     */
    public function downloadPdf(int $id)
    {
        $publication = HeritageCollection::findOrFail($id);

        if ($publication->access_type !== 'Public') {
            abort(403, 'This document is not publicly accessible.');
        }

        if (!$publication->pdf) {
            abort(404, 'No PDF attached to this heritage collection.');
        }

        $filePath = storage_path('app/public/' . $publication->pdf);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        $pdf       = new FpdiWithRotate();
        $pageCount = $pdf->setSourceFile($filePath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $tplId = $pdf->importPage($i);
            $size  = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            // ── Centre stamp watermark ───────────────────────────────────────
            $pdf->SetFont('Helvetica', 'B', 52);
            $pdf->SetTextColor(200, 30, 30);
            $pdf->SetDrawColor(200, 30, 30);

            $centerX   = $size['width']  / 2;
            $centerY   = $size['height'] / 2;
            $text      = 'The Archives';
            $textWidth = $pdf->GetStringWidth($text);

            $pdf->StartTransform();
                $pdf->Rotate(-30, $centerX, $centerY);

                $rectW = $textWidth + 20;
                $rectH = 28;
                $rectX = $centerX - ($rectW / 2);
                $rectY = $centerY - ($rectH / 2);

                $pdf->SetLineWidth(0.8);
                $pdf->Rect($rectX - 2, $rectY - 2, $rectW + 4, $rectH + 4);
                $pdf->SetLineWidth(2.5);
                $pdf->Rect($rectX, $rectY, $rectW, $rectH);

                $pdf->SetXY($rectX, $rectY + 5);
                $pdf->Cell($rectW, 18, $text, 0, 0, 'C');
            $pdf->StopTransform();

            // ── Tiled background watermark ───────────────────────────────────
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->SetTextColor(220, 180, 180);
            for ($x = 10; $x < $size['width']; $x += 55) {
                for ($y = 10; $y < $size['height']; $y += 40) {
                    $pdf->StartTransform();
                    $pdf->Rotate(-30, $x, $y);
                    $pdf->Text($x, $y, 'The Archives');
                    $pdf->StopTransform();
                }
            }
        }

        $filename = Str::slug($publication->title) . '.pdf';

        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // ── Client: Discover heritage collection landing page ─────────────────────

    /**
     * Route: GET /discover-heritage-collection
     */
    public function discoverOurCollection()
    {
        $masterCategories = HeritageMasterMainCategory::with('collections')
            ->has('collections')
            ->ordered()
            ->get();

        return view('client.discoverheritagecentre', compact('masterCategories'));
    }

    // ── Client: Heritage archive centre listing ───────────────────────────────

    /**
     * Route: GET /heritage-archive-centre
     */
    public function getAllMasterCategoriesWithCollectionCount(Request $request)
    {
        $masterCategories = HeritageMasterMainCategory::ordered()->get();

        $query = HeritageCollection::with('masterMainCategory');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('master_main_category_id', $request->category);
        }

        if ($request->filled('access_type')) {
            $query->where('access_type', $request->access_type);
        }

        $collections = $query->orderBy('created_at', 'desc')->get();

        return view('client.tolexhibtion', compact('collections', 'masterCategories'));
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function deleteFile(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    private function deleteFiles(?array $paths): void
    {
        foreach ($paths ?? [] as $path) {
            $this->deleteFile($path);
        }
    }
}