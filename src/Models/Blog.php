<?php

namespace Bitfumes\Blogg\Models;

use Bitfumes\Blogg\Tests\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Bitfumes\Likker\Contracts\Likeable;
use Bitfumes\Likker\Traits\CanBeLiked;

class Blog extends Model implements HasMedia, Likeable
{
    use HasMediaTrait, CanBeLiked;

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(config('blogg.thumb.width'))
            ->height(config('blogg.thumb.height'))
            ->sharpen(config('blogg.thumb.sharpen'));
    }

    protected $fillable = ['title', 'slug', 'body', 'published_at', 'user_id', 'category_id'];

    protected $dates = ['published_at'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::creating(function ($blog) {self::setSlug($blog);});
        self::updating(function ($blog) {self::setSlug($blog);});
    }

    /**
     * @param $blog
     */
    public static function setSlug($blog)
    {
        $blog->slug = str_slug($blog->title);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '!=', null);
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function path()
    {
        return asset("api/blog/{$this->category->slug}/{$this->slug}");
    }

    public function getImagePathAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getUrl() : null;
    }

    public function getThumbPathAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getUrl('thumb') : null;
    }
}
