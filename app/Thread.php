<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder){
            $builder->withCount('replies');
        });
    }

    protected $guarded = [];
    
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
        //return '/threads/' . $this->channel->slug . '/'. $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
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
        $this->replies()->create($reply); 
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}

