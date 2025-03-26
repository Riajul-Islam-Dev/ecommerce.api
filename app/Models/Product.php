<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     required={"name", "description", "price", "category"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Wireless Headphones"),
 *     @OA\Property(property="description", type="string", example="Noise-cancelling Bluetooth headphones"),
 *     @OA\Property(property="price", type="number", format="float", example=199.99),
 *     @OA\Property(property="category", type="string", example="Electronics"),
 *     @OA\Property(property="imageUrl", type="string", format="url", example="https://example.com/headphones.jpg")
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image_url'
    ];

    protected $hidden = ['image_url'];

    protected $appends = ['imageUrl'];

    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'];
    }

    public function setImageUrlAttribute($value)
    {
        $this->attributes['image_url'] = $value;
    }
}
