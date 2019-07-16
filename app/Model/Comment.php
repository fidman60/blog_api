<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    protected $fillable = [
        'comment', 'evaluation', 'article_id', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

}
