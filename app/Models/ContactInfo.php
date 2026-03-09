<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $table = 'contact_info';
    
    protected $fillable = [
        'email',
        'email_name',
        'phone',
        'phone_name',
        'instagram',
        'instagram_name',
        'whatsapp',
        'whatsapp_name',
        'address'
    ];
}
