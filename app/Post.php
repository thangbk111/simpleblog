<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    public function getShortBodyAttribute()
    {
        $maxLen = 1000;
        $shortBody = $this->body;
        if (strlen($shortBody) > $maxLen) {
            $shortBody = substr($this->body, 0, $maxLen);
            $shortBody = substr($this->body, 0, strrpos($shortBody, ' '));
        }
        return $shortBody;
    }
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
