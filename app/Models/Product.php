<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'gender',
        'price',
        'original_price',
        'stock',
        'sizes',
        'icon',
        'hues',
        'tag',
        'description',
        'image',
        'images',
    ];

    protected function casts(): array
    {
        return [
            'sizes' => 'array',
            'hues' => 'array',
            'images' => 'array',
            'price' => 'integer',
            'original_price' => 'integer',
            'stock' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . rand(1000, 9999);
            }
        });
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((1 - ($this->price / $this->original_price)) * 100);
        }
        return 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price) . ' تومان';
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? number_format($this->original_price) . ' تومان' : null;
    }
}
