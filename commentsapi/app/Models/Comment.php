<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'posting_id', 'user_id', 'enable_highlight', 'expiration_date', 'coins', 'comment', 
    ];
}
