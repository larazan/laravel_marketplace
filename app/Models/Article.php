<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Article extends Model
{
    use HasFactory;

     //
     protected $fillable = [
        'title',
        'slug',
        'article_type',
        'published_at',
        'status',
        'body',
        'user_id',
    ];

    protected $appends = [
        'category_ids', 'tags_input', 'tag_ids', 'featured_image', 'status'
    ];

    public const DRAFT = 0;
    public const ACTIVE = 1;
    public const INACTIVE = 2;
    
    public const POST = 'Post';
    public const PAGE = 'Page';

    public const STATUSES = [
        self::DRAFT => 'draft',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    public $casts = [
        'published_at' => 'datetime:d, M Y H:i',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function categoryArticles()
    {
        return $this->belongsToMany('App\Models\CategoryArticle', 'article_categories');
    }

    public function images()
    {
        return $this->morphMany('App\Models\ArticleImage', 'imageable');
    }

    // public function articleImages()
	// {
	// 	return $this->hasMany('App\Models\ArticleImage')->orderBy('id', 'DESC');
	// }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

    public function scopeActivePost($query)
    {
        return $query->where('status', self::ACTIVE)
            ->where('article_type', self::POST)
            ->where('published_at', '<=', Carbon::now());
    }

    public function getNextPostAttribute()
    {
        $nextPost = self::activePost()
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
        
        return $nextPost;
    }

    public function getPrevPostAttribute()
    {
        $prevPost = self::activePost()
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
        
        return $prevPost;
    }

    public function getCategoryIdsAttribute()
    {
        return $this->categories->pluck('id');
    }

    public function getTagsInputAttribute()
    {
        return implode(', ', $this->tags->pluck('name')->toArray());
    }

    public function getTagIdsAttribute()
    {
        return $this->tags->pluck('id');
    }

    public function getFeaturedImageAttribute()
    {
        return $this->images->count() ? asset('storage/' . $this->images->first()->large) : '';
    }

    public static function statuses()
	{
		return self::STATUSES;
	}
}
