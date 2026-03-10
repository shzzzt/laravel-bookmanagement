<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'isbn',
        'price',
        'stock_quantity',
        'description',
        'cover_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class); // Define the relationship to Category,  each book belongs to one category
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class); 
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    // Accessor for average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0; //return the average rating or 0 if there are no reviews

    }
}
