<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'requirement_id',
        'owner_id',
        'provider_id',
        'rating',
        'review',
    ];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}