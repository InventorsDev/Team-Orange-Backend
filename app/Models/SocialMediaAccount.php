<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaAccount extends Model
{
    use HasFactory;

    const PROVIDERS = [
        'GOOGLE' => 'google',
        'TWITTER' => 'twitter',
        'FACEBOOK' => 'facebook',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
