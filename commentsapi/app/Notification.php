<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'text', 'from_user_id', 'to_user_id', 'read'
    ];
}
