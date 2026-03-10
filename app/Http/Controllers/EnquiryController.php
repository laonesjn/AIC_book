<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    public function create()
    {
        return view('client.contactus', $this->generateCaptcha());
    }

    // AJAX refresh
    public function refreshCaptcha()
{
    $a = rand(1, 9);
    $b = rand(1, 9);

    session()->put('math_captcha', $a + $b);

    return response()->json([
        'a' => $a,
        'b' => $b
    ])->header('Cache-Control', 'no-store');
}


      public function index()
    {
        $enquiries = Enquiry::orderBy('created_at', 'desc')->get();
        return view('admin.enquiry', compact('enquiries'));
    }

    private function generateCaptcha()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);

        Session::put('math_captcha', $a + $b);

        return compact('a', 'b');
    }

    public function store(Request $request)
    {
        // Check CAPTCHA
        if ((int)$request->captcha_answer !== (int)session('math_captcha')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['captcha_answer' => ['The CAPTCHA you entered is incorrect. Please check it and try again.']]
                ], 422);
            }
            return back()
                ->withErrors(['captcha_answer' => 'The CAPTCHA you entered is incorrect. Please check it and try again.'])
                ->withInput();
        }

        // Validate
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:100',
                'email'   => 'required|email|max:150',
                'subject' => 'required|string|max:200',
                'phone'         => 'nullable|string|max:20',
                'full_phone'    => 'nullable|string|max:20',
                'country_name'  => 'nullable|string|max:255',
                'message'       => 'required|string|max:1000',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        // Create Enquiry
        Enquiry::create($validated);

        // Clear CAPTCHA
        session()->forget('math_captcha');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thanks! Your message was sent 🎉'
            ]);
        }

        return back()->with('success', 'Thanks! Your message was sent 🎉');
    }

    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('admin.enquiries.show', compact('enquiry'));
    }

    
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->status = $request->status;
        $enquiry->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}

