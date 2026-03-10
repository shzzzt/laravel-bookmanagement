<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory; //factory for seeding and testing
    protected $fillable = ['name', 'description']; //assignable attributes

    public function books() //define the relationship to Book, each category can have many books
    {
    return $this->hasMany(Book::class);
    }
}
