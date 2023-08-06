<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';
    protected $primaryKey = 'email';
    protected $fillable = ['token', 'email', 'created_at'];
    public $timestamps = false;


    public function isValid()
    {
        if (now()->diffInMinutes($this->created_at) > 10) {
            return false;
        }
        return true;
    }
}
