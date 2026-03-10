<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Exhibition;
use App\Models\HeritageCollection;
use App\Models\Publication;

class SearchController extends Controller
{
    /**
     * Global live search across multiple tables.
     * Returns JSON for AJAX dropdown suggestions.
     */
    public function live(Request $request)
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $query = strip_tags(trim($request->input('q')));
        $limit = 4; // per type  (4 × 4 = max 16 dropdown rows)

        // ── Collections ────────────────────────────────────────────────────────
        $collections = Collection::query()
            ->where('access_type', 'Public')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'title_image')
            ->limit($limit)
            ->get()
            ->map(fn ($item) => [
                'type'  => 'Collection',
                'label' => $item->title,
                'image' => $item->title_image,
                'badge' => null,
                'url'   => route('client.collection.show', $item->id),
            ]);

        // ── Exhibitions ────────────────────────────────────────────────────────
        $exhibitions = Exhibition::query()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'cover_image')
            ->limit($limit)
            ->get()
            ->map(fn ($item) => [
                'type'  => 'Exhibition',
                'label' => $item->title,
                'image' => $item->cover_image,
                'badge' => null,
                'url'   => route('client.exhibition.show', $item->id),
            ]);

        // ── Heritage Collections ───────────────────────────────────────────────
        $heritage = HeritageCollection::query()
            ->where('access_type', 'Public')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'title_image')
            ->limit($limit)
            ->get()
            ->map(fn ($item) => [
                'type'  => 'Heritage',
                'label' => $item->title,
                'image' => $item->title_image,
                'badge' => null,
                'url'   => route('heritage.collection.show', $item->id),
            ]);

        // ── Publications ───────────────────────────────────────────────────────
        $publications = Publication::query()
            ->where('visibleType', 'public')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'title_image', 'price')
            ->limit($limit)
            ->get()
            ->map(fn ($item) => [
                'type'  => 'Publication',
                'label' => $item->title,
                'image' => $item->title_image,
                'badge' => $item->price == 0 ? 'Free' : '$' . number_format($item->price, 2),
                'url'   => route('client.publication.show', $item->id),
            ]);

        $results = $collections
            ->concat($exhibitions)
            ->concat($heritage)
            ->concat($publications)
            ->values();

        return response()->json([
            'results' => $results,
            'query'   => $query,
        ]);
    }

    /**
     * Full search results page.
     */
    public function results(Request $request)
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $query = strip_tags(trim($request->input('q')));

        $collections = Collection::query()
            ->where('access_type', 'Public')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'title_image', 'description')
            ->paginate(10, ['*'], 'col_page');

        $exhibitions = Exhibition::query()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'cover_image', 'description')
            ->paginate(10, ['*'], 'exh_page');

        $heritage = HeritageCollection::query()
            ->where('access_type', 'Public')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'title_image', 'description')
            ->paginate(10, ['*'], 'her_page');

        $publications = Publication::query()
            ->where('visibleType', 'public')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->select('id', 'title', 'title_image', 'content', 'price')
            ->paginate(10, ['*'], 'pub_page');

        return view('client.searchresults', compact(
            'query', 'collections', 'exhibitions', 'heritage', 'publications'
        ));
    }
}