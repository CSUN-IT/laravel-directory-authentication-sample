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
    //
    // the PK for the model is not "user_id" so it is imperative we implement
    // this method to prevent auth session problems
    public static function findForAuth($identifier) {
        return self::where('id', '=', $identifier)
            ->first();
    }

    // implements MetaAuthenticatableContract#findForAuthToken
    //
    // the PK for the model is not "user_id" so it is imperative we implement
    // this method to prevent auth session problems
    public static function findForAuthToken($identifier, $token) {
        return self::where('id', '=', $identifier)
            ->where('remember_token', '=', $token)
            ->first();
    }
}
