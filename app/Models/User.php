<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use App\Notifications\SetPassword;
use App\Models\Scopes\ActiveUserScope;

class User extends Authenticatable
{
    use Notifiable;

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveUserScope);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'doc_type',
        'doc_num',
        'phone',
        'email',
        'password',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token, $signUp = false)
    {
        $guard = 'user';
        $email = $this->email;
        $uri = route('password.reset', compact('guard', 'token', 'signUp', 'email'));

        $signUp ? $this->notify(new setPassword($uri))
                : $this->notify(new ResetPassword($uri));
    }

    public function indications()
    {
        return $this->hasMany(Company::class, 'user_id');
    }
}
