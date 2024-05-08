<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    /**
     * Get the parent item of a comment
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}

class ItemComments extends Model
{
    /**
     * Get all of the items comments
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}