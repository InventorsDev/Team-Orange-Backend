<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function isValid()
    {
        if (now()->diffInMinutes($this->updated_at) > 10) {
            return false;
        }
        return true;
    }


    public static function createForUser(User $user, int $length = 6, string $token = null, bool $persist = true)
    {
        if (is_null($token)) {
            $min = (int) str_pad('1', $length, '0');
            $max = (int) str_pad('9', $length, '9');

            do {
                $token = random_int($min, $max);
            } while (static::where('token', $token)->exists());
        }

        if ($persist) {
            return static::updateOrCreate(['user_id' => $user->id], [
                'user_id' => $user->id, 'token' => $token,
            ]);
        }

        return new static([
            'user_id' => $user->id,
            'token' => $token,
        ]);
    }
}
