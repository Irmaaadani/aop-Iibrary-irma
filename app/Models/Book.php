<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Book extends Model
{
    use SoftDeletes;
    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description'
    ];

    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'book_categories',
            'book_id',
            'category_id'
        );
    }
}