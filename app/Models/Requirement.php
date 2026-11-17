
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category_id',
        'category',
        'description',
        'budget',
        'location',
        'status',
        'work_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function images()
    {
        return $this->hasMany(RequirementImage::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
