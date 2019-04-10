<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use CommentableTrait, LikableTrait,RecordsFeed;

    protected $fillable=['body','user_id'];

    public function commenttable()
    {

        return $this->morphTo();

    }

    public function user()
    {

        return $this->belongsTo(User::class);

    }

}
