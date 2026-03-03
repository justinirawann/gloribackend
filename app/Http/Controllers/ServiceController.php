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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'description_en' => 'required|string',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
            ]);

            $data = $request->only('name', 'description', 'description_en');
            
            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $request->file('banner_image')->store('banners', 'public');
            }

            Service::create($data);
            return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('error', 'Gagal menambahkan service: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Service $service)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'description_en' => 'required|string',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
            ]);

            $service->name = $validated['name'];
            $service->description = $validated['description'];
            $service->description_en = $validated['description_en'];
            
            if ($request->hasFile('banner_image')) {
                if ($service->banner_image) {
                    \Storage::disk('public')->delete($service->banner_image);
                }
                $service->banner_image = $request->file('banner_image')->store('banners', 'public');
            }

            $service->save();
            return redirect()->route('admin.services.index')->with('success', 'Service berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('error', 'Gagal update service: ' . $e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        if ($service->banner_image) {
            \Storage::disk('public')->delete($service->banner_image);
        }
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil dihapus');
    }
}
