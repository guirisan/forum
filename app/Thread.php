<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        // lesson 23 cascade delete
        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
        //return '/threads/' . $this->channel->slug . '/'. $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        //lesson 49
        // (new \App\Spam)->detect($reply->body);

        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        // $this->notifySubscribers($reply);
        // event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function hasUpdatesFor($user = null)
    {
        $user = $user ?: auth()->user();

        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()){
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
