<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientLogoController extends Controller
{
    public function index()
    {
        $logos = ClientLogo::all();
        return view('admin.client-logos.index', compact('logos'));
    }

    public function store(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048']);
        $path = $request->file('image')->store('client-logos', 'public');
        ClientLogo::create(['image_path' => $path]);
        return redirect()->route('admin.client-logos.index')->with('success', 'Logo berhasil ditambahkan');
    }

    public function destroy(ClientLogo $clientLogo)
    {
        Storage::disk('public')->delete($clientLogo->image_path);
        $clientLogo->delete();
        return redirect()->route('admin.client-logos.index')->with('success', 'Logo berhasil dihapus');
    }
}
