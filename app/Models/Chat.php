<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chat extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'sender_role',
        'receiver_role',
        'message',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // ✅ JANGAN FORMAT updated_at / created_at ke string
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->setTimezone('Asia/Jakarta');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->setTimezone('Asia/Jakarta');
    }

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getOtherUserAttribute()
    {
        $user = auth()->user();

        return $this->sender_id == $user->id
            ? $this->receiver
            : $this->sender;
    }
    
}
