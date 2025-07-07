<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Fatwa extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [];

    public function toSearchableArray()
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }

    // app/Models/Fatwa.php
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function sheikh()
        {
            return $this->belongsTo(User::class, 'sheikh_id');
        }

        public function categories()
        {
            return $this->belongsToMany(Category::class, 'category_fatwa');
        }
}
