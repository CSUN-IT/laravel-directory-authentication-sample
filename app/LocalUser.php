<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use CSUNMetaLab\Authentication\MetaUser;

class LocalUser extends MetaUser
{
    use Notifiable;

    protected $table = "local_users";
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // implements MetaAuthenticatableContract#findForAuth
    public static function findForAuth($identifier) {
        return self::where('id', '=', $identifier)
            ->first();
    }

    // implements MetaAuthenticatableContract#findForAuthToken
    public static function findForAuthToken($identifier, $token) {
        return self::where('id', '=', $identifier)
            ->where('remember_token', '=', $token)
            ->first();
    }
}
