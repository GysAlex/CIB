<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BlogPost extends Model implements HasMedia
{

    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'content',
        'meta_description',
        'status',
        'published_at',
        'user_id',
        'blog_category_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function blogTags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blog_posts')
        ->useDisk('public')
        ->singleFile();
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('status', 'published');
    }
}
