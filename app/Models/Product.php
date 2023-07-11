<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define the table name if different from "products"
    protected $table = 'products';

    // Define the fillable fields
    protected $fillable = [
        'name',
        'price',
        'description',
        // Add more fields as per your product model
    ];
}
