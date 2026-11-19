<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qr) use ($q) {
                $qr->where('name', 'like', "%$q%")
                   ->orWhere('email', 'like', "%$q%")
                   ->orWhere('phone', 'like', "%$q%")
                   ->orWhere('location', 'like', "%$q%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('type')) {
            $query->where('enquiry_for', $request->type);
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['name', 'email', 'phone', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';

        $enquiries = $query->orderBy($sortBy, $sortDir)->paginate(20)->withQueryString();

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function destroy($id)
    {
        Enquiry::findOrFail($id)->delete();
        return redirect()->route('admin.enquiries.index')
            ->with('success', 'Enquiry deleted!');
    }
}
