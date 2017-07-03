<?php 

namespace App;

trait Favoritable
{
    
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $user_id = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($user_id)->exists()){
            return $this ->favorites()->create($user_id);
        }
    }

    public function isFavorited()
    {
        // !! casts to boolean
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Allows to use $reply->favorites_count from view (reply.blade.php l.17)
     * @return int Favorites count for reply
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

}
