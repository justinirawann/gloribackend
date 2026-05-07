<?php

namespace App\Http\Controllers;

use App\Models\LandingImage;
use App\Models\AboutImage;
use App\Models\ContactInfo;
use App\Models\ClientLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteContentController extends Controller
{
    public function index()
    {
        try {
            $landingImages = LandingImage::orderBy('order')->get();
            $aboutImageTop = AboutImage::where('type', 'hero')->first();
            $aboutImageBottom = AboutImage::where('type', 'closing')->first();
            $contactInfo = ContactInfo::first();
            $clientLogos = ClientLogo::all();
            
            return view('admin.website-content.index', compact('landingImages', 'aboutImageTop', 'aboutImageBottom', 'contactInfo', 'clientLogos'));
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage(), $e->getTraceAsString());
        }
    }

    // Landing Images
    public function storeLandingImage(Request $request)
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

        return redirect()->route('admin.website-content.index')->with('success', 'Landing image berhasil ditambahkan');
    }

    public function updateLandingImage(Request $request, LandingImage $landingImage)
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

        return redirect()->route('admin.website-content.index')->with('success', 'Landing image berhasil diupdate');
    }

    public function destroyLandingImage(LandingImage $landingImage)
    {
        Storage::disk('public')->delete($landingImage->image_path);
        $landingImage->delete();
        return redirect()->route('admin.website-content.index')->with('success', 'Landing image berhasil dihapus');
    }

    // About Images
    public function updateAboutImages(Request $request)
    {
        $request->validate([
            'top_image' => 'nullable|image|max:2048',
            'bottom_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('top_image')) {
            $topImage = AboutImage::where('type', 'hero')->first();
            if ($topImage) {
                Storage::disk('public')->delete($topImage->image_path);
                $topImage->delete();
            }
            $path = $request->file('top_image')->store('about-images', 'public');
            AboutImage::create(['type' => 'hero', 'image_path' => $path]);
        }

        if ($request->hasFile('bottom_image')) {
            $bottomImage = AboutImage::where('type', 'closing')->first();
            if ($bottomImage) {
                Storage::disk('public')->delete($bottomImage->image_path);
                $bottomImage->delete();
            }
            $path = $request->file('bottom_image')->store('about-images', 'public');
            AboutImage::create(['type' => 'closing', 'image_path' => $path]);
        }

        return redirect()->route('admin.website-content.index')->with('success', 'About images berhasil diupdate');
    }

    // Contact Info
    public function updateContactInfo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'email_name' => 'nullable|string',
            'phone' => 'required|string',
            'phone_name' => 'nullable|string',
            'instagram' => 'nullable|string',
            'instagram_name' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'whatsapp_name' => 'nullable|string',
            'address' => 'required|string'
        ]);

        $contactInfo = ContactInfo::first();
        if ($contactInfo) {
            $contactInfo->update($request->all());
        } else {
            ContactInfo::create($request->all());
        }

        return redirect()->route('admin.website-content.index')->with('success', 'Contact info berhasil diupdate');
    }

    // Client Logos
    public function storeClientLogo(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048']);
        $path = $request->file('image')->store('client-logos', 'public');
        ClientLogo::create(['image_path' => $path]);
        return redirect()->route('admin.website-content.index')->with('success', 'Client logo added successfully');
    }

    public function destroyClientLogo(ClientLogo $clientLogo)
    {
        Storage::disk('public')->delete($clientLogo->image_path);
        $clientLogo->delete();
        return redirect()->route('admin.website-content.index')->with('success', 'Client logo deleted successfully');
    }
}