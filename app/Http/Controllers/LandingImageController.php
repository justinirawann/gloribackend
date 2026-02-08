<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LandingImageController extends Controller
{
    public function index()
    {
        $images = DB::table('landing_images')
            ->orderBy('order')
            ->get()
            ->map(function($img) {
                return url('storage/' . $img->image_path);
            });
        
        return response()->json(['images' => $images]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120'
        ]);

        $path = $request->file('image')->store('landing-images', 'public');
        
        $maxOrder = DB::table('landing_images')->max('order') ?? 0;
        
        DB::table('landing_images')->insert([
            'image_path' => $path,
            'order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['message' => 'Image uploaded successfully']);
    }

    public function destroy($id)
    {
        $image = DB::table('landing_images')->where('id', $id)->first();
        
        if ($image) {
            Storage::disk('public')->delete($image->image_path);
            DB::table('landing_images')->where('id', $id)->delete();
        }

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
