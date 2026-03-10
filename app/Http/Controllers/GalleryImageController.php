<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use App\Models\ExhibitionGalleryImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/exhibitions/{exhibition}/gallery
    // ─────────────────────────────────────────────────────────────────────────
    public function index(Exhibition $exhibition): JsonResponse
    {
        $images = $exhibition->galleryImages()->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $images->map(fn($img) => $this->format($img)),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /api/exhibitions/{exhibition}/gallery
    // Upload one or more gallery images
    //
    // multipart/form-data:
    //   images[]  file  required (one or more)
    // ─────────────────────────────────────────────────────────────────────────
    public function store(Request $request, Exhibition $exhibition): JsonResponse
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $galleryDirPath = public_path('exhibitions/gallery');
        if (!file_exists($galleryDirPath)) {
            mkdir($galleryDirPath, 0777, true);
        }
        foreach ($request->file('images') as $img) {
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move($galleryDirPath, $filename);
            $path = 'exhibitions/gallery/' . $filename;
            $created->push($exhibition->galleryImages()->create(['image_path' => $path]));
        }

        return response()->json([
            'success' => true,
            'message' => $created->count() . ' image(s) uploaded successfully.',
            'data'    => $created->map(fn($img) => $this->format($img)),
        ], 201);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/exhibitions/{exhibition}/gallery/{galleryImage}
    // ─────────────────────────────────────────────────────────────────────────
    public function show(Exhibition $exhibition, ExhibitionGalleryImage $galleryImage): JsonResponse
    {
        $this->assertBelongs($exhibition, $galleryImage);

        return response()->json([
            'success' => true,
            'data'    => $this->format($galleryImage),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DELETE /api/exhibitions/{exhibition}/gallery/{galleryImage}
    // ─────────────────────────────────────────────────────────────────────────
    public function destroy(Exhibition $exhibition, ExhibitionGalleryImage $galleryImage): JsonResponse
    {
        $this->assertBelongs($exhibition, $galleryImage);

        if ($galleryImage->image_path && file_exists(public_path($galleryImage->image_path))) {
            unlink(public_path($galleryImage->image_path));
        }
        $galleryImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DELETE /api/exhibitions/{exhibition}/gallery/bulk
    // Delete multiple gallery images by ID
    //
    // body: { "ids": [1, 2, 3] }
    // ─────────────────────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request, Exhibition $exhibition): JsonResponse
    {
        $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:exhibition_gallery_images,id'],
        ]);

        $images = $exhibition->galleryImages()
            ->whereIn('id', $request->ids)
            ->get();

        foreach ($images as $img) {
            if ($img->image_path && file_exists(public_path($img->image_path))) {
                unlink(public_path($img->image_path));
            }
            $img->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $images->count() . ' gallery image(s) deleted.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────────────────
    private function assertBelongs(Exhibition $exhibition, ExhibitionGalleryImage $image): void
    {
        abort_if(
            $image->exhibition_id !== $exhibition->id,
            404,
            'Image not found in this exhibition.'
        );
    }

    private function format(ExhibitionGalleryImage $img): array
    {
        return [
            'id'            => $img->id,
            'exhibition_id' => $img->exhibition_id,
            'image_path'    => $img->image_path,
            'image_url'     => asset($img->image_path),
            'created_at'    => $img->created_at,
            'updated_at'    => $img->updated_at,
        ];
    }
}