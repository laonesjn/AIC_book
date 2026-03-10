<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CollectionMainCategory;
use App\Models\MasterMainCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CollectionCategoryController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════════
    //  INDEX — admin list view
    // ══════════════════════════════════════════════════════════════════════════

    public function indexadmin(Request $request): View
    {
        $search = $request->input('search');

        $masterCategories = MasterMainCategory::with('mainCategories')
            ->when($search, fn($q) => $q->search($search))
            ->ordered()
            ->paginate(10);

        return view('admin.managecategories', compact('masterCategories', 'search'));
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  STORE — POST /admin/categories/main
    // ══════════════════════════════════════════════════════════════════════════

    public function mastercategoriesstore(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:master_main_categories,name',
            ], [
                'name.required' => 'Category name is required.',
                'name.unique'   => 'This category name already exists.',
                'name.max'      => 'Category name must not exceed 255 characters.',
            ]);

            $masterCategory = MasterMainCategory::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'data'    => $masterCategory,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  EDIT — GET /admin/categories/main/{id}
    //  Returns JSON for the modal form population
    // ══════════════════════════════════════════════════════════════════════════

    public function editMainCategory(int $id): JsonResponse
    {
        try {
            $category = MasterMainCategory::findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'   => $category->id,
                    'name' => $category->name,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch category data.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  UPDATE — PUT /admin/categories/main/{id}
    // ══════════════════════════════════════════════════════════════════════════

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $category = MasterMainCategory::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:master_main_categories,name,' . $category->id,
            ], [
                'name.required' => 'Category name is required.',
                'name.unique'   => 'This category name already exists.',
                'name.max'      => 'Category name must not exceed 255 characters.',
            ]);

            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'data'    => $category->fresh(),
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  DESTROY — DELETE /admin/categories/main/{id}
    // ══════════════════════════════════════════════════════════════════════════

    public function destroyMainCategory(int $id): JsonResponse
    {
        try {
            $category = MasterMainCategory::findOrFail($id);

            // Unlink all child main-categories before deleting the master
            CollectionMainCategory::where('master_main_category_id', $category->id)
                ->update(['master_main_category_id' => null]);

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Delete Master Category Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  CLIENT — discover our collection page
    // ══════════════════════════════════════════════════════════════════════════

    public function discoverOurCollection(): View
    {
        $masterCategories = MasterMainCategory::withCount('collections')
            ->ordered()
            ->get();

        return view('client.discoverourcollection', compact('masterCategories'));
    }
}