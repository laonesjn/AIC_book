<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExhibitionCategory;
use App\Models\Exhibition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExhibitionCategoryController extends Controller
{
    // GET /admin/categories
    public function index(Request $request): View
    {
        $categories = ExhibitionCategory::withCount('exhibitions')
            ->when($request->filled('search'), fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $totalExhibitions          = Exhibition::count();
        $categoriesWithExhibitions = ExhibitionCategory::has('exhibitions')->count();

        return view('admin.manageexhibitioncategories', compact(
            'categories',
            'totalExhibitions',
            'categoriesWithExhibitions'
        ));
    }

    // GET /admin/categories/{category}/edit  (AJAX)
    public function edit(ExhibitionCategory $category): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data'    => [
                    'id'        => $category->id,
                    'name'      => $category->name,
                    'image_url' => $category->image ? asset($category->image) : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch category data.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // POST /admin/categories
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:exhibition_categories,name'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('exhibition_categories'), $imgName);
            $data['image'] = 'exhibition_categories/' . $imgName;
        }

        $category = ExhibitionCategory::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category "' . $category->name . '" created successfully.',
                'data'    => [
                    'id'        => $category->id,
                    'name'      => $category->name,
                    'image_url' => $category->image ? asset($category->image) : null,
                ],
            ], 201);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category "' . $category->name . '" created successfully.');
    }

    // PUT /admin/categories/{category}
    public function update(Request $request, ExhibitionCategory $category): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:exhibition_categories,name,' . $category->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $img = $request->file('image');
            $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('exhibition_categories'), $imgName);
            $data['image'] = 'exhibition_categories/' . $imgName;
        }

        $category->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully.',
                'data'    => [
                    'id'        => $category->id,
                    'name'      => $category->name,
                    'image_url' => $category->image ? asset($category->image) : null,
                ],
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // DELETE /admin/categories/{category}
    public function destroy(Request $request, ExhibitionCategory $category): JsonResponse|RedirectResponse
    {
        // Delete image file if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category "' . $category->name . '" deleted successfully.',
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }


     public function displaycategoryclient()
    {
        $categories = ExhibitionCategory::all();
        return view('client.explorexhibition', compact('categories'));
    }
}