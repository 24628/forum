<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;

class Thread extends Model
{
    use CommentableTrait,RecordsFeed;
    protected  $fillable = ['subject', 'type', 'thread', 'user_id'];

    public static function boot()
    {

        parent::boot();

    }

    public function user()
    {

        return $this->belongsTo(User::class);

    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
