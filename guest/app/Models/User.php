<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    protected $table='users';

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, 
     * string>
     */
    use SoftDeletes;
    
    public function roles(){
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }
    public function markEmailAsVerified()
    {
        if ($this->hasVerifiedEmail()) {
            return false;
        }

        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();

        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    } 
  
}
