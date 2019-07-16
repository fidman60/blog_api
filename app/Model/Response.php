<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Response extends Model{

    protected $fillable = ['response', 'user_id', 'comment_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
