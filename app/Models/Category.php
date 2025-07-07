<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // علاقة التصنيفات الفرعية (شجرة)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // علاقة التصنيف الأب
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function fatwas()
    {
        return $this->belongsToMany(Fatwa::class, 'category_fatwa');
    }

    public function depth()
    {
        return $this->parent ? 1 + $this->parent->depth() : 0;
    }
}