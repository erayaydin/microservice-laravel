<?php

namespace MService\FileManagement\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bucket', 'key', 'object_url', 'filename', 'description', 'is_public', 'checksum', 'mimetype',
        'size',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public $incrementing = false;

    public $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($file) {
            if (empty($file->id)) {
                $file->id = Str::uuid()->toString();
            }
        });
    }

    public function scopeOfUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeIn24h(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subDay());
    }
}
