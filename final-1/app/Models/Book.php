<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'isbn', 'published_year', 'description', 'quantity'];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
