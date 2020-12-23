<?php

namespace App\Models;

use App\User;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Lang;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Post extends Model implements ViewableContract
{
    use Viewable;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'lang_id',
        'category_id',
        'classification',
        'attached',
        'is_published'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if(is_null($post->user_id)) {
                $post->user_id = auth()->user()->id;
            }
        });

        static::deleting(function ($post) {
            $post->tags()->detach();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

    public function test()
    {
        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDrafted($query)
    {
        return $query->where('is_published', false);
    }

    public function getPublishedAttribute()
    {
        return ($this->is_published) ? 'Yes' : 'No';
    }
}
