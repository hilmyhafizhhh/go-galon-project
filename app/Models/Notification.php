<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'sent_at',
        'read_flag',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'read_flag' => 'boolean',
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
}