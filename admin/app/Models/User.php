<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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
    public function role_user(){
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }
    public function checkPermission($permissionCheck){
        // Lấy quyền user
        $roles=auth()->user()->role_user;
        foreach ($roles as $role) {
            $permission= $role->permissions;
          if(  $permission->contains('key_code',$permissionCheck)){
            return true;
          }
        }
       
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
