<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'description_en' => 'required|string'
        ]);

        Service::create($request->only('name', 'description', 'description_en'));
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'description_en' => 'required|string'
        ]);

        $service->update($request->only('name', 'description', 'description_en'));
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil diupdate');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil dihapus');
    }
}
