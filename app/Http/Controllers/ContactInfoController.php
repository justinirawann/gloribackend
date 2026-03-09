<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();
        return view('admin.contact-info.index', compact('contactInfo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'email_name' => 'required|string',
            'phone' => 'required|string',
            'phone_name' => 'required|string',
            'instagram' => 'nullable|string',
            'instagram_name' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'whatsapp_name' => 'nullable|string',
            'address' => 'nullable|string'
        ]);

        $contactInfo = ContactInfo::first();
        
        if ($contactInfo) {
            $contactInfo->update($validated);
        } else {
            ContactInfo::create($validated);
        }

        return redirect()->route('admin.contact-info.index')->with('success', 'Contact information updated successfully');
    }
}
