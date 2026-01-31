<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Book;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['name'];

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'book_categories',
            'category_id',
            'book_id'
        );
    }
}
