<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'posting_id', 'user_id', 'subscriber', 'enable_highlight', 'comment'
    ];
}
