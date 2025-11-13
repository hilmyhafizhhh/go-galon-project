<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Courier extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'vehicle_info',
        'status',
        'last_known_lat',
        'last_known_lng',
    ];

    protected $casts = [
        'last_known_lat' => 'decimal:6',
        'last_known_lng' => 'decimal:6',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) $model->id = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trackingLogs()
    {
        return $this->hasMany(TrackingLog::class);
    }

    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'assigned_courier_id');
    }
}