<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SurName', 'OtherNames','UserEmail', 'Mobile', 'Password','Status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // public function userroles()
    // {
    //     return $this
    //         ->belongsToMany('App\Userrole')
    //         ->withTimestamps();
    // }

    // public function authorizeRoles($UserRole)
    //     {
    //       if ($this->hasAnyRole($roles)) {
    //             return true;
    //       }
    //           abort(401, 'This action is unauthorized.');
    //     }
    //           public function hasAnyRole($roles)
    //           {
    //              if (is_array($roles)) {
    //                   foreach ($roles as $role) {
    //                     if ($this->hasRole($role)) {
    //                     return true;
    //               }
    //           }
    //       } else {
    //         if ($this->hasRole($roles)) {
    //           return true;
    //         }
    //       }
    //       return false;
    //     }
    //     public function hasRole($role)
    //     {
    //       if ($this->roles()->where(‘name’, $role)->first()) {
    //         return true;
    //       }
    //       return false;
    //       }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
