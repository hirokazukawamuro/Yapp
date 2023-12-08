<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'followers';
    protected $fillable = ['follower_id', 'followee_id'];

    public function followings()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function followers()
    {
        return $this->belongsTo(User::class, 'followee_id');
    }
}
