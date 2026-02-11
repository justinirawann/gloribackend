<?php

namespace App\Http\Controllers;

use App\Models\LandingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingImageController extends Controller
{
    public function index()
    {
        $images = LandingImage::orderBy('order')->get();
        return view('admin.landing-images.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'order' => 'nullable|integer'
        ]);

        $path = $request->file('image')->store('landing-images', 'public');

        LandingImage::create([
            'image_path' => $path,
            'order' => $request->order ?? 0
        ]);

        return redirect()->route('admin.landing-images.index')->with('success', 'Image berhasil ditambahkan');
    }

    public function update(Request $request, LandingImage $landingImage)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($landingImage->image_path);
            $path = $request->file('image')->store('landing-images', 'public');
            $landingImage->image_path = $path;
        }

        $landingImage->order = $request->order ?? $landingImage->order;
        $landingImage->save();

        return redirect()->route('admin.landing-images.index')->with('success', 'Image berhasil diupdate');
    }

    public function destroy(LandingImage $landingImage)
    {
        Storage::disk('public')->delete($landingImage->image_path);
        $landingImage->delete();

        return redirect()->route('admin.landing-images.index')->with('success', 'Image berhasil dihapus');
    }
}
