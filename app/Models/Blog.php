<?php

namespace App\Models;

use App\User;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Blog extends Model implements ViewableContract
{
    use Viewable;
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'secretkey',
        'errorlog',
        'category',
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
            $post->comments()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
