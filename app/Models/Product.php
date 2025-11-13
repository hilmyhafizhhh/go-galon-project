<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'category',
        'volume_ml',
        'price',
        'stock',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'volume_ml' => 'integer',
        'stock' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) $model->id = (string) Str::uuid();
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}