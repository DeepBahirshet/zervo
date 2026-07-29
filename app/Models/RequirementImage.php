<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirementImage extends Model
{
    protected $fillable = [
        'requirement_id',
        'image'
    ];

    public function requirement(){
        return $this->belongsTo(Requirement::class);
    }
}
