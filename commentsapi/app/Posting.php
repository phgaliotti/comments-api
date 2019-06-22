<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Posting extends Model
{
    protected $table = 'posting';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
