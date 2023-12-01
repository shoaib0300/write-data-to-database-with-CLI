<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'category_name',
        'sku',
        'name',
        'description',
        'short_desc',
        'price',
        'link',
        'image',
        'brand',
        'rating',
        'caffeine_type',
        'count',
        'flavored',
        'seasonal',
        'instock',
        'facebook',
        'isk_cup',
    ];
}
