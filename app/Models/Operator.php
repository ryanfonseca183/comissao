<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use App\Notifications\SetPassword;

class Operator extends Authenticatable
{
    use Notifiable;

    protected $guard = "admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'isAdmin',
        'password',
        'remember_token',
    ];

    public function sendPasswordResetNotification($token, $signUp = false)
    {
        $guard = 'user';
        $email = $this->email;
        $uri = route('password.reset', compact('guard', 'token', 'signUp', 'email'));

        $signUp ? $this->notify(new setPassword($uri))
                : $this->notify(new ResetPassword($uri));
    }
}
