<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
