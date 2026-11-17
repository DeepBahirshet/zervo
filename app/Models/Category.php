<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
    ];
   public function requirements()
    {
        return $this->hasMany(Requirement::class, 'category_id');
    }
}
