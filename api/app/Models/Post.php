<?php

namespace App\Models;

use App\Events\PostPublishedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Post extends Model
{
    use HasFactory, QueryCacheable;

    public int $cacheFor = 3600;

    public array $cacheTags = ['posts'];

    protected static bool $flushCacheOnUpdate = true;

    protected $guarded = [];

    protected $casts = [
        'publish_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function publish(): void
    {
        $this->publish_at = now();
        $this->is_published = true;
        $this->save();

        PostPublishedEvent::dispatch($this);
    }
}
