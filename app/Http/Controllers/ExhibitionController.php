<?php

namespace App\Http\Controllers;

use App\Models\Artifact;
use App\Models\Exhibition;
use App\Models\ExhibitionCategory;
use App\Models\ExhibitionGalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\OneDriveLink;

class ExhibitionController extends Controller
{
    public function publicShow(Exhibition $exhibition)
    {
        $exhibition->load(['category', 'galleryImages', 'artifacts']);
        return view('client.exhibitionview', compact('exhibition'));
    }

    // ========================================================================
    //  HISTORY
    // ========================================================================
    public function history()
    {
        $logs = \App\Models\AuditLog::with('admin')
            ->where('model_type', Exhibition::class)
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

    // ========================================================================
    //  INDEX
    // ========================================================================
    public function index(Request $request)
    {
        $query = Exhibition::with(['category'])
            ->withCount(['artifacts', 'galleryImages']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . trim($request->search) . '%');
        }

        $exhibitions = $query->latest()->paginate(9)->withQueryString();
        $categories  = ExhibitionCategory::orderBy('name')->get();

        return view('admin.exhibitionall', compact('exhibitions', 'categories'));
    }

    // ========================================================================
    //  CREATE
    // ========================================================================
    public function create()
    {
        $categories = ExhibitionCategory::orderBy('name')->get();
        return view('admin.addexhibition', compact('categories'));
    }

    // ========================================================================
    //  STORE
    // ========================================================================
    public function store(Request $request)
    {
        $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'category_id'         => ['required', 'integer', 'exists:exhibition_categories,id'],
            'tour_link'           => ['nullable', 'url', 'max:500'],
            'exhibition_location' => ['nullable', 'string', 'max:255'],
            'cover_image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'gallery_images'      => ['nullable', 'array', 'max:20'],
            'gallery_images.*'    => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'artifacts'               => ['nullable', 'array'],
            'artifacts.*.name'        => ['required', 'string', 'max:255'],
            'artifacts.*.description' => ['nullable', 'string'],
            'artifacts.*.image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'artifacts.*.file_location' => ['nullable', 'string', 'max:255'],
            'onedrive_links'          => ['nullable', 'array'],
            'onedrive_links.*.url'    => ['required_with:onedrive_links.*.title', 'url', 'max:500'],
            'onedrive_links.*.title'  => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        $coverPath = null;

        try {
            // 1. Cover image
            if ($request->hasFile('cover_image')) {
                $coverFile = $request->file('cover_image');
                $coverName = uniqid() . '.' . $coverFile->getClientOriginalExtension();
                $coverFile->move(public_path('exhibitions/covers'), $coverName);
                $coverPath = 'exhibitions/covers/' . $coverName;
            }

            // 2. Exhibition record
            $exhibition = Exhibition::create([
                'title'               => trim($request->title),
                'description'         => trim($request->description),
                'category_id'         => $request->category_id,
                'tour_link'           => $request->tour_link ? trim($request->tour_link) : null,
                'exhibition_location' => $request->exhibition_location ? trim($request->exhibition_location) : null,
                'cover_image'         => $coverPath,
            ]);

            // 3. Gallery images
            if ($request->hasFile('gallery_images')) {
                $galleryDirPath = public_path('exhibitions/gallery');
                if (!file_exists($galleryDirPath)) {
                    mkdir($galleryDirPath, 0777, true);
                }
                foreach ($request->file('gallery_images') as $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($galleryDirPath, $filename);
                    $path = 'exhibitions/gallery/' . $filename;
                    
                    ExhibitionGalleryImage::create([
                        'exhibition_id' => $exhibition->id,
                        'image_path'    => $path,
                    ]);
                }
            }

            // 4. Artifacts
            if ($request->filled('artifacts')) {
                $artifactFiles = $request->file('artifacts') ?? [];
                foreach ($request->artifacts as $key => $art) {
                    if (empty($art['name'])) continue;

                    $imagePath = null;
                    if (isset($artifactFiles[$key]['image'])) {
                        $artFile = $artifactFiles[$key]['image'];
                        $artFileName = uniqid() . '.' . $artFile->getClientOriginalExtension();
                        $artFile->move(public_path('artifacts'), $artFileName);
                        $imagePath = 'artifacts/' . $artFileName;
                    }

                    Artifact::create([
                        'exhibition_id' => $exhibition->id,
                        'name'          => trim($art['name']),
                        'description'   => !empty($art['description']) ? trim($art['description']) : null,
                        'image_path'    => $imagePath,
                        'file_location' => !empty($art['file_location']) ? trim($art['file_location']) : null,
                    ]);
                }
            }

            // 5. OneDrive Links
            if ($request->filled('onedrive_links')) {
                foreach ($request->onedrive_links as $linkData) {
                    if (empty($linkData['url'])) continue;
                    $exhibition->oneDriveLinks()->create([
                        'url'   => trim($linkData['url']),
                        'title' => !empty($linkData['title']) ? trim($linkData['title']) : null,
                    ]);
                }
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            if ($coverPath && file_exists(public_path($coverPath))) {
                unlink(public_path($coverPath));
            }
            Log::error('Exhibition store failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()
            ->route('admin.exhibitions.show', $exhibition)
            ->with('success', 'Exhibition "' . $exhibition->title . '" published successfully.');
    }

    // ========================================================================
    //  SHOW
    // ========================================================================
    public function show(Exhibition $exhibition)
    {
        $exhibition->load([
            'category',
            'galleryImages',
            'artifacts' => fn ($q) => $q->orderBy('name'),
            'oneDriveLinks',
        ]);

        return view('admin.showexhibition', compact('exhibition'));
    }

    // ========================================================================
    //  EDIT
    // ========================================================================
    public function edit(Exhibition $exhibition)
    {
        $exhibition->load(['galleryImages', 'artifacts', 'oneDriveLinks']);
        $categories = ExhibitionCategory::orderBy('name')->get();

        return view('admin.editexhibition', compact('exhibition', 'categories'));
    }

    // ========================================================================
    //  UPDATE
    // ========================================================================
    public function update(Request $request, Exhibition $exhibition)
    {
        $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'category_id'         => ['required', 'integer', 'exists:exhibition_categories,id'],
            'tour_link'           => ['nullable', 'url', 'max:500'],
            'exhibition_location' => ['nullable', 'string', 'max:255'],
            'cover_image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'gallery_images'      => ['nullable', 'array', 'max:20'],
            'gallery_images.*'    => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'delete_gallery'      => ['nullable', 'array'],
            'delete_gallery.*'    => ['integer', 'exists:exhibition_gallery_images,id'],
            'existing_artifacts'               => ['nullable', 'array'],
            'existing_artifacts.*.id'          => ['required', 'integer', 'exists:artifacts,id'],
            'existing_artifacts.*.name'        => ['required', 'string', 'max:255'],
            'existing_artifacts.*.description' => ['nullable', 'string'],
            'existing_artifacts.*.image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'existing_artifacts.*.file_location' => ['nullable', 'string', 'max:255'],
            'artifacts'                => ['nullable', 'array'],
            'artifacts.*.name'        => ['required', 'string', 'max:255'],
            'artifacts.*.description' => ['nullable', 'string'],
            'artifacts.*.image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'artifacts.*.file_location' => ['nullable', 'string', 'max:255'],
            'onedrive_links'          => ['nullable', 'array'],
            'onedrive_links.*.id'     => ['nullable', 'integer', 'exists:one_drive_links,id'],
            'onedrive_links.*.url'    => ['required_with:onedrive_links.*.title', 'url', 'max:500'],
            'onedrive_links.*.title'  => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            // 1. Cover image
            $coverPath = $exhibition->cover_image;
            if ($request->hasFile('cover_image')) {
                if ($coverPath && file_exists(public_path($coverPath))) {
                    unlink(public_path($coverPath));
                }
                $coverFile = $request->file('cover_image');
                $coverName = uniqid() . '.' . $coverFile->getClientOriginalExtension();
                $coverFile->move(public_path('exhibitions/covers'), $coverName);
                $coverPath = 'exhibitions/covers/' . $coverName;
            }

            // 2. Update core fields
            $exhibition->update([
                'title'               => trim($request->title),
                'description'         => trim($request->description),
                'category_id'         => $request->category_id,
                'tour_link'           => $request->tour_link ? trim($request->tour_link) : null,
                'exhibition_location' => $request->exhibition_location ? trim($request->exhibition_location) : null,
                'cover_image'         => $coverPath,
            ]);

            // 3. Delete marked gallery images
            if ($request->filled('delete_gallery')) {
                $toDelete = ExhibitionGalleryImage::whereIn('id', $request->delete_gallery)
                    ->where('exhibition_id', $exhibition->id)->get();
                foreach ($toDelete as $img) {
                    if ($img->image_path && file_exists(public_path($img->image_path))) {
                        unlink(public_path($img->image_path));
                    }
                    $img->delete();
                }
            }

            // 4. Add new gallery images
            if ($request->hasFile('gallery_images')) {
                $galleryDirPath = public_path('exhibitions/gallery');
                if (!file_exists($galleryDirPath)) {
                    mkdir($galleryDirPath, 0777, true);
                }
                foreach ($request->file('gallery_images') as $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($galleryDirPath, $filename);
                    $path = 'exhibitions/gallery/' . $filename;
                    ExhibitionGalleryImage::create([
                        'exhibition_id' => $exhibition->id,
                        'image_path'    => $path,
                    ]);
                }
            }

            // 5. Update existing artifacts
            if ($request->filled('existing_artifacts')) {
                $existingFiles = $request->file('existing_artifacts') ?? [];
                foreach ($request->existing_artifacts as $key => $art) {
                    $artifact = Artifact::where('id', $art['id'])
                        ->where('exhibition_id', $exhibition->id)->first();
                    if (!$artifact) continue;

                    $imagePath = $artifact->image_path;
                    if (isset($existingFiles[$key]['image'])) {
                        if ($imagePath && file_exists(public_path($imagePath))) {
                            unlink(public_path($imagePath));
                        }
                        $artFile = $existingFiles[$key]['image'];
                        $artFileName = uniqid() . '.' . $artFile->getClientOriginalExtension();
                        $artFile->move(public_path('artifacts'), $artFileName);
                        $imagePath = 'artifacts/' . $artFileName;
                    }

                    $artifact->update([
                        'name'          => trim($art['name']),
                        'description'   => !empty($art['description']) ? trim($art['description']) : null,
                        'image_path'    => $imagePath,
                        'file_location' => !empty($art['file_location']) ? trim($art['file_location']) : null,
                    ]);
                }
            }

            // 6. New artifacts
            if ($request->filled('artifacts')) {
                $newArtFiles = $request->file('artifacts') ?? [];
                foreach ($request->artifacts as $key => $art) {
                    if (empty($art['name'])) continue;

                    $imagePath = null;
                    if (isset($newArtFiles[$key]['image'])) {
                        $artFile = $newArtFiles[$key]['image'];
                        $artFileName = uniqid() . '.' . $artFile->getClientOriginalExtension();
                        $artFile->move(public_path('artifacts'), $artFileName);
                        $imagePath = 'artifacts/' . $artFileName;
                    }

                    Artifact::create([
                        'exhibition_id' => $exhibition->id,
                        'name'          => trim($art['name']),
                        'description'   => !empty($art['description']) ? trim($art['description']) : null,
                        'image_path'    => $imagePath,
                        'file_location' => !empty($art['file_location']) ? trim($art['file_location']) : null,
                    ]);
                }
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Exhibition update failed: ' . $e->getMessage(), ['exhibition_id' => $exhibition->id]);

            return back()->withInput()
                ->with('error', 'Something went wrong while updating. Please try again.');
        }

        return redirect()
            ->route('admin.exhibitions.show', $exhibition)
            ->with('success', 'Exhibition updated successfully.');
    }

    // ========================================================================
    //  DESTROY
    // ========================================================================
    public function destroy(Exhibition $exhibition)
    {
        // Delete artifact images
        foreach ($exhibition->artifacts as $artifact) {
            if ($artifact->image_path && file_exists(public_path($artifact->image_path))) {
                unlink(public_path($artifact->image_path));
            }
        }
        $exhibition->artifacts()->delete();

        // Delete gallery images
        foreach ($exhibition->galleryImages as $img) {
            if ($img->image_path && file_exists(public_path($img->image_path))) {
                unlink(public_path($img->image_path));
            }
        }
        $exhibition->galleryImages()->delete();

        // Delete cover image
        if ($exhibition->cover_image && file_exists(public_path($exhibition->cover_image))) {
            unlink(public_path($exhibition->cover_image));
        }

        $exhibition->delete();

        return redirect()
            ->route('admin.exhibitions.index')
            ->with('success', 'Exhibition "' . $exhibition->title . '" deleted successfully.');
    }
}