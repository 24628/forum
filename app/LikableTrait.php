<?php
/**
 * Created by PhpStorm.
 * User: Merlijn
 * Date: 14/03/2019
 * Time: 09:50
 */

namespace App;


trait LikableTrait
{

    public function likes()
    {

        return $this->morphMany(Like::class,'likable')->latest();

    }

    public function likeIt()
    {

        $like = new Like();
        $like->user_id = auth()->user()->id;

        $this->likes()->save($like);

        return $like;

    }

    public function unlikeIt()
    {

        $this->likes()->where('user_id', auth()->id())->delete();

    }

    public function isLiked()
    {

        return !!$this->likes()->where('user_id',auth()->id())->count();

    }

}