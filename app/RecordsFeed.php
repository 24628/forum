<?php
/**
 * Created by PhpStorm.
 * User: Merlijn
 * Date: 26/03/2019
 * Time: 09:49
 */

namespace App;


trait RecordsFeed
{

    protected static function bootRecordsFeed()
    {

        static::created(function($model){
            $model->recordFeed('created');
        });

    }

    public function feeds()
    {

        return $this->morphMany(Feed::class,'feedable');

    }

    protected function recordFeed($event)
    {

        $this->feeds()->create([
            'user_id' => auth()->id(),
            'type' => $event.'_'.strtolower(class_basename($this)) // Created Thread
        ]);

    }

}