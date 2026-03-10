<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestAccess;
use App\Models\Publication;


class RequestController extends Controller
{
      public function showRequestForm($id)
    {
        $publication = Publication::findOrFail($id);
        return view('client.requestform', compact('publication'));
    }

    // Handle the request form submission
    public function submitRequest(Request $request)
    {
         // Validate the request
        $validated = $request->validate([
            'publication_id' => 'required|exists:publications,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'why' => 'required|string',
        ]);

        // Create a new request
        RequestAccess::create([
            'publication_id' => $validated['publication_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'why' => $validated['why'],
            'status' => 'pending',     // default
            'pay_status' => 'unpaid',  // default
        ]);

        return redirect()->route('client.successful')->with('success', 'Your request has been submitted!');
    }

   public function index()
{
    $orders = RequestAccess::latest()->get();

    // Get publication details manually (without relationship)
    $publicationIds = $orders->pluck('publication_id')->unique();
    $publications = Publication::whereIn('id', $publicationIds)->get()->keyBy('id');

    return view('admin.viewpublicationorders', compact('orders', 'publications'));
}

public function toggleStatus($id)
{
    $order = RequestAccess::findOrFail($id);
    $order->status = $order->status === 'Pending' ? 'Complete' : 'Pending';
    $order->save();

    return response()->json(['success' => true, 'new_status' => $order->status]);
}

}
