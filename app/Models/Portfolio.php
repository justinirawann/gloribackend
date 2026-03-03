<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['service_id', 'name', 'description', 'description_en', 'banner_image', 'category'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function images()
    {
        return $this->hasMany(PortfolioImage::class);
    }

    public function displayedImages()
    {
        return $this->hasMany(PortfolioImage::class)->where('is_displayed', true)->orderBy('display_order');
    }
}
