<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'version',
        'icon',
        'category',
        'status',
        'is_system',
        'settings',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'settings' => 'array',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isInstalled(): bool
    {
        return in_array($this->status, ['active', 'installed'], true);
    }
}
