<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'description_en', 'banner_image'];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
