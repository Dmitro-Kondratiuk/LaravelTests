<?php

namespace App\Logic\Helper;

use App\Models\User;

class UsersHelper
{
    public static function getUsersTable($page, $perPage,$position_id = null ): array {
        if ($position_id) {
            $users = User::with('position')
                ->where(['position_id' => $position_id])
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();

           $totalUsers = User::where(['position_id' => $position_id])
               ->count();
        }
        else {
            $users = User::with('position')
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();
            $totalUsers = User::count();
        }

        $countPages = ceil($totalUsers / $perPage);

        return ['users' => $users, 'countPages' => $countPages];
    }
}
