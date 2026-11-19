<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = ServicePackage::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tier')) {
            $query->where('tier', $request->tier);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $packages = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0',
            'tier'                => 'required|in:Basic,Premium,Pro',
            'description'         => 'nullable|string',
            'payment_button_link' => 'nullable|string|max:500',
            'image'               => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['payment_button_link'] = $validated['payment_button_link'] ?? '#';

        ServicePackage::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Service package created successfully!');
    }

    public function edit($id)
    {
        $package = ServicePackage::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = ServicePackage::findOrFail($id);

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0',
            'tier'                => 'required|in:Basic,Premium,Pro',
            'description'         => 'nullable|string',
            'payment_button_link' => 'nullable|string|max:500',
            'image'               => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Service package updated successfully!');
    }

    public function destroy($id)
    {
        ServicePackage::findOrFail($id)->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Service package deleted!');
    }

    public function toggleStatus($id)
    {
        $package = ServicePackage::findOrFail($id);
        $package->is_active = $package->is_active ? 0 : 1;
        $package->save();

        $status = $package->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Package {$status}!");
    }
}
