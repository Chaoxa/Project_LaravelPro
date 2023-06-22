<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function hasPermission($permissions)
    {
        $user = User::find(session('userID'));
        foreach ($user->roles as $role) {
            foreach ($permissions as $permission) {
                if ($role->permissions()->where('slug', $permission)->count() > 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
