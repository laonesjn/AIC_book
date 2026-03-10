<?php
// FILE: app/Http/Controllers/PublicationController.php (UPDATED)

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\MainCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Collection;
use App\PDF\FpdiWithRotate;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    /**
     * Display publications for client with filtering
     */

     public function downloadPublicatio(int $id)
    {
        $publication = Publication::findOrFail($id);

        if ($publication->visibleType !== 'public') {
            abort(403, 'This document is not publicly accessible.');
        }

        if (!$publication->pdf) {
            abort(404, 'No PDF attached to this publication.');
        }

        $filePath = public_path($publication->pdf);

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
    public function index(Request $request)
    {
        $mainCategories = MainCategory::with('subcategories')
            ->ordered()
            ->get();
        
        $subcategories = collect();

        // Build query
        $query = Publication::with(['mainCategory', 'subcategory'])
            ->orderBy('created_at', 'desc');

        // Filter by main category
        if ($request->filled('main_category')) {
            $query->where('main_category_id', $request->main_category);
            $subcategories = Subcategory::where('main_category_id', $request->main_category)
                ->ordered()
                ->get();
        }

        // Filter by subcategory
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        // Use paginate instead of get()
        $publications = $query->paginate(6)->through(function ($publication) {
            if ($publication->visibleType === 'private' || $publication->price != 0) {
                $publication->pdf = null;
            }
            return $publication;
        });

        return view('client.publication', compact('publications', 'mainCategories', 'subcategories'));
    }

    /**
     * AJAX: Filter publications
     */
    public function filter(Request $request)
    {
        $query = Publication::with(['mainCategory', 'subcategory'])
            ->orderBy('created_at', 'desc');
        
        if ($request->filled('main_category')) {
            $query->where('main_category_id', $request->main_category);
        }
        
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }
        
        // Use paginate instead of get()
        $publications = $query->paginate(6)->through(function ($publication) {
            if ($publication->visibleType === 'private' || $publication->price != 0) {
                $publication->pdf = null;
            }
            return $publication;
        });

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            $html = view('client.partials.publications-grid', compact('publications'))->render();
            
            return response()->json([
                'html' => $html,
                'count' => $publications->total(),
                'publications' => $publications->items()
            ]);
        }

        // Fallback to regular view
        $mainCategories = MainCategory::with('subcategories')
            ->ordered()
            ->get();
        $subcategories = $request->filled('main_category') 
            ? Subcategory::where('main_category_id', $request->main_category)
                ->ordered()
                ->get() 
            : collect();
        
        return view('client.publication', compact('publications', 'mainCategories', 'subcategories'));
    }

    /**
     * API: Get subcategories by main category (for forms)
     */
    public function getSubcategoriesByMainCategory($mainCategoryId)
    {
        $subcategories = Subcategory::where('main_category_id', $mainCategoryId)
            ->ordered()
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $subcategories
        ]);
    }

    /**
     * Display publications for admin
     */
    public function adminindex()
    {
        $publications = Publication::with(['mainCategory', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $mainCategories = MainCategory::with('subcategories')
            ->ordered()
            ->get();
        
        return view('admin.viewpublications', compact('publications', 'mainCategories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $mainCategories = MainCategory::with('subcategories')
            ->ordered()
            ->get();
        
        return view('admin.addpublications', compact('mainCategories'));
    }

    /**
     * Store new publication
     */
   public function store(Request $request)
{
    $rules = [
        'title' => 'required|string|max:255',
        'title_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'content' => 'required|string',
        'main_category_id' => 'required|exists:main_categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'type' => 'required|in:Free,Price',
        'visibleType' => 'required|in:public,private', // 👈 ADMIN CHOICE
        'pdf' => 'nullable|mimes:pdf|max:10240',
    ];

    if ($request->type === 'Price') {
        $rules['price'] = 'required|numeric|min:0.01';
    }

    $validated = $request->validate($rules);

    // Subcategory belongs to main category check
    $subcategory = Subcategory::findOrFail($validated['subcategory_id']);
    if ($subcategory->main_category_id != $validated['main_category_id']) {
        return back()
            ->withInput()
            ->withErrors([
                'subcategory_id' => 'Selected subcategory does not belong to the selected main category.'
            ]);
    }

    // Upload title image
    if ($request->hasFile('title_image')) {
        $ti = $request->file('title_image');
        $tiName = uniqid() . '.' . $ti->getClientOriginalExtension();
        $ti->move(public_path('publications/images'), $tiName);
        $validated['title_image'] = 'publications/images/' . $tiName;
    }

    // Upload PDF
    if ($request->hasFile('pdf')) {
        $pdf = $request->file('pdf');
        $pdfName = uniqid() . '.' . $pdf->getClientOriginalExtension();
        $pdf->move(public_path('publications/pdfs'), $pdfName);
        $validated['pdf'] = 'publications/pdfs/' . $pdfName;
    }

    // Price logic
    $validated['price'] = $request->type === 'Free'
        ? 0
        : (float) $request->price;

    // ❌ NO AUTO PRIVATE / PUBLIC
    // ✔ Admin selection will be saved directly

    Publication::create($validated);

    return redirect()->route('admin.publications.view')
        ->with('success', 'Publication created successfully!');
}


    /**
     * Update publication
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'main_category_id' => 'required|exists:main_categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'nullable|numeric|min:0',
            'visibleType' => 'required|in:public,private',
            'pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        // Verify subcategory belongs to selected main category
        $subcategory = Subcategory::findOrFail($validated['subcategory_id']);
        if ($subcategory->main_category_id != $validated['main_category_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Selected subcategory does not belong to the selected main category.'
            ], 422);
        }

        $publication->title = $validated['title'];
        $publication->content = $validated['content'];
        $publication->main_category_id = $validated['main_category_id'];
        $publication->subcategory_id = $validated['subcategory_id'];
        $publication->price = $validated['price'] ?? 0;
        $publication->visibleType = $validated['visibleType'];

        // Handle title image
        if ($request->hasFile('title_image')) {
            if ($publication->title_image && file_exists(public_path($publication->title_image))) {
                unlink(public_path($publication->title_image));
            }
            $ti = $request->file('title_image');
            $tiName = uniqid() . '.' . $ti->getClientOriginalExtension();
            $ti->move(public_path('publications/images'), $tiName);
            $publication->title_image = 'publications/images/' . $tiName;
        }

        // Handle PDF
        if ($request->hasFile('pdf')) {
            if ($publication->pdf && file_exists(public_path($publication->pdf))) {
                unlink(public_path($publication->pdf));
            }
            $pdf = $request->file('pdf');
            $pdfName = uniqid() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('publications/pdfs'), $pdfName);
            $publication->pdf = 'publications/pdfs/' . $pdfName;
        }

        $publication->save();
        $publication->load(['mainCategory', 'subcategory']);

        return response()->json([
            'success' => true,
            'message' => 'Publication updated successfully!',
            'publication' => [
                'id' => $publication->id,
                'title' => $publication->title,
                'content' => $publication->content,
                'main_category_id' => $publication->main_category_id,
                'main_category_name' => $publication->mainCategory->name,
                'subcategory_id' => $publication->subcategory_id,
                'subcategory_name' => $publication->subcategory->name,
                'price' => $publication->price,
                'price_label' => $publication->price_label,
                'visibleType' => ucfirst($publication->visibleType),
                'title_image' => asset($publication->title_image),
                'pdf' => $publication->pdf ? asset($publication->pdf) : null,
            ]
        ]);
    }

    /**
     * Delete publication
     */
    public function destroy(Publication $publication)
    {
        try {
            if ($publication->title_image && file_exists(public_path($publication->title_image))) {
                unlink(public_path($publication->title_image));
            }
            if ($publication->pdf && file_exists(public_path($publication->pdf))) {
                unlink(public_path($publication->pdf));
            }

            $publication->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Publication deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete publication.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}