<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'service_id',
        'message',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
