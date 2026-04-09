<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'title', 'industry', 'rating', 'description', 'project_date', 'portfolio_id'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
