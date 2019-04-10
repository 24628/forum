<?php
/**
 * Created by PhpStorm.
 * User: Merlijn
 * Date: 13/03/2019
 * Time: 15:13
 */

namespace App;


trait CommentableTrait
{

    public function comments()
    {

        return $this->morphMany(Comment::class,'commentable')->latest();

    }

    public function addComment($body)
    {

        $comment = new Comment();
        $comment->body = $body;
        $comment->user_id = auth()->user()->id;

        $this->comments()->save($comment);

        return $comment;

    }

}