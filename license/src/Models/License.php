<?php

namespace MService\License\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'license_type', 'started_at', 'expired_at', 'email', 'max_file_size', 'daily_object_limit', 'quota',
    ];

    protected function casts(): array
    {
        return [
            'license_type' => LicenseType::class,
        ];
    }

    public function scopeForUser(Builder $query, string $user): Builder
    {
        return $query->where('user_id', $user);
    }

    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->where('expired_at', '>=', now());
    }
}
