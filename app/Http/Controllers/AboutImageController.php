<?php

namespace App\Http\Controllers;

use App\Models\AboutImage;
use Illuminate\Http\Request;

class AboutImageController extends Controller
{
    public function index()
    {
        $heroImage = AboutImage::where('type', 'hero')->first();
        $closingImage = AboutImage::where('type', 'closing')->first();
        
        return view('admin.about-images.index', compact('heroImage', 'closingImage'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|in:hero,closing',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
        ]);

        $image = AboutImage::where('type', $request->type)->first();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($image && $image->image_path) {
                \Storage::disk('public')->delete($image->image_path);
            }

            $path = $request->file('image')->store('about_images', 'public');

            if ($image) {
                $image->update(['image_path' => $path]);
            } else {
                AboutImage::create([
                    'type' => $request->type,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.about-images.index')->with('success', ucfirst($request->type) . ' image updated successfully');
    }
}
