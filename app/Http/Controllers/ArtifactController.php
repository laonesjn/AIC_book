<?php

namespace App\Http\Controllers;

use App\Models\Artifact;
use App\Models\Exhibition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtifactController extends Controller
{
    // GET /exhibitions/{exhibitionId}/artifacts
    public function index(int $exhibitionId): JsonResponse
    {
        $exhibition = Exhibition::findOrFail($exhibitionId);
        $artifacts  = $exhibition->artifacts()->latest()->get();

        return response()->json(['success' => true, 'data' => $artifacts]);
    }

    // POST /exhibitions/{exhibitionId}/artifacts
    public function store(Request $request, int $exhibitionId): JsonResponse
    {
        $exhibition = Exhibition::findOrFail($exhibitionId);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'file_location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageTag = $request->file('image');
            $filename = uniqid() . '.' . $imageTag->getClientOriginalExtension();
            $imageTag->move(public_path('exhibitions/artifacts'), $filename);
            $imagePath = 'exhibitions/artifacts/' . $filename;
        }

        $artifact = Artifact::create([
            'exhibition_id' => $exhibition->id,
            'name'          => $request->name,
            'description'   => $request->description,
            'image_path'    => $imagePath,
            'file_location' => $request->file_location,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Artifact created successfully.',
            'data'    => $artifact,
        ], 201);
    }

    // GET /exhibitions/{exhibitionId}/artifacts/{id}
    public function show(int $exhibitionId, int $id): JsonResponse
    {
        $artifact = Artifact::where('exhibition_id', $exhibitionId)->findOrFail($id);

        return response()->json(['success' => true, 'data' => $artifact]);
    }

    // PUT /exhibitions/{exhibitionId}/artifacts/{id}
    public function update(Request $request, int $exhibitionId, int $id): JsonResponse
    {
        $artifact = Artifact::where('exhibition_id', $exhibitionId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'          => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'file_location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $imagePath = $artifact->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            $imageTag = $request->file('image');
            $filename = uniqid() . '.' . $imageTag->getClientOriginalExtension();
            $imageTag->move(public_path('exhibitions/artifacts'), $filename);
            $imagePath = 'exhibitions/artifacts/' . $filename;
        }

        $artifact->update([
            'name'          => $request->get('name',          $artifact->name),
            'description'   => $request->get('description',   $artifact->description),
            'image_path'    => $imagePath,
            'file_location' => $request->get('file_location', $artifact->file_location),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Artifact updated successfully.',
            'data'    => $artifact->fresh(),
        ]);
    }

    // DELETE /exhibitions/{exhibitionId}/artifacts/{id}
    public function destroy(int $exhibitionId, int $id): JsonResponse
    {
        $artifact = Artifact::where('exhibition_id', $exhibitionId)->findOrFail($id);

        if ($artifact->image_path && file_exists(public_path($artifact->image_path))) {
            unlink(public_path($artifact->image_path));
        }

        $artifact->delete(); // permanent delete (no soft delete)

        return response()->json([
            'success' => true,
            'message' => 'Artifact deleted successfully.',
        ]);
    }
}