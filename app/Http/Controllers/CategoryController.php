<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // ── Main Categories ────────────────────────────────────────────────────────

    /**
     * Display all main categories with subcategories
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $mainCategories = MainCategory::with('subcategories')
            ->when($search, fn($q) => $q->search($search))
            ->ordered()
            ->paginate(10);

        return view('admin.managepublicationcategories', compact('mainCategories', 'search'));
    }

    /**
     * Store new main category
     */
    public function storeMainCategory(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:main_categories,name',
            ], [
                'name.required' => 'Category name is required.',
                'name.unique'   => 'This category name already exists.',
                'name.max'      => 'Category name must not exceed 255 characters.',
            ]);

            $mainCategory = MainCategory::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Main category created successfully!',
                'data'    => $mainCategory,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    /**
     * Show edit main category (JSON for modal)
     */
    public function editMainCategory(MainCategory $mainCategory): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $mainCategory,
        ]);
    }

    /**
     * Update main category
     */
    public function updateMainCategory(Request $request, MainCategory $mainCategory): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:main_categories,name,' . $mainCategory->id,
            ], [
                'name.required' => 'Category name is required.',
                'name.unique'   => 'This category name already exists.',
                'name.max'      => 'Category name must not exceed 255 characters.',
            ]);

            $mainCategory->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Main category updated successfully!',
                'data'    => $mainCategory,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    /**
     * Delete main category
     */
    public function destroyMainCategory(MainCategory $mainCategory): JsonResponse
    {
        try {
            $mainCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Main category deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete main category. It may have associated publications.',
                'error'   => $e->getMessage(),
            ], 400);
        }
    }

    // ── Subcategories ──────────────────────────────────────────────────────────

    /**
     * Store new subcategory
     */
    public function storeSubcategory(Request $request, MainCategory $mainCategory): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:subcategories,name,NULL,id,main_category_id,' . $mainCategory->id,
                ],
            ], [
                'name.required' => 'Subcategory name is required.',
                'name.unique'   => 'This subcategory name already exists for this category.',
                'name.max'      => 'Subcategory name must not exceed 255 characters.',
            ]);

            $subcategory = $mainCategory->subcategories()->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Subcategory created successfully!',
                'data'    => $subcategory->load('mainCategory'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    /**
     * Show edit subcategory (JSON for modal)
     */
    public function editSubcategory(Subcategory $subcategory): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $subcategory->load('mainCategory'),
        ]);
    }

    /**
     * Update subcategory
     */
    public function updateSubcategory(Request $request, Subcategory $subcategory): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:subcategories,name,' . $subcategory->id . ',id,main_category_id,' . $subcategory->main_category_id,
                ],
            ], [
                'name.required' => 'Subcategory name is required.',
                'name.unique'   => 'This subcategory name already exists for this category.',
                'name.max'      => 'Subcategory name must not exceed 255 characters.',
            ]);

            $subcategory->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Subcategory updated successfully!',
                'data'    => $subcategory,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    /**
     * Delete subcategory
     */
    public function destroySubcategory(Subcategory $subcategory): JsonResponse
    {
        try {
            $subcategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subcategory deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete subcategory.',
                'error'   => $e->getMessage(),
            ], 400);
        }
    }

    // ── AJAX Helpers ───────────────────────────────────────────────────────────

    /**
     * Get subcategories for a main category (AJAX)
     */
    public function getSubcategories(MainCategory $mainCategory): JsonResponse
    {
        $subcategories = $mainCategory->subcategories()
            ->ordered()
            ->get(['id', 'name', 'created_at', 'updated_at']);

        return response()->json([
            'success'        => true,
            'data'           => $subcategories,
            'mainCategoryId' => $mainCategory->id,
        ]);
    }

    /**
     * Get all main categories with subcategories (for publication form dropdowns)
     */
    public function getAllWithSubcategories(): JsonResponse
    {
        $mainCategories = MainCategory::with('subcategories')->ordered()->get();

        return response()->json([
            'success' => true,
            'data'    => $mainCategories,
        ]);
    }

    /**
     * Get subcategories by main category ID (for publication form AJAX)
     */
    public function getSubcategoriesByMainCategory(int $mainCategoryId): JsonResponse
    {
        try {
            $subcategories = Subcategory::where('main_category_id', $mainCategoryId)
                ->orderBy('name')
                ->get(['id', 'name']);

            return response()->json(['success' => true, 'data' => $subcategories]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load subcategories',
                'error'   => $e->getMessage(),
            ], 400);
        }
    }
}