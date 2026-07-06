<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    /** @use HasFactory<\Database\Factories\RequirementFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'budget',
        'location',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
